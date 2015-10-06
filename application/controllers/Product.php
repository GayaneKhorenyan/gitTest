<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('products_model');
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
     * User products with pagination.
     */
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
            $config["total_rows"] = $this->products_model->get_user_products_count($uid);
            $config["per_page"] = 7;
            $config["uri_segment"] = 3;
            $config['use_page_numbers'] = TRUE;
            $config['cur_tag_open'] = '<a>';
            $config['attributes'] = array('class' => 'btn btn-default btn-sm');

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $data['title'] = 'Products';
            $data["results"] = $this->products_model->
                get_user_limited_products($uid,$config["per_page"], $page);
            $data["links"] = $this->pagination->create_links();

            $this->load->view('header',$data);
            $this->load->view('nav_block',$data);
            $this->load->view("products", $data);
            $this->load->view('footer',$data);
        }
    }

    /**
     * All products with pagination.
     */
    public function all_products()
    {
        $this->load->helper("url");
        $this->load->model("products_model");
        $this->load->library("pagination");

        $config = array();
        $config["base_url"] = base_url("Product/user_products");
        $config["total_rows"] = $this->products_model->get_products_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['cur_tag_open'] = '<a>';
        $config['attributes'] = array('class' => 'btn btn-default btn-sm');

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['title'] = 'All Products';
        $data["results"] = $this->products_model->get_limited_products($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        if($this->session->userdata('user_id'))
        {
            $this->load->view('header',$data);
            $this->load->view('nav_block',$data);
            $this->load->view("products", $data);
            $this->load->view('footer',$data);
        }
        else
        {
            $this->load->view('header',$data);
            $this->load->view("products", $data);
            $this->load->view('footer',$data);
        }
    }

    /**
     * Add product.
     *
     * @return function
     */
    public function add_product()
    {
        $status = 'error';
        $uid = $this->session->userdata('user_id');

        if(!empty($uid))
        {
            $config['upload_path']   = "./uploads/";
            $config['allowed_types'] = "gif|jpg|png|jpeg";

            $this->load->library('upload',$config);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('prod_name','Name','trim|required|min_length[4]|max_length[50]');
            $this->form_validation->set_rules('description','Description','trim|required|min_length[4]|max_length[255]');
            $this->form_validation->set_rules('location','Location','trim|required|min_length[4]|max_length[255]');
            $this->form_validation->set_rules('price','Price','trim|required|integer|min_length[1]|max_length[8]');
            $this->form_validation->set_rules('image','Image','callback_handle_upload');

            if(!$this->form_validation->run())
            {
                $status = 'success';
                $this->load->model('categories_model');

                if($categories = $this->categories_model->get_categories())
                {
                    $data['categories'] = $categories;
                    $json['content'] = $this->load->view('add_product',$data,true);
                }
                else
                {
                    $json['msg'] = "There isn't any category";
                }
            }
            else
            {
                $data = $this->input->post();
                $data['user_id'] = $uid;
                $data['image'] = $this->upload->data('file_name');

                if($this->products_model->add_product($data))
                    $status = 'success';
            }
        }

        $json['status'] = $status;

        $this->output->set_content_type('application/json');
        return $this->output->set_output(json_encode($json));
    }

    /**
     * Get product.
     *
     * @return function
     */
    public function get_product()
    {
        $status = 'error';
        $pid = $this->input->post('pid');

        if(!empty($pid))
        {
            if($product = $this->products_model->get_product_by_id($pid))
            {
                $this->load->model('categories_model');

                if($category = $this->categories_model->get_category_by_id($product->cat_id))
                {
                    $data['cat_name'] = $category->name;
                }
                $data['product'] = $product;

                $json['product'] = $this->load->view('product_block',$data,true);
                $status  = 'success';
            }
        }

        $json['status'] = $status;

        $this->output->set_content_type('application/json');
        return $this->output->set_output(json_encode($json));
    }

}
