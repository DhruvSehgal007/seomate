<?php
// Model: Login_model.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function check_login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
    
        if ($query->num_rows() === 1) {
            $user = $query->row();
            // Direct comparison without password hashing (not secure for production)
            if ($password === $user->password) {
                return $user;
            }
        }
        return false;
    }
    
}
?>
