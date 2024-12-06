<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Project_model');
    }

    public function index() {
        $this->load->view('project'); // Loads the project.php view
    }

    public function get_clients_ajax() {
        $clients = $this->Project_model->get_clients();
        echo json_encode($clients);
    }

    public function get_projects() {
        $projects = $this->Project_model->get_all_projects();
        echo json_encode($projects);
    }

    public function get_project($project_id) {
        $project = $this->Project_model->get_project_by_id($project_id);
        echo json_encode($project);
    }

    public function submit_project() {
        $data = array(
            'client_name'   => $this->input->post('client_id'),
            'project_name'  => $this->input->post('project_name'),
            'website_link'  => $this->input->post('website_link'),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        );
        $inserted = $this->Project_model->insert_project($data);
        if ($inserted) {
            echo json_encode(['status' => 'success', 'message' => 'Project added successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add project.']);
        }
    }

    public function update_project() {
        $project_id = $this->input->post('project_id');
        $data = array(
            'project_name' => $this->input->post('project_name'),
            'website_link' => $this->input->post('website_link'),
            'client_name'  => $this->input->post('client_id'),
            'updated_at'   => date('Y-m-d H:i:s')
        );

        $updated = $this->Project_model->update_project($project_id, $data);
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Project updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update project.']);
        }
    }

    public function delete_project($project_id) {
        $deleted = $this->Project_model->delete_project($project_id);
        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Project deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete project.']);
        }
    }


    public function project() {
        // Fetch the project data from the model
        $data['projects'] = $this->Project_model->get_projects();
    
        // Check if projects are fetched correctly
        if ($data['projects']) {
            // If projects are available, pass them to the view
            $this->load->view('admin/header', $this->data); 
            $this->load->view('admin/project', $data);  // Pass the project data
            $this->load->view('admin/footer');
        } else {
            // If no projects found, show an error or empty message
            echo "No projects found!";
        }
    }
    
}
