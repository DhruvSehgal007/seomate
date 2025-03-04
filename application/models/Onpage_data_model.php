<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onpage_data_model extends CI_Model {

 
    public function get_all_on_page_categories() {
        $this->db->select('category_id, on_category_name, created_at, updated_at'); // Specify the fields
        $this->db->from('on_page_category'); // Specify the table name
        $this->db->order_by('on_category_name', 'ASC'); // Order by name
        return $this->db->get()->result_array(); // Return result as array
    }
    

    public function get_categories_with_subcategories() {
        $this->db->select('on_page_category.category_id, on_page_category.on_category_name, on_page_sub_category.sub_category_id, on_page_sub_category.sub_category_name');
        $this->db->from('on_page_category');
        $this->db->join('on_page_sub_category', 'on_page_sub_category.category_id = on_page_category.category_id', 'left');
        $this->db->order_by('on_page_category.on_category_name', 'ASC');
        return $this->db->get()->result_array();
    }

    
    public function insert_onpage_data_batch($data) {
        return $this->db->insert_batch('onpage_data', $data);
    }
    
    
    public function get_onpage_data_by_project($project_id) {
        $this->db->select('onpage_data.*, on_page_category.on_category_name, on_page_sub_category.sub_category_name, projects.project_name');
        $this->db->from('onpage_data');
        $this->db->join('on_page_category', 'onpage_data.on_page_category = on_page_category.category_id', 'left');
        $this->db->join('on_page_sub_category', 'onpage_data.on_page_sub_category = on_page_sub_category.sub_category_id', 'left');
        $this->db->join('projects', 'onpage_data.project_id = projects.project_id', 'left');
        $this->db->where('onpage_data.project_id', $project_id);
        $this->db->order_by('onpage_data.created_at', 'DESC');
    
        return $this->db->get()->result_array();
    }
    
    
    
    
    

}
