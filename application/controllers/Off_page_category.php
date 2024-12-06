<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Off_page_category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Off_page_category_model');
    }

    public function index() {
        $this->load->view('off_page_category');
    }

    public function add_categories() {
        $categories = $this->input->post('categories');
        foreach($categories as $cates) {
            $this->Off_page_category_model->insert_categories($cates);
        }
        echo json_encode(['status' => 'success', 'message' => 'Categories added successfully!']);
    }

    public function get_categories() {
        $categories = $this->Off_page_category_model->get_all_categories();
    
        // Format the created_at and updated_at dates
        foreach ($categories as &$category) {
            $category['created_at'] = date('d M, Y h:i A', strtotime($category['created_at']));
            $category['updated_at'] = date('d M, Y h:i A', strtotime($category['updated_at']));
        }
    
        echo json_encode($categories);
    }
    

    public function get_category($category_id) {
        $category = $this->Off_page_category_model->get_category_by_id($category_id);
        echo json_encode($category);
    }

    public function update_category() {
        $category_id = $this->input->post('cat_id');
        $new_name = $this->input->post('categories')[0];  // Assuming single category is updated
        
        $updated = $this->Off_page_category_model->update_category($category_id, $new_name);
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Category updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update category.']);
        }
    }

    public function delete_category($category_id) {
        $deleted = $this->Off_page_category_model->delete_category($category_id);
        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete category.']);
        }
    }
}
