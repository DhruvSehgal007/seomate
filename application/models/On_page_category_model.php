<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class On_page_category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_category($category_name) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        $data = [
            'on_category_name' => $category_name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('on_page_category', $data);
    }

    public function get_all_categories() {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        return $this->db->get('on_page_category')->result_array();
    }

    public function get_category_by_id($category_id) {
        return $this->db->get_where('on_page_category', ['category_id' => $category_id])->row_array();
    }

    public function update_category($category_id, $category_name) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        $this->db->where('category_id', $category_id);
        return $this->db->update('on_page_category', [
            'on_category_name' => $category_name,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete_category($category_id) {
        $this->db->where('category_id', $category_id);
        return $this->db->delete('on_page_category');
    }
}
