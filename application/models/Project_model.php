<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // public function get_clients() {
    //     $this->db->select('id, client_name');
    //     return $this->db->get('clients')->result_array();
    // }
      public function get_clients() {
        $this->db->select('id, company_name');
        return $this->db->get('clients')->result_array();
    }

    public function get_off_projects() {
        $this->db->select('project_id, project_name');
        return $this->db->get('projects')->result_array();
    }


    public function get_all_projects() {
        $this->db->select('projects.project_id, projects.project_name, projects.website_link, projects.created_at, clients.company_name');
        $this->db->from('projects');
        $this->db->join('clients', 'clients.id = projects.company_name');
        $this->db->order_by('projects.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function insert_project($data) {
        $data['project_id'] = mt_rand(100, 999);
        while ($this->db->get_where('projects', ['project_id' => $data['project_id']])->num_rows() > 0) {
            $data['project_id'] = mt_rand(100, 999);
        }
        return $this->db->insert('projects', $data);
    }

    public function get_project_by_id($project_id) {
        return $this->db->get_where('projects', ['project_id' => $project_id])->row_array();
    }

    public function update_project($project_id, $data) {
        $this->db->where('project_id', $project_id);
        return $this->db->update('projects', $data);
    }

    public function delete_project($project_id) {
        $this->db->where('project_id', $project_id);
        return $this->db->delete('projects');
    }
    public function get_projects() {
        // Select the project details you want
        $this->db->select('projects.project_id, projects.project_name, projects.website_link, projects.created_at, clients.company_name');
        $this->db->from('projects');
        $this->db->join('clients', 'clients.id = projects.company_name');  // Join with the clients table for client names
        $this->db->order_by('projects.created_at', 'DESC');
        $query = $this->db->get();  // Execute the query
        return $query->result_array();  // Return all projects as an array
    }





    public function get_all_offpage_categories() {
        $this->db->select('category_id, off_Category_name, default_numbers');
        $this->db->from('off_page_category');
        $this->db->order_by('category_id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }





    public function insert_data($project_id, $project_name, $category_id, $numbers) {
        // Fetch category name from off_page_category table
        $this->db->select('off_Category_name');
        $this->db->from('off_page_category');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get();
        $category = $query->row_array();
    
        // Prepare data to insert, now including category_id
        $data = [
            'project_id' => $project_id,
            'project_name' => $project_name,
            'category_id' => $category_id, // Insert the category_id as well
            'category_name' => $category['off_Category_name'],
            'numbers' => $numbers,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        return $this->db->insert('offpage_category_numbers', $data);
    }
    
    
    
    
    
}
