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
 
    public function fetch_keywords_by_project($project_id) {
        if (empty($project_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Project ID is required.']);
            return;
        }
    
        $keywords = $this->Google_ranking_data_model->get_keywords_by_project($project_id);
    
        if (!empty($keywords)) {
            echo json_encode(['status' => 'success', 'data' => $keywords]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No keywords found for this project.']);
        }
    }
    public function insert_rankings() {
        $project_id = $this->input->post('project_id');
        $rankings = $this->input->post('rankings');
    
        if (empty($project_id) || empty($rankings)) {
            echo json_encode(['status' => 'error', 'message' => 'Project ID or rankings are missing.']);
            return;
        }
    
        $data = [];
        foreach ($rankings as $ranking) {
            $data[] = [
                'project_id' => $project_id,
                'keywords' => $ranking['keyword'],
                'ranking' => $ranking['ranking'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
    
        $this->load->model('Google_ranking_data_model');
        $result = $this->Google_ranking_data_model->insert_rankings($data);
    
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Rankings saved successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save rankings.']);
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
    


    public function update_ranking() {
        $id = $this->input->post('id');
        $ranking = $this->input->post('ranking');
    
        if (empty($id) || empty($ranking)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
            return;
        }
    
        $data = [
            'ranking' => $ranking,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    
        $this->load->model('Google_ranking_data_model');
        $updated = $this->Google_ranking_data_model->update_ranking($id, $data);
    
        if ($updated) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update ranking.']);
        }
    }
    
    
    
}
