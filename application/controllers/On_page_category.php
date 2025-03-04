<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class On_page_category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('On_page_category_model');
    }

    public function index() {
        $this->load->view('on_page_category');
    }

    public function add_category() {
        $category_names = $this->input->post('category_name'); // This is now an array due to category_name[]
    
        if (is_array($category_names) && count($category_names) > 0) {
            foreach ($category_names as $cname) {
                $this->On_page_category_model->insert_category($cname);
            }
            echo json_encode(['status' => 'success', 'message' => 'Categories added successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No category provided.']);
        }
    }
    
    public function get_categories() {
        $categories = $this->On_page_category_model->get_all_categories();
        echo json_encode($categories);
    }

    public function get_category($category_id) {
        $category = $this->On_page_category_model->get_category_by_id($category_id);
        echo json_encode($category);
    }

    public function update_category() {
        $category_id = $this->input->post('category_id');
        $category_name = $this->input->post('category_name');

        $updated = $this->On_page_category_model->update_category($category_id, $category_name);
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Category updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update category.']);
        }
    }

    public function delete_category($category_id) {
        $deleted = $this->On_page_category_model->delete_category($category_id);
        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete category.']);
        }
    }
}
