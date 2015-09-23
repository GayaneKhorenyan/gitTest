<?php

class Users_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public  function get_users() {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function add_user($data)
    {
        $user_data = [
            'first_name'=>$data['first_name'],
            'last_name'=>$data['last_name'],
            'email'=>$data['email'],
            'password'=>md5($data['password']),
            'image'=>$data['image']
        ];
        $this->db->insert('users',$user_data);
    }

    public function login($email,$pass,$remember=null)
    {
        $this->db->where('email',$email);
        $this->db->where('password',$pass);
        $query = $this->db->get('users');
        if($query->num_rows()>0)
        {
            foreach($query->result() as $row)
            {
                $user_data = [
                    'user_id'=>$row->id,
                    'first_name'=>$row->first_name,
                    'last_name'=>$row->last_name,
                    'email'=>$row->email,
                    'loggin'=>true,
                ];
                if($remember)
                    $this->session->sess_expiration = '14400';
                $this->session->set_userdata($user_data);
                return true;
            }
        }
        return false;
    }

    public function pass_email_comp($email,$pass)
    {

    }
}