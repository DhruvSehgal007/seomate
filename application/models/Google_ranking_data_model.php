<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_ranking_data_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Method to fetch keywords for the selected project
    public function get_keywords_by_project($project_id) {
        $this->db->select('keywords'); // Select only the keywords field
        $this->db->from('keywords_data'); // Table name
        $this->db->where('project_id', $project_id); // Filter by project ID
        $query = $this->db->get();
    
        return $query->result_array(); // Return result as an array
    }
    
    public function insert_rankings($data) {
        return $this->db->insert_batch('google_ranking_data', $data);
    }
    
    public function get_ranking_data_by_project($project_id) {
        // Select relevant fields from both tables
        $this->db->select('grd.id, grd.ranking, grd.created_at, grd.updated_at, grd.keywords'); // Select keywords from keywords_data
    
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

    public function update_ranking($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('google_ranking_data', $data);
    }
    
    
            
    
}
