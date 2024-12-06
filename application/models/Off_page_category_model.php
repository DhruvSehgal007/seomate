<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Off_page_category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_categories($category) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        $data = [
            'off_Category_name' => $category,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('off_page_category', $data);
    }

   

    public function get_category_by_id($category_id) {
        return $this->db->get_where('off_page_category', ['category_id' => $category_id])->row_array();
    }

    public function update_category($category_id, $new_name) {
        $this->db->where('category_id', $category_id);
        return $this->db->update('off_page_category', [
            'off_Category_name' => $new_name,
            // 'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete_category($category_id) {
        $this->db->where('category_id', $category_id);
        return $this->db->delete('off_page_category');
    }
    public function get_all_categories() {
        return $this->db->get('off_page_category')->result_array();
    }


    
    
}
