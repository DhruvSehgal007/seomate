<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Industry_type_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Insert category into the database
    public function insert_categories($category) {
        $data = [
            'industry_name' => $category,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('industry_categories', $data);
    }

    // Get all categories
    public function get_all_categories() {
        $query = $this->db->get('industry_categories');
        return $query->result_array();
    }

    public function update_category($categoryId, $categoryName) {
        $data = [
            'industry_name' => $categoryName,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('category_id', $categoryId);
        return $this->db->update('industry_categories', $data);
    }
    public function delete_category($categoryId) {
        $this->db->where('category_id', $categoryId);
        return $this->db->delete('industry_categories');
    }
    

    
}
