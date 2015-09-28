<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

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
            $this->users_model->login($data['email'],md5($data['password']));

            redirect('User/site');
        }
	}

    public function site()
    {
        if($this->session->userdata('is_logged'))
        {
            $this->load->model('products_model');

            $data['products'] = $this->products_model->get_user_products($this->session->userdata('user_id'));
            $data['title'] = 'Site';

            $this->load->view('header',$data);
            $this->load->view('nav_block',$data);
            $this->load->view('index',$data);
            $this->load->view('footer',$data);
        }
        else
            redirect('User/login');
    }

    public function login()
    {
        if(!$this->session->userdata('user_id'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email','Email','trim|required|min_length[4]|valid_email');
            $this->form_validation->set_rules('password','Password', 'required|trim|max_length[200]|callback_check_username_password');

            if($this->form_validation->run())
            {
                redirect('User/site');
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

    public function user_products()
    {
        $uid = $this->session->userdata('user_id');

        if(!empty($uid))
        {
            $this->load->helper("url");
            $this->load->model("products_model");
            $this->load->library("pagination");

            $config = array();
            $config["base_url"] = base_url("User/user_products");
            $config["total_rows"] = $this->products_model->user_product_count($uid);
            $config["per_page"] = 5;
            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $data['title'] = 'Products';
            $data["results"] = $this->products_model->
                user_fetch_products($uid,$config["per_page"], $page);
            $data["links"] = $this->pagination->create_links();

            $this->load->view('header',$data);
            $this->load->view('nav_block',$data);
            $this->load->view("products", $data);
            $this->load->view('footer',$data);
        }
    }

    public function add_product()
    {
        $status = 'error';
        $uid = $this->session->userdata('user_id');

        if(!empty($uid))
        {
            $config['upload_path']   = "./uploads/";
            $config['allowed_types'] = "gif|jpg|png";

            $this->load->library('upload',$config);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('prod_name','Name','trim|required|min_length[4]|max_length[50]');
            $this->form_validation->set_rules('description','Description','trim|required|min_length[4]|max_length[255]');
            $this->form_validation->set_rules('location','Location','trim|required|min_length[4]|max_length[255]');
            $this->form_validation->set_rules('price','Price','trim|required|integer|min_length[1]|max_length[10]');
            $this->form_validation->set_rules('image','Image','callback_handle_upload');

            if(!$this->form_validation->run())
            {
                $status = 'success';
                $this->load->model('categories_model');

                if($this->categories_model->get_categories_list())
                {
                    $data['categories'] = $this->categories_model->get_categories_list();
                    $json['content'] = $this->load->view('add_product',$data,true);
                }
                else
                    $json['content'] = "There aren't any category";
            }
            else
            {
                $data = $this->input->post();
                $data['user_id'] = $uid;

                $this->load->model('products_model');
                if($this->products_model->add_products($data))
                    $status = 'success';
            }
        }

        $json['status'] = $status;
        $this->output->set_content_type('application/json');
        return $this->output->set_output(json_encode($json));
    }

    public function view_products()
    {
        $status = 'error';
        $pid = $this->input->post('pid');

        if(!empty($pid))
        {
            $this->load->model('products_model');

            if($product = $this->products_model->get_product($pid))
            {
                $this->load->model('categories_model');
                if($cat_name = $this->categories_model->get_category($product->cat_id))
                    $data['cat_name'] = $cat_name;
                $data['product'] = $product;

                $json['product'] = $this->load->view('view_product',$data,true);
                $status  = 'success';
            }
        }

        $json['status'] = $status;
        $this->output->set_content_type('application/json');
        return $this->output->set_output(json_encode($json));
    }
    public function reg()
    {
        $data['title'] = 'Registration';
        $this->load->view('header',$data);
        $this->load->view('registration_new',$data);
        $this->load->view('footer',$data);
    }
}
