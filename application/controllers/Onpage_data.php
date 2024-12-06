<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onpage_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Onpage_data_model');
    }

    public function index($project_id = null) {
        $data = [];
        $data['projectid'] = '';
        if ($project_id != null) {
            $data['project'] = $this->Project_model->get_project($project_id); // Load project data
            $data['projectid'] = $project_id;
        } else {
            $data['project'] = null; // No project selected
            $data['projectid'] = null; // No project selected
        }

        $this->load->view('admin/header', $data);
        $this->load->view('admin/onpage', $data);
        $this->load->view('admin/footer');
    }

    public function fetch_categories() {
        $categories = $this->Onpage_data_model->get_all_categories();
        echo json_encode($categories); // Return categories as JSON
    }

    public function fetch_sub_categories($category_id) {
        $subCategories = $this->Onpage_data_model->get_sub_categories_by_category_id($category_id);
        echo json_encode($subCategories); // Return subcategories as JSON
    }

    // public function save_onpage_data() {
    //     $id = $this->input->post('id'); // Check if it's an update or insert
    //     $project_id = $this->input->post('project_id');
    //     $on_page_category = $this->input->post('on_page_category');
    //     $on_page_sub_categories = $this->input->post('on_page_sub_category'); // This should be an array
    
    //     // Ensure that on_page_sub_categories is an array
    //     if (!is_array($on_page_sub_categories)) {
    //         $on_page_sub_categories = []; // Initialize as empty array if it's not
    //     }
    
    //     if (!empty($project_id) && !empty($on_page_category) && !empty($on_page_sub_categories)) {
    //         $data = [
    //             'project_id' => $project_id,
    //             'on_page_category' => $on_page_category,
    //             'on_page_sub_category' => implode(',', $on_page_sub_categories), // Convert array to comma-separated string
    //             'updated_at' => date('Y-m-d H:i:s'),
    //         ];
    
    //         if ($id) {
    //             // Update existing record
    //             $this->db->where('id', $id);
    //             $this->db->update('onpage_data', $data);
    //             echo json_encode(['status' => 'success']);
    //         } else {
    //             // Insert new record
    //             $data['created_at'] = date('Y-m-d H:i:s');
    //             $this->db->insert('onpage_data', $data);
    //             echo json_encode(['status' => 'success']);
    //         }
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
    //     }
    // }

    public function save_onpage_data() {
        $id = $this->input->post('id'); // Check if it's an update or insert
        $project_id = $this->input->post('project_id');
        $on_page_category = $this->input->post('on_page_category');
        $on_page_sub_categories = $this->input->post('on_page_sub_category'); // Array of selected subcategories
    
        // Convert subcategories to a comma-separated string
        $subCategoryString = implode(',', $on_page_sub_categories);
    
        // Check for existing entry
        if ($this->Onpage_data_model->entry_exists($project_id, $on_page_category, $subCategoryString)) {
            echo json_encode(['status' => 'error', 'message' => 'This entry already exists.']);
            return;
        }
    
        if (!empty($project_id) && !empty($on_page_category) && !empty($on_page_sub_categories)) {
            $data = [
                'project_id' => $project_id,
                'on_page_category' => $on_page_category,
                'on_page_sub_category' => $subCategoryString,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            if ($id) {
                // Update existing record
                $this->db->where('id', $id);
                $this->db->update('onpage_data', $data);
                echo json_encode(['status' => 'success']);
            } else {
                // Insert new record
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('onpage_data', $data);
                echo json_encode(['status' => 'success']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
        }
    }
    
    
    

    public function get_onpage_data($project_id) {
        $data = $this->Onpage_data_model->get_onpage_data_by_project($project_id);
        echo json_encode(['data' => $data]);
    }

// 



    public function delete_onpage_data($id) {
        // Call the model to delete the entry
        $deleted = $this->Onpage_data_model->delete_onpage_data($id);
    
        // Send JSON response based on whether the deletion was successful
        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not found or deletion failed']);
        }
    }

    public function edit_onpage_data($id) {
        $data = $this->Onpage_data_model->get_onpage_data_by_id($id);
        
        // Fetch categories
        $categories = $this->Onpage_data_model->get_all_categories();
        
        // Fetch sub-categories for the selected category (based on the on_page_category)
        $subCategories = $this->Onpage_data_model->get_sub_categories_by_category_id($data['on_page_category']);
        
        // Return data to the frontend
        echo json_encode([
            'data' => $data,
            'categories' => $categories,
            'subCategories' => $subCategories
        ]);
    }
    
    
    

   
}







