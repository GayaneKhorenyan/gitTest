<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Delete_cdusers extends CI_Migration
{

    public function up()
    {
        $this->dbforge->drop_table('cdusers');
    }

    public function down()
    {
        $this->dbforge->drop_table('cdusers');
    }
}