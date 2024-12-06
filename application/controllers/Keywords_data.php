<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keywords_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Keywords_data_model');
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
        $this->load->view('admin/keywords', $data);
        $this->load->view('admin/footer');
    }









    public function save_keywords_data() {
        $this->load->model('Keywords_data_model');
    
        // Get POST data
        $project_id = $this->input->post('project_id');
        $keywords = $this->input->post('keywords');  // Make sure 'keywords' is coming as a string or array
    
        if (empty($project_id) || empty($keywords)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
            return;
        }
    
        // If keywords are entered as a single string, convert them to an array
        if (is_string($keywords)) {
            $keywords = explode(',', $keywords);  // Convert the comma-separated string into an array
        }
    
        // Insert each keyword into the database
        foreach ($keywords as $keyword) {
            $data = [
                'project_id' => $project_id,
                'keywords' => trim($keyword),  // Make sure to trim any extra spaces
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            // Insert data
            $this->Keywords_data_model->insert_keywords_data($data);
        }
    
        echo json_encode(['status' => 'success']);
    }

    
  
    
    public function get_keywords_data($project_id) {
        $data = $this->Keywords_data_model->get_keyword_data_by_project($project_id);
        echo json_encode(['data' => $data]);
    }




    // public function delete_keywords_data($id) {
    //     $deleted = $this->Keywords_data_model->delete_keywords_data($id); // Delete using unique ID
    //     echo json_encode(['status' => $deleted ? 'success' : 'error']);
    // }
    public function delete_keywords_data($id) {
        // Call the model to delete the entry
        $deleted = $this->Keywords_data_model->delete_keywords_data($id);
    
        // Send JSON response based on whether the deletion was successful
        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not found or deletion failed']);
        }
    }



    
    public function update_keywords_data() {
        $id = $this->input->post('id'); // Get the unique ID
        $data = $this->input->post();
    
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID is required for update.']);
            return;
        }
    
        unset($data['id']); // Remove ID from the data array
        $data['updated_at'] = date('Y-m-d H:i:s'); // Set updated time
    
        $updated = $this->Keywords_data_model->update_keywords_data($id, $data);
    
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Data updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update data.']);
        }
    }
    

    public function get_keywords_data_by_id($id) {
        $data = $this->Keywords_data_model->get_keywords_data_by_id($id); // Fetch using unique ID
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Data not found.']);
        }
    }
    


}