<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assigned_user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_users() {
        $this->db->select("id, CONCAT(first_name, ' ', last_name) AS fullname");
        $query = $this->db->get('users');
        return $query->result_array();
    }
    


    public function get_projects() {
        $this->db->select("project_id, project_name ");
        $query = $this->db->get('projects');
        return $query->result_array();
    }



    
    public function insert_assigned_data($data) {
        // Insert data into the 'assigned_projects' table
        return $this->db->insert('assigned_projects', $data);
    }





    // public function get_assigned_data() {
    //     // Select the columns including concatenated first_name and last_name
    //     $this->db->select('assigned_projects.*, CONCAT(users.first_name, " ", users.last_name) as user_name, projects.project_name as project_name');
        
    //     // Specify the tables to join
    //     $this->db->from('assigned_projects');
    //     $this->db->join('users', 'users.id = assigned_projects.username', 'left'); // Join users table to fetch user name
    //     $this->db->join('projects', 'projects.project_id = assigned_projects.project_names', 'left'); // Join projects table to fetch project name
    
    //     // Execute the query
    //     $query = $this->db->get();
    
    //     // Return the result as an array
    //     return $query->result_array();
    // }
    
    public function get_assigned_data() {
        // Select the columns including concatenated first_name and last_name
        $this->db->select('assigned_projects.*, CONCAT(users.first_name, " ", users.last_name) as username, projects.project_name as project_names');
        
        // Specify the tables to join
        $this->db->from('assigned_projects');
        $this->db->join('users', 'users.id = assigned_projects.username', 'left'); // Join users table to fetch user name
        $this->db->join('projects', 'projects.project_id = assigned_projects.project_names', 'left'); // Join projects table to fetch project name
    
        // Execute the query
        $query = $this->db->get();
    
        // Return the result as an array
        return $query->result_array();
    }

}