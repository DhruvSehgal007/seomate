<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assigned_user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Assigned_user_model');
        $this->load->library('session');
    }



    public function get_users() {
        $users = $this->Assigned_user_model->get_users();
        echo json_encode($users); // Directly return the array of users
    }


    public function get_projects() {
        $projects = $this->Assigned_user_model->get_projects();
        echo json_encode($projects); // Directly return the array of users
    }
    


    public function submit_assigned_data() {
        $data = array(
            'username' => $this->input->post('username'),
            'project_names' => $this->input->post('project_names'),
        );

        if ($this->Assigned_user_model->insert_assigned_data($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
        }
    }




    public function fetch_assigned_data() {
        $assigned_data = $this->Assigned_user_model->get_assigned_data();
        echo json_encode($assigned_data); // Return the data as JSON
    }

}