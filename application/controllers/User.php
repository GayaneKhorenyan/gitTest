<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

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
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));
            $this->users_model->login($email,$password);
            $this->index();
        }
        else
        {
            $data = $this->input->post();
            $this->users_model->add_user($data);
            $this->site();
        }
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

    public function index()
    {

        if(!$this->session->userdata('user_id'))
           $this->login();
        else
            $this->site();
    }

    public function site()
    {
        $data['title'] = 'Site';
        $this->load->view('header',$data);
        $this->load->view('index',$data);
        $this->load->view('footer',$data);
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        if($this->users_model->login($email,$password))
        {
            $this->site();
        }
        else
        {
            $data['title'] = 'Login';
            $this->load->view('header',$data);
            $this->load->view('login',$data);
            $this->load->view('footer',$data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('User/login');
    }
}
