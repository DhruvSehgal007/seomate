<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class On_page_sub_category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('On_page_sub_category_model'); // Model for sub-categories
        $this->load->model('On_page_category_model'); // Model for categories
    }

    public function index() {
        $this->load->model('On_page_sub_category_model');
        $data['subCategories'] = $this->On_page_sub_category_model->get_all_sub_categories();
        $this->load->view('admin/on_page_sub_category', $data);
    }

    
    

    public function add_sub_category() {
        $category_id = $this->input->post('category_id');
        $sub_categories = $this->input->post('sub_categories');

        foreach($sub_categories as $sub_category_name) {
            $this->On_page_sub_category_model->insert_sub_category($category_id, $sub_category_name);
        }
        
        echo json_encode(['status' => 'success', 'message' => 'Sub-categories added successfully!']);
    }

    public function get_sub_categories() {
        
        $sub_categories = $this->On_page_sub_category_model->get_all_sub_categories();
        echo json_encode($sub_categories);
    }

    public function get_sub_category($sub_category_id) {
        $sub_category = $this->On_page_sub_category_model->get_sub_category_by_id($sub_category_id);
        echo json_encode($sub_category);
    }

    public function update_sub_category() {
        $sub_category_id = $this->input->post('sub_category_id');
        $category_id = $this->input->post('category_id');
        $sub_category_name = $this->input->post('sub_categories')[0];

        $updated = $this->On_page_sub_category_model->update_sub_category($sub_category_id, $category_id, $sub_category_name);
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Sub-category updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update sub-category.']);
        }
    }

    public function delete_sub_category($sub_category_id) {
        $deleted = $this->On_page_sub_category_model->delete_sub_category($sub_category_id);
        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Sub-category deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete sub-category.']);
        }
    }

    // New function to get categories for the dropdown
    public function get_categories() {
        $categories = $this->On_page_category_model->get_all_categories(); // Fetch all categories
        echo json_encode($categories); // Send as JSON to the view
    }
}
