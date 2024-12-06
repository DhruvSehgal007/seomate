<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offpage_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Offpage_data_model');
        $this->load->model('Off_page_category_model');
    }

    public function index($project_id = null) {
        $data = [];

        // Fetch all projects for the dropdown
        $data['projects'] = $this->Offpage_data_model->get_all_projects();

        // Fetch selected project details and associated offpage data
        if (!empty($project_id)) {
            $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);
            $data['offpage_data'] = $this->Offpage_data_model->get_offpage_data_by_project($project_id);
            $data['projectid'] = $project_id;
        } else {
            $data['selected_project'] = null;
            $data['offpage_data'] = [];
			$data['projectid'] = null;
        }

        // Fetch all categories for the dropdown
        $data['categories'] = $this->Offpage_data_model->get_all_categories();

        // Load views
        $this->load->view('admin/header', $data);
        $this->load->view('admin/offpage', $data);
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
    
        if (empty($data['project_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Project ID is required.']);
            return;
        }
    
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $inserted_id = $this->Offpage_data_model->insert_offpage_data($data);
    
        if ($inserted_id) {
            echo json_encode(['status' => 'success', 'id' => $inserted_id]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
        }
    }
    
    public function update_offpage_data() {
        $id = $this->input->post('id'); // Get the unique ID
        $data = $this->input->post();
    
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID is required for update.']);
            return;
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
    
    
    
    
}
