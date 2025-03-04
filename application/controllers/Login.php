<?php
// Controller: Login.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
    }

    public function index() {
        // Load the login view
        $this->load->view('admin/login');
    }

    // Controller: Login.php
    public function authenticate() {
        // Get the input data
        $username = $this->input->post('username');
        $password = $this->input->post('password');
    
        // Validate credentials using the model
        $user = $this->Login_model->check_login($username, $password);
    
        if ($user) {
            // Set session data for the authenticated user
            // $this->session->set_userdata('id', $user->id);  // Add this line to store the user ID in session

            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('first_name', $user->first_name);
            $this->session->set_userdata('last_name', $user->last_name);
            $this->session->set_userdata('role', $user->role);
    
            // Redirect to the dashboard
            redirect('admin/dashboard'); // This will take the user to /admin/dashboard
        } else {
            // If authentication fails, reload the login view with an error message
            $data['error'] = 'Invalid username or password';
            $this->load->view('admin/login', $data);
        }
    }
    
    
    


    public function logout() {
        // Destroy session data and redirect to login
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');
        $this->session->sess_destroy();
        redirect('login');
    }


    // Controller: Login.php
// Controller: Login.php

public function dashboard() {
    // Get the logged-in user's first and last name from session
    $first_name = $this->session->userdata('first_name');
    $last_name = $this->session->userdata('last_name');

    // Check if the user is logged in, else use 'Guest'
    $data['username'] = ($first_name && $last_name) ? $first_name . ' ' . $last_name : 'Guest';

    // Pass data to the view
    $this->load->view('admin/dashboard', $data);
}






}
?>
