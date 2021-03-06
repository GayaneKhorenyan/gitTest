<?php

class Users_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add user.
     *
     * @param  array  $data
     * @return boolean
     */
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

        if($this->db->affected_rows())
        {
            return true;
        }
        return false;
    }

    /**
     * User login.
     *
     * @param  string  $email
     * @param  string  $pass
     * @param  int or null  $remember
     * @return boolean
     */
    public function login($email,$pass,$remember = null)
    {
        $query = $this->db->where(['email'=>$email,'password'=>$pass])->get('users');

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $user_data = [
                    'user_id'=>$row->id,
                    'first_name'=>$row->first_name,
                    'last_name'=>$row->last_name,
                    'email'=>$row->email,
                    'is_logged'=>true,
                ];

                if($remember)
                {
                    $this->session->sess_expiration = '14400';
                }
                $this->session->set_userdata($user_data);

                return true;
            }
        }
        return false;
    }
}