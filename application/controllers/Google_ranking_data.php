<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Google_ranking_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Google_ranking_data_model');
        $this->load->model('Offpage_data_model');  // Assuming this model is used to fetch project details
    }

    // Function to handle the Google Ranking page (without AJAX)
    public function google_ranking($project_id = null) {
        $data = array();

        // Fetch all projects for the dropdown
        $data['projects'] = $this->Offpage_data_model->get_all_projects();

        // Pass the data to the view
        $view_data = array_merge($this->data, $data);

        // Load the views
        $this->load->view('admin/header', $view_data);
        $this->load->view('admin/google_ranking', $view_data);
        $this->load->view('admin/footer');
    }

    // Function to handle AJAX request to fetch keywords based on project_id
    public function get_keywords_by_project() {
        // Load model
        $this->load->model('Google_ranking_data_model');
    
        // Get the project ID from the POST data
        $project_id = $this->input->post('project_id');
        
        // Ensure project_id is not empty
        if (empty($project_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Project ID is required']);
            return;
        }
        
        // Fetch keywords related to the selected project from the database
        $keywords_data = $this->Google_ranking_data_model->get_keywords_by_project($project_id);
        
        // Check if keywords are available
        if (!empty($keywords_data)) {
            echo json_encode(['status' => 'success', 'keywords' => $keywords_data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No keywords found for this project.']);
        }
    }
    
    // 
    public function insert_ranking_data() {
        // Get POST data from AJAX request
        $keyword = $this->input->post('keyword');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $ranking = $this->input->post('ranking');
        $project_id = $this->input->post('project_id'); // Get the selected project ID
    
        // Validate the input
        if (empty($keyword) || empty($year) || empty($month) || empty($ranking) || empty($project_id)) {
            // Handle validation failure
            echo json_encode(['status' => 'error', 'message' => 'Please fill all fields.']);
            return;
        }
    
        // Prepare data for insertion
        $data = array(
            'project_id' => $project_id,
            'keywords' => $keyword,
            'ranking' => $ranking,
            'year' => $year,
            'month' => $month
        );
    
        // Insert the data into the database
        $insert_result = $this->Google_ranking_data_model->insert_ranking_data($data);
    
        // Return JSON response
        if ($insert_result) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
        }
    }
    
    public function get_ranking_data($project_id) {
        $data = $this->Google_ranking_data_model->get_ranking_data_by_project($project_id); // Fetch ranking data
        echo json_encode(['data' => $data]); // Return the data as JSON
    }
    
    public function delete_ranking_data($id) {
        // Call the model to delete the entry
        $deleted = $this->Google_ranking_data_model->delete_ranking_data($id);
    
        // Send JSON response based on whether the deletion was successful
        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not found or deletion failed']);
        }
    }






    // 
    public function update_ranking_data() {
        $id = $this->input->post('id'); // Get the unique ID
        $data = $this->input->post();
    
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID is required for update.']);
            return;
        }
    
        unset($data['id']); // Remove ID from the data array
        $data['updated_at'] = date('Y-m-d H:i:s'); // Set updated time
    
        $updated = $this->Google_ranking_data_model->update_ranking_data($id, $data);
    
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Data updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update data.']);
        }
    }
    

    public function get_ranking_data_by_id($id) {
        $data = $this->Google_ranking_data_model->get_ranking_data_by_id($id); // Fetch using unique ID
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Data not found.']);
        }
    }
    
}
