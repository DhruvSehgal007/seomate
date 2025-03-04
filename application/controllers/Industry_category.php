<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Industry_category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Industry_type_model');
    }

    // Index method for loading the view
    public function index() {
        $this->load->view('industry_category');
    }

    // Method for adding categories
    public function add_categories() {
        $categories = $this->input->post('categories');
        
        // Insert each category into the database
        foreach ($categories as $category) {
            $this->Industry_type_model->insert_categories($category);
        }

        // Return a JSON response
        echo json_encode(['status' => 'success', 'message' => 'Categories added successfully!']);
    }

    // Method to get all categories for the table
    public function get_categories() {
        $categories = $this->Industry_type_model->get_all_categories();
        echo json_encode(['categories' => $categories]);
    }

    public function update_category() {
        $categoryId = $this->input->post('category_id');
        $categories = $this->input->post('categories');
    
        // Update each category in the database
        foreach ($categories as $category) {
            $this->Industry_type_model->update_category($categoryId, $category);
        }
    
        // Return a JSON response
        echo json_encode(['status' => 'success', 'message' => 'Category updated successfully!']);
    }
    
    public function delete_category() {
        $categoryId = $this->input->post('category_id');
        
        // Delete category from the database
        $this->Industry_type_model->delete_category($categoryId);
    
        // Return a JSON response
        echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully!']);
    }
    
    
}
