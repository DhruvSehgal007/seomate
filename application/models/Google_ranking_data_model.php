<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_ranking_data_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Method to fetch keywords for the selected project
    public function get_keywords_by_project($project_id) {
        $this->db->select('keywords,id');
        $this->db->from('keywords_data');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return the array of keywords
        } else {
            return []; // Return empty array if no keywords found
        }
    }
    
    public function insert_ranking_data($data) {
        // Insert data into the keywords_data table
        return $this->db->insert('google_ranking_data', $data);
    }
    




    // public function get_ranking_data_by_project($project_id) {
    //     // Select the necessary fields from both tables
    //     $this->db->select('google_ranking_data.id, google_ranking_data.ranking, google_ranking_data.project_id, google_ranking_data.created_at, google_ranking_data.updated_at, keywords_data.keywords');
        
    //     // Join google_ranking_data with keywords_data on the keyword_id field
    //     $this->db->from('google_ranking_data');
    //     $this->db->join('keywords_data', 'keywords_data.id = google_ranking_data.id', 'left'); // Join based on keyword_id
        
    //     // Filter by the project ID
    //     $this->db->where('google_ranking_data.project_id', $project_id);
        
    //     // Execute the query and get the results
    //     $query = $this->db->get();
        
    //     return $query->result_array(); // Return the data as an array
    // }
    
    public function get_ranking_data_by_project($project_id) {
        // Select relevant fields from both tables
        $this->db->select('grd.id, grd.ranking, grd.created_at, grd.updated_at, kd.keywords'); // Select keywords from keywords_data
    
        // From the google_ranking_data table
        $this->db->from('google_ranking_data AS grd');
        
        // Join with keywords_data table to get keyword names
        $this->db->join('keywords_data AS kd', 'kd.id = grd.keywords', 'left');
        
        // Filter by project ID
        $this->db->where('grd.project_id', $project_id);
        
        // Execute the query and return the results
        $query = $this->db->get();
        
        return $query->result_array(); // Return the results as an array
    }
    
    public function delete_ranking_data($id) {
        $this->db->where('id', $id); // Unique ID
        return $this->db->delete('google_ranking_data');
    }




    // public function update_ranking_data($id, $data) {
    //     if (empty($id) || !$data) {
    //         return false;
    //     }
    //     $this->db->where('id', $id);
    //     return $this->db->update('google_ranking_data', $data);
    // }
    public function update_ranking_data($id, $data) {
        if (empty($id) || !$data) {
            return false;
        }
    
        // Ensure 'keywords' is updated instead of 'keyword'
        if (isset($data['keyword'])) {
            $data['keywords'] = $data['keyword']; // Renaming the field to match the database
            unset($data['keyword']); // Remove the 'keyword' field as it's not valid
        }
    
        $this->db->where('id', $id);
        return $this->db->update('google_ranking_data', $data);
    }
    
    
    
    public function get_ranking_data_by_id($id) {
        $this->db->where('id', $id); // Unique ID
        return $this->db->get('google_ranking_data')->row_array();
    }
}
