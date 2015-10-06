<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }

    /**
     * User registration.
     */
	public function registration()
	{
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[4]');
        $this->form_validation->set_rules('last_name','Last Name','trim|required|min_length[4]');
        $this->form_validation->set_rules('email','Email','trim|required|min_length[4]|valid_email');
        $this->form_validation->set_rules('password','Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('con_password','Password Confirmation','trim|required|matches[password]');
        $this->form_validation->set_rules('image','Image','callback_handle_upload');

        if(!$this->form_validation->run())
        {
            $data['title'] = 'Registration';
            $this->load->view('header',$data);
            $this->load->view('registration',$data);
            $this->load->view('footer',$data);
        }
        else
        {
            $data = $this->input->post();
            $data['image'] = $this->upload->data('file_name');

            $this->users_model->add_user($data);
            $this->users_model->login($data['email'],md5($data['password']));

            redirect('User/index');
        }
	}

    /**
     * Index page.
     */
    public function index()
    {
        if($this->session->userdata('user_id'))
        {
            $data['title'] = 'Home';

            $this->load->view('header',$data);
            $this->load->view('nav_block',$data);
            $this->load->view('index',$data);
            $this->load->view('footer',$data);
        }
        else
            redirect('User/login');
    }

    /**
     * Users login.
     */
    public function login()
    {
        if(!$this->session->userdata('user_id'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email','Email','trim|required|min_length[4]|valid_email');
            $this->form_validation->set_rules('password','Password', 'required|trim|max_length[200]|callback_check_username_password');

            if($this->form_validation->run())
            {
                redirect('User/index');
            }
            else
            {
                $data['title'] = 'Login';
                $this->load->view('header',$data);
                $this->load->view('login',$data);
                $this->load->view('footer',$data);
            }
        }
    }

    /**
     * Logout.
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect('User/login');
    }

    /**
     * File validation and upload.
     *
     * @return boolean
     */
    public function handle_upload()
    {
        if (isset($_FILES['image']) && !empty($_FILES['image']['name']))
        {
            $config['upload_path']   = "./uploads/";
            $config['allowed_types'] = "gif|jpg|png";

            $this->load->library('upload',$config);

            if ($this->upload->do_upload('image'))
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('handle_upload', $this->upload->display_errors());
                return false;
            }
        }
        else
        {
            $this->form_validation->set_message('handle_upload', "You must upload an image!");
            return false;
        }
    }

    /**
     * Username and Password validation.
     *
     * @return boolean
     */
    public function check_username_password()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $remember = $this->input->post('remember');

        if(!$this->users_model->login($email,$password,$remember))
        {
            $this->session->set_flashdata('login_error',TRUE);
            $this->form_validation->set_message('check_username_password', 'Sorry Username or Password is not correct.');
            return false;
        }
        return true;
    }

}
