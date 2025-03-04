<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Manage_user_model');
    }


    public function add_user() {
        // Capture the AJAX POST data
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),  // Store plain text password (not hashed)
            'role' => $this->input->post('role')
        );
    
        // Insert data into the database through the model
        if ($this->Manage_user_model->insert_user($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    


    public function get_usersdata() {
        $users = $this->Manage_user_model->get_users_data();
        if ($users) {
            echo json_encode(['data' => $users]); // Return data in a 'data' field to match the JS
        } else {
            echo json_encode(['data' => []]); // In case no data is found
        }
    }
    
    
    public function delete_user($id) {
        $deleted = $this->Manage_user_model->delete_user_by_id($id);
        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Client deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete client.']);
        }
    }
    
    
    
}
