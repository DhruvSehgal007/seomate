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

    public function fetch_on_page_categories() {
        $this->load->model('Onpage_data_model'); // Load the model
        $categories = $this->Onpage_data_model->get_all_on_page_categories(); // Fetch categories
        
        if (!empty($categories)) {
            echo json_encode(['status' => 'success', 'data' => $categories]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No categories found.']);
        }
    }
    
    
    public function fetch_categories_with_subcategories() {
        $this->load->model('Onpage_data_model'); // Load the model
    
        $data = $this->Onpage_data_model->get_categories_with_subcategories(); // Fetch categories and subcategories
        
        $categories = [];
        foreach ($data as $row) {
            $categoryId = $row['category_id'];
            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'category_id' => $row['category_id'],
                    'on_category_name' => $row['on_category_name'],
                    'subcategories' => [],
                ];
            }
            if (!empty($row['sub_category_id'])) {
                $categories[$categoryId]['subcategories'][] = [
                    'sub_category_id' => $row['sub_category_id'],
                    'sub_category_name' => $row['sub_category_name'],
                ];
            }
        }
    
        if (!empty($categories)) {
            echo json_encode(['status' => 'success', 'data' => array_values($categories)]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No categories or subcategories found.']);
        }
    }
    
    public function insert_onpage_data() {
        // Retrieve POST data
        $projectId = $this->input->post('project_id'); // Project ID
        $selectedData = $this->input->post('selected_data'); // Data array, should match the sent name
    
        // Validate input data
        if (empty($projectId) || empty($selectedData) || !is_array($selectedData)) {
            echo json_encode(['status' => 'error', 'message' => 'Project ID or selected data is missing or invalid.']);
            return;
        }
    
        // Prepare data for insertion
        $insertData = [];
        foreach ($selectedData as $data) {
            $categoryId = $data['category_id'];
            $subcategories = isset($data['subcategories']) ? $data['subcategories'] : [];
    
            if (empty($subcategories)) {
                // Insert only the category (no subcategories)
                $insertData[] = [
                    'project_id' => $projectId,
                    'on_page_category' => $categoryId,
                    'on_page_sub_category' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                // Insert each subcategory with its parent category
                foreach ($subcategories as $subcategory) {
                    $subcategoryId = $subcategory['id']; // Use 'id' from subcategory data
                    $insertData[] = [
                        'project_id' => $projectId,
                        'on_page_category' => $categoryId,
                        'on_page_sub_category' => $subcategoryId,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }
        }
    
        // Load the model and insert data
        $this->load->model('Onpage_data_model');
        $result = $this->Onpage_data_model->insert_onpage_data_batch($insertData);
    
        // Return response based on the insertion result
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
        }
    }
    

    
    public function fetch_onpage_data($project_id = null) {
        if ($project_id === null) {
            echo json_encode(['status' => 'error', 'message' => 'Project ID is required.']);
            return;
        }
    
        $this->load->model('Onpage_data_model');
        $data = $this->Onpage_data_model->get_onpage_data_by_project($project_id);
    
        if (!empty($data)) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data found for the selected project.']);
        }
    }
    
    
    
   
}







