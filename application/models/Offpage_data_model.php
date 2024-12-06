<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offpage_data_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_projects() {
        $this->db->select('project_id, project_name');
        $this->db->from('projects');
        return $this->db->get()->result_array();
    }

    public function get_project_by_id($project_id) {
        $this->db->where('project_id', $project_id);
        return $this->db->get('projects')->row_array();
    }

    public function get_all_categories() {
        $this->db->select('category_id, off_Category_name');
        $this->db->from('off_page_category');
        $this->db->order_by('off_Category_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_offpage_data_by_project($project_id) {
        $this->db->select('offpage_data.*, off_page_category.off_Category_name, projects.project_name');
        $this->db->from('offpage_data');
        $this->db->join('off_page_category', 'offpage_data.off_page_category = off_page_category.category_id', 'left');
        $this->db->join('projects', 'offpage_data.project_id = projects.project_id', 'left');
        $this->db->where('offpage_data.project_id', $project_id);
        return $this->db->get()->result_array();
    }

    public function insert_offpage_data($data) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        return $this->db->insert('offpage_data', $data);
    }

    public function get_offpage_data_by_id($id) {
        $this->db->where('id', $id); // Unique ID
        return $this->db->get('offpage_data')->row_array();
    }
    
    
    public function update_offpage_data($id, $data) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        $this->db->where('id', $id); // Use the unique ID
        return $this->db->update('offpage_data', $data);
    }
    
    
    

    public function delete_offpage_data($id) {
        $this->db->where('id', $id); // Unique ID
        return $this->db->delete('offpage_data');
    }
    
    
}
