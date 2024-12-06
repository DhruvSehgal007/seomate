<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class On_page_sub_category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_sub_category($category_id, $sub_category_name) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        $data = [
            'category_id' => $category_id,
            'sub_category_name' => $sub_category_name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('on_page_sub_category', $data);
    }

    public function get_all_sub_categories() {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        $this->db->select('sc.sub_category_id, sc.sub_category_name, sc.created_at, sc.updated_at, c.on_category_name');
        $this->db->from('on_page_sub_category sc');
        $this->db->join('on_page_category c', 'sc.category_id = c.category_id');
        return $this->db->get()->result_array();
    }

    

    public function get_sub_category_by_id($sub_category_id) {
        return $this->db->get_where('on_page_sub_category', ['sub_category_id' => $sub_category_id])->row_array();
    }

    public function update_sub_category($sub_category_id, $category_id, $sub_category_name) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        $this->db->where('sub_category_id', $sub_category_id);
        return $this->db->update('on_page_sub_category', [
            'category_id' => $category_id,
            'sub_category_name' => $sub_category_name,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete_sub_category($sub_category_id) {
        $this->db->where('sub_category_id', $sub_category_id);
        return $this->db->delete('on_page_sub_category');
    }

    public function get_all_categories() {
        return $this->db->get('on_page_category')->result_array(); // Fetch all from on_page_category table
    }
    
}
