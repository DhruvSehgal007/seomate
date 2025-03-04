<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Manage_user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_user($data) {
        // Insert the data into the users table
        return $this->db->insert('users', $data); // Ensure the table name matches your database table
    }



    public function get_users_data() {
        $this->db->select('id, first_name, last_name, username, email, password, role');
        $this->db->from('users');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function delete_user_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

}
