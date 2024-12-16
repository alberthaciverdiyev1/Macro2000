<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function check_user($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users'); 
        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user; 
        } else {
            return false;
        }
    }

    public function register_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id(); 
    }
}
