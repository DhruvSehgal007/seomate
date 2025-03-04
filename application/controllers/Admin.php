<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    // public function __construct() {
    //     parent::__construct();
    //     $this->load->model('Client_model'); // Load the model
    //     // $this->load->library('session'); // Load the session library
    // }
    public function __construct() {
        parent::__construct();
        // Load session library
        $this->load->library('session');

        $this->load->model('Project_model');
        $this->load->model('Offpage_data_model');  // Load the Offpage_data_model here

        
        // Set session data for username
        $this->data['username'] = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');

        $this->load->model('Client_model');
        
        // If user is not logged in, set to 'Guest'
        if (empty($this->data['username'])) {
            $this->data['username'] = 'Guest';
        }
    }

    public function dashboard() {
        // Pass session data to the header
        $this->load->view('admin/header', $this->data); 
        $this->load->view('admin/dashboard', $this->data);  // Main content
        $this->load->view('admin/footer');
    }

    public function index(){
        $this->load->view('admin/index');
    }

    public function button(){
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/button');
        $this->load->view('admin/footer');
        
    }
    public function clients() {
       $data['clients'] = $this->Client_model->get_clients();
        $this->load->view('admin/header', $this->data); // Pass $this->data to header
        $this->load->view('admin/client', $data);
        $this->load->view('admin/footer');
    }
    // public function project(){
    // $this->load->view('admin/header', $this->data);  // Pass session data
    // $this->load->view('admin/project');       // Pass the projects data to the view
    // $this->load->view('admin/footer');
   
        
    // }

    public function project() {
        // Fetch the project data from the model (make sure to adjust this as per your logic)
        $data['projects'] = $this->Project_model->get_projects();  // Assuming you fetch all projects
    
        // Pass the projects data to the view
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/project', $data);  // Pass $data to the view
        $this->load->view('admin/footer');
    }
    

    // public function offpage($project_id = null) {
    //     $data = array();  // Initialize the data array
    //     $user_id = $this->session->userdata('id');  // Get the user_id from the session
    
    //     // Fetch the assigned projects for the logged-in user
    //     $this->load->model('Offpage_data_model');  // Load the Offpage_data_model
    //     $data['projects'] = $this->Offpage_data_model->get_project_by_userid($user_id);  // Get the projects assigned to this user
    
    //     // If a project_id is provided, fetch the project details
    //     if (!empty($project_id)) {
    //         $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);  // Get details of the selected project
    //         $data['projectid'] = $project_id;
    //     } else {
    //         $data['selected_project'] = null;  // No project selected
    //         $data['projectid'] = null;
    //     }
    
    //     // Fetch all categories for the dropdown (if needed)
    //     $data['categories'] = $this->Offpage_data_model->get_all_categories();
    
    //     // Ensure the project_id is passed to the view
    //     $data['project_id'] = $project_id;
    
    //     // Load the views with the data
    //     $this->load->view('admin/header', $data);
    //     $this->load->view('admin/offpage', $data);  // Pass the data to the offpage view
    //     $this->load->view('admin/footer');
    // }
    
   
    public function offpage($project_id = null) {
        $data = array(); // Initialize the data array
    
        // Fetch project details only if $project_id is provided
        if (!empty($project_id)) {
            $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);
            $data['projectid'] = $project_id;
    
            // Handle invalid project ID
            if (empty($data['selected_project'])) {
                $data['selected_project'] = null; // Set to null if project ID is invalid
            }
        } else {
            $data['selected_project'] = null; // No project selected
            $data['projectid'] = null;
        }
    
        // Fetch all projects for the dropdown
        $data['projects'] = $this->Offpage_data_model->get_all_projects();

        
    
        // Fetch all categories for the dropdown
        $data['categories'] = $this->Offpage_data_model->get_all_categories();
    
        // Ensure the project_id is always passed
        $data['project_id'] = $project_id;
    
        // Merge global data (like username) with local data
        $view_data = array_merge($this->data, $data);
    
        // Load the views with data
        $this->load->view('admin/header', $view_data);
        $this->load->view('admin/offpage', $view_data);
        $this->load->view('admin/footer');
    }
    

    // public function offpage($project_id = null) {
    //     $data = array(); // Initialize the data array
    //     $user_id = $this->session->userdata('id');
    //     // Fetch the assigned projects for the logged-in user
    //     $data['projects'] = $this->Offpage_data_model->get_project_by_userid($user_id);
    //     // Fetch project details only if $project_id is provided
    //     if (!empty($project_id)) {
    //         $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);
    //         $data['projectid'] = $project_id;
    
    //         // Handle invalid project ID
    //         if (empty($data['selected_project'])) {
    //             $data['selected_project'] = null; // Set to null if project ID is invalid
    //         }
    //     } else {
    //         $data['selected_project'] = null; // No project selected
    //         $data['projectid'] = null;
    //     }
    
    //     // Fetch all projects for the dropdown
    //     //$data['projects'] = $this->Offpage_data_model->get_all_projects();

        
    
    //     // Fetch all categories for the dropdown
    //     $data['categories'] = $this->Offpage_data_model->get_all_categories();
    
    //     // Ensure the project_id is always passed
    //     $data['project_id'] = $project_id; 
    
    //     // Merge global data (like username) with local data
    //    // $view_data = array_merge($this->data, $data);
    
    //     // Load the views with data
    //     $this->load->view('admin/header', $data);
    //     $this->load->view('admin/offpage', $data);
    //     $this->load->view('admin/footer');
    // }
    
    
	

    public function onpage($project_id = null) {
        $data = array(); // Initialize the data array
        
        // Fetch project details only if $project_id is provided
        if (!empty($project_id)) {
            $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);
            $data['projectid'] = $project_id;
        
            // Handle invalid project ID
            if (empty($data['selected_project'])) {
                $data['selected_project'] = null; // Set to null if project ID is invalid
            }
        } else {
            $data['selected_project'] = null; // No project selected
            $data['projectid'] = null;
        }
        
        // Fetch all projects for the dropdown
        $data['projects'] = $this->Offpage_data_model->get_all_projects();
        
        // Fetch all categories for the dropdown
        $data['categories'] = $this->Offpage_data_model->get_all_categories();
        
        // Ensure the project_id is always passed
        $data['project_id'] = $project_id;
    
        // If the request is an AJAX request (for dynamic table loading)
        if ($this->input->is_ajax_request()) {
            // If a project ID is passed via AJAX, fetch and return project data
            if ($project_id) {
                $project_data = $this->Offpage_data_model->get_data_by_project($project_id);
                echo json_encode(['data' => $project_data]);
                return; // End the function here, as we're responding with JSON data
            }
            // Return empty data if no project_id provided in AJAX request
            echo json_encode(['data' => []]);
            return;
        }
        
        // Merge global data (like username) with local data
        $view_data = array_merge($this->data, $data);
        
        // Load the views with data
        $this->load->view('admin/header', $view_data);
        $this->load->view('admin/onpage', $view_data);
        $this->load->view('admin/footer');
    }
    


    public function keywords($project_id = null) {
        $data = array(); // Initialize the data array
        
        // Fetch project details only if $project_id is provided
        if (!empty($project_id)) {
            $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);
            $data['projectid'] = $project_id;
        
            // Handle invalid project ID
            if (empty($data['selected_project'])) {
                $data['selected_project'] = null; // Set to null if project ID is invalid
            }
        } else {
            $data['selected_project'] = null; // No project selected
            $data['projectid'] = null;
        }
        
        // Fetch all projects for the dropdown
        $data['projects'] = $this->Offpage_data_model->get_all_projects();
        
        // Fetch all categories for the dropdown
        $data['categories'] = $this->Offpage_data_model->get_all_categories();
        
        // Ensure the project_id is always passed
        $data['project_id'] = $project_id;
    
        // If the request is an AJAX request (for dynamic table loading)
        if ($this->input->is_ajax_request()) {
            // If a project ID is passed via AJAX, fetch and return project data
            if ($project_id) {
                $project_data = $this->Offpage_data_model->get_data_by_project($project_id);
                echo json_encode(['data' => $project_data]);
                return; // End the function here, as we're responding with JSON data
            }
            // Return empty data if no project_id provided in AJAX request
            echo json_encode(['data' => []]);
            return;
        }
        
        // Merge global data (like username) with local data
        $view_data = array_merge($this->data, $data);
        
        // Load the views with data
        $this->load->view('admin/header', $view_data);
        $this->load->view('admin/keywords', $view_data);
        $this->load->view('admin/footer');
    }


 
    public function google_ranking($project_id = null) {
        $data = array(); // Initialize the data array
    
        // Fetch project details only if $project_id is provided
        if (!empty($project_id)) {
            $data['selected_project'] = $this->Offpage_data_model->get_project_by_id($project_id);
			$data['projectid'] = $project_id;
            // Handle invalid project ID
            if (empty($data['selected_project'])) {
                $data['selected_project'] = null; // Set to null if project ID is invalid
            }
        } else {
            $data['selected_project'] = null; // No project selected
			$data['projectid'] = null;
        }
    
        // Fetch all projects for the dropdown
        $data['projects'] = $this->Offpage_data_model->get_all_projects();
    
        // Fetch all categories for the dropdown
        $data['categories'] = $this->Offpage_data_model->get_all_categories();
    
        // Pass the selected project ID to the view
        $data['project_id'] = $project_id;
    
        // Merge global data (like username) with local data
        $view_data = array_merge($this->data, $data);
        

        // $this->load->model('Google_ranking_data_model');
    
        // Load the views with data
        $this->load->view('admin/header', $view_data);
        $this->load->view('admin/google_ranking', $view_data);
        $this->load->view('admin/footer');
    }
    
    public function manage_users(){
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/manage_users');
        $this->load->view('admin/footer');
        
    }
    public function login(){
        // $this->load->view('admin/header');
        $this->load->view('admin/login');
        // $this->load->view('admin/footer');
        
    }
    public function off_page_category(){
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/off_page_category');
        $this->load->view('admin/footer');
        
    }
    public function on_page_category(){
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/on_page_category');
        $this->load->view('admin/footer');
        
    }
    public function on_page_sub_category(){
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/on_page_sub_category');
        $this->load->view('admin/footer');
        
    }



    public function assigned_user(){
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/assigned_user');
        $this->load->view('admin/footer');
        
    }



    public function industry_category(){
        $this->load->view('admin/header', $this->data);
        $this->load->view('admin/industry_category');
        $this->load->view('admin/footer');
        
    }
}
