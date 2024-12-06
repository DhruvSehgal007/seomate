<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keywords_data_model extends CI_Model {

    // public function get_keywords_by_project($project_id) {
    //     $this->db->where('project_id', $project_id);
    //     return $this->db->get('keywords')->result_array();
    // }
    // public function add_keywords($data) {
    //     return $this->db->insert('keywords', $data);
    // }
    
    public function insert_keywords_data($data)
{
    return $this->db->insert('keywords_data', $data);
}

public function get_keyword_data_by_project($project_id){
    // Select the relevant fields
    $this->db->select('keywords_data.id,keywords_data.keywords, keywords_data.project_id, keywords_data.created_at, keywords_data.updated_at');
    
    // From the keywords_data table
    $this->db->from('keywords_data');
    
    // Apply the filter for the project ID
    $this->db->where('keywords_data.project_id', $project_id);
    
    // Execute the query and return the results
    $query = $this->db->get();
    
    return $query->result_array(); // Return the results as an array
}

// 

public function delete_keywords_data($id) {
    $this->db->where('id', $id); // Unique ID
    return $this->db->delete('keywords_data');
}


 
public function update_keywords_data($id, $data) {
    if (empty($id) || !$data) {
        return false;
    }
    $this->db->where('id', $id);
    return $this->db->update('keywords_data', $data);
}


public function get_keywords_data_by_id($id) {
    $this->db->where('id', $id); // Unique ID
    return $this->db->get('keywords_data')->row_array();
}

}
