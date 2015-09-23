<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }

	public function registration()
	{
        $config['upload_path']   = "./uploads/";
        $config['allowed_types'] = "gif|jpg|png";
        $this->load->library('upload',$config);
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
            $this->users_model->add_user($data);
            $this->users_model->login($data['email'],$data['password']);
            $this->site();
        }
	}

    public function site()
    {   if($this->session->userdata('loggin'))
        {
            $data['title'] = 'Site';
            $this->load->view('header',$data);
            $this->load->view('index',$data);
            $this->load->view('footer',$data);
        }
        else
            $this->signin();
    }

    public function signin()
    {
        $data['title'] = 'Login';
        $this->load->view('header',$data);
        $this->load->view('login',$data);
        $this->load->view('footer',$data);
    }

    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email','trim|required|min_length[4]|valid_email');
        $this->form_validation->set_rules('password','Password', 'required|trim|max_length[200]|callback_checkUsernamePassword');

        if($this->form_validation->run())
        {
            $this->site();
        }
        else
            $this->signin();
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('User/login');
    }

    public function handle_upload()
    {
        if (isset($_FILES['image']) && !empty($_FILES['image']['name']))
        {

            if ($this->upload->do_upload('image'))
            {
                $upload_data    = $this->upload->data();
                $_POST['image'] = $upload_data['file_name'];
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

    public function checkUsernamePassword()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $remember = $this->input->post('remember');
        if(!$this->users_model->login($email,$password,$remember))
        {
            $this->session->set_flashdata('login_error',TRUE);
            $this->form_validation->set_message('checkUsernamePassword', 'Sorry Username or Password is not correct.');
            return false;
        }
        return true;
    }
}
