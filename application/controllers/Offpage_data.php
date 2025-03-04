<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offpage_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Offpage_data_model');
        $this->load->model('Off_page_category_model');
    }

   

    public function index($project_id = null) {
        $data = array();  // Initialize the data array
        $user_id = $this->session->userdata('id');  // Get the user_id from the session
        
    
        // Fetch the assigned projects for the logged-in user
        $this->load->model('Offpage_data_model');  // Load the model
        $data['projects'] = $this->Offpage_data_model->get_project_by_userid($user_id);  // Get the projects assigned to this user
    
        // If a project_id is provided, fetch the offpage data for that project
        if (!empty($project_id)) {
            $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);
            $data['projectid'] = $project_id;
            $data['offpage_data'] = $this->Offpage_data_model->get_offpage_data_by_project($project_id);
        } else {
            $data['selected_project'] = null;  // No project selected
            $data['projectid'] = null;
            $data['offpage_data'] = [];  // No offpage data
        }
    
        // Fetch all categories for the dropdown
        $data['categories'] = $this->Offpage_data_model->get_all_categories();
    
        // Ensure the project_id is passed to the view
        $data['project_id'] = $project_id;
    
        // Load the views with the data
        $this->load->view('admin/header', $data);
        $this->load->view('admin/offpage', $data);  // Pass the data to the offpage view
        $this->load->view('admin/footer');
    }
    

   
    




    public function get_offpage_data($project_id) {
        $data = $this->Offpage_data_model->get_offpage_data_by_project($project_id);
        echo json_encode(['data' => $data]);
    }

    public function get_offpage_data_by_id($id) {
        $data = $this->Offpage_data_model->get_offpage_data_by_id($id); // Fetch using unique ID
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Data not found.']);
        }
    }
    
    
    
    

    public function add_offpage_data() {
        $data = $this->input->post();
    
        if (empty($data['project_id']) || empty($data['off_page_category'])) {
            echo json_encode(['status' => 'error', 'message' => 'Project ID and Category are required.']);
            return;
        }
    
        // Check if multiple links were added
        $offPageLinks = $data['off_page_link']; // This will be an array
        if (!is_array($offPageLinks)) {
            $offPageLinks = [$offPageLinks]; // Ensure it's always an array
        }
    
        $insertedIds = [];
        foreach ($offPageLinks as $link) {
            $insertData = [
                'project_id' => $data['project_id'],
                'off_page_category' => $data['off_page_category'],
                'off_page_link' => $link,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->load->model('Offpage_data_model');
            $inserted = $this->Offpage_data_model->insert_offpage_data($insertData);
            if ($inserted) {
                $insertedIds[] = $this->db->insert_id();
            }
        }
    
        if (!empty($insertedIds)) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.', 'ids' => $insertedIds]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
        }
    }
    
    
    public function update_offpage_data() {
        $id = $this->input->post('id');
        $data = $this->input->post();
    
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID is required for update.']);
            return;
        }
    
        // Check if off_page_link is an array, handle accordingly
        if (is_array($data['off_page_link'])) {
            // Convert the array to a comma-separated string if needed
            $data['off_page_link'] = implode(',', $data['off_page_link']);
        }
    
        unset($data['id']); // Remove ID from the data array
        $data['updated_at'] = date('Y-m-d H:i:s');
        $updated = $this->Offpage_data_model->update_offpage_data($id, $data);
    
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Data updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update data.']);
        }
    }
    
    
    
    
    
    
    
    public function delete_offpage_data($id) { 
        $deleted = $this->Offpage_data_model->delete_offpage_data($id); // Delete using unique ID
        echo json_encode(['status' => $deleted ? 'success' : 'error']);
    }
    



    public function show_project_offpage_numbers($project_id) {
        $this->load->model('Offpage_data_model');
        $data = $this->Offpage_data_model->get_project_offpage_numbers($project_id);
        echo json_encode(['data' => $data]);
    }
    
    
    
}
