<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => TRUE
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'image' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }

    public function down()
    {
//        $sql_delete_prod = "DELETE FROM product WHERE  user_id IN (SELECT id FROM users)";
//        $this->db->query($sql_delete_prod);
//
//        if($this->db->affected_rows())
            $this->dbforge->drop_table('users');
    }
}