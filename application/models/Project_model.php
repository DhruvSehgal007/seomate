<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_clients() {
        $this->db->select('id, client_name');
        return $this->db->get('clients')->result_array();
    }

    public function get_all_projects() {
        $this->db->select('projects.project_id, projects.project_name, projects.website_link, projects.created_at, clients.client_name');
        $this->db->from('projects');
        $this->db->join('clients', 'clients.id = projects.client_name');
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
        $this->db->select('projects.project_id, projects.project_name, projects.website_link, projects.created_at, clients.client_name');
        $this->db->from('projects');
        $this->db->join('clients', 'clients.id = projects.client_name');  // Join with the clients table for client names
        $this->db->order_by('projects.created_at', 'DESC');
        $query = $this->db->get();  // Execute the query
        return $query->result_array();  // Return all projects as an array
    }


    
}
