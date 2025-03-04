<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Client_model');
        $this->load->library('session');
    }

    public function getclients() {
        $data['clients'] = $this->Client_model->get_clients();
        echo json_encode($data);
    }

    public function get_client($id) {
        $client = $this->Client_model->get_client_by_id($id);
        echo json_encode($client);
    }

    public function submit_form() {
        $data = array(
            'client_name' => $this->input->post('client_name'),
            'company_name' => $this->input->post('company_name'),
            'client_email' => $this->input->post('client_email'),
            'client_phone' => $this->input->post('client_phone'),
            'industry_type' => $this->input->post('industry_type')
        );

        if ($this->Client_model->insert_client($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Client added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add client.']);
        }
    }

    public function update_client() {
        $client_id = $this->input->post('client_id');
        $data = array(
            'client_name' => $this->input->post('client_name'),
            'company_name' => $this->input->post('company_name'),
            'client_email' => $this->input->post('client_email'),
            'client_phone' => $this->input->post('client_phone'),
            'industry_type' => $this->input->post('industry_type')
        );
    
        $updated = $this->Client_model->update_client($client_id, $data);
        if ($updated) {
            // Return a JSON response with a success message
            echo json_encode(['status' => 'success', 'message' => 'Client updated successfully.']);
        } else {
            // Return a JSON response with an error message
            echo json_encode(['status' => 'error', 'message' => 'Failed to update client.']);
        }
    }



    public function delete_client($id) {
        $deleted = $this->Client_model->delete_client_by_id($id);
        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Client deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete client.']);
        }
    }
    
    
}
