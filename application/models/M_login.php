<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

    public function getUserByUsername($username)
    {
        $query = $this->db->get_where('users', array('username' => $username))->row_array();
        return $query;
    }
}

/* End of file ModelName.php */