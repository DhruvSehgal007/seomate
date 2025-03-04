<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offpage_data_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_projects() {
        $this->db->select('project_id, project_name');
        $this->db->from('projects');
        return $this->db->get()->result_array();
    }

    
    

    public function get_project_by_id($project_id) {
        $this->db->where('project_id', $project_id);
        return $this->db->get('projects')->row_array();
    }

    public function get_all_categories() {
        $this->db->select('category_id, off_Category_name');
        $this->db->from('off_page_category');
        $this->db->order_by('off_Category_name', 'ASC');
        return $this->db->get()->result_array();
    }

    // public function get_project_by_userid($user_id) {
    //     $sql = "SELECT projects.project_id,projects.project_name FROM `assigned_projects`
    //             JOIN projects on projects.project_id = assigned_projects.project_names
    //             WHERE username = $user_id";
    //     $query = $this->db->query($sql);

    //     // Check if the query returned any results
    //     if ($query->num_rows() > 0) {
    //         // Process the results
    //         return  $result = $query->result(); // Array of objects
    //     } else {
    //         return $result = false;
    //     }
       
    // }




    // public function get_project_by_userid($user_id) {
    //     // Ensure $user_id is sanitized or escaped before querying
    //     $sql = "SELECT projects.project_id, projects.project_name 
    //             FROM assigned_projects
    //             JOIN projects ON projects.project_id = assigned_projects.project_names
    //             WHERE assigned_projects.username = $user_id";  // Assuming username column stores user ID
    
    //     $query = $this->db->query($sql);
    
    //     // Check if the query returned any results
    //     if ($query->num_rows() > 0) {
    //         return $query->result();  // Return the array of project objects
    //     } else {
    //         return false;  // No projects found
    //     }
    // }
    
    
    

//     public function get_project_by_userid($user_id) {
//         $this->db->select('projects.project_id, projects.project_name');
// $this->db->from('assigned_projects');
// $this->db->join('projects', 'projects.project_id = assigned_projects.project_names');
// $this->db->where('username', $user_id);
// $query = $this->db->get();

// // Check if the query returned any results
// if ($query->num_rows() > 0) {
//     // Process the results
//     $result = $query->result(); // Array of objects
// } else {
//     // No results found
// }
//     }

    // public function get_offpage_data_by_project($project_id) {
    //     $this->db->select('offpage_data.*, off_page_category.off_Category_name, projects.project_name');
    //     $this->db->from('offpage_data');
    //     $this->db->join('off_page_category', 'offpage_data.off_page_category = off_page_category.category_id', 'left');
    //     $this->db->join('projects', 'offpage_data.project_id = projects.project_id', 'left');
    //     $this->db->where('offpage_data.project_id', $project_id);
    //     return $this->db->get()->result_array();
    // }
    public function get_offpage_data_by_project($project_id) {
        if (empty($project_id)) {
            return [];
        }
    
        $this->db->select('
            offpage_data.id,
            offpage_data.project_id,
            offpage_data.off_page_category,
            offpage_data.off_page_link,
            offpage_data.created_at,
            offpage_data.updated_at,
            off_page_category.off_Category_name,
            projects.project_name
        ');
        $this->db->from('offpage_data');
        $this->db->join('off_page_category', 'offpage_data.off_page_category = off_page_category.category_id', 'left');
        $this->db->join('projects', 'offpage_data.project_id = projects.project_id', 'left');
        $this->db->where('offpage_data.project_id', $project_id);
        $this->db->order_by('offpage_data.created_at', 'DESC'); // Order by latest entries
    
        return $this->db->get()->result_array();
    }
    

    public function insert_offpage_data($data) {
        date_default_timezone_set('Asia/Kolkata');  // Replace with your timezone
        return $this->db->insert('offpage_data', $data);
    }
   
    

    // public function get_offpage_data_by_id($id) {
    //     $this->db->where('id', $id); // Unique ID
    //     return $this->db->get('offpage_data')->row_array();
    // }
    public function get_offpage_data_by_id($id) {
        $this->db->select('id, project_id, off_page_category, off_page_link');
        $this->db->from('offpage_data');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
    
    
    
    public function update_offpage_data($id, $data) {
        // Ensure 'off_page_link' is always a string
        if (is_array($data['off_page_link'])) {
            $data['off_page_link'] = implode(',', $data['off_page_link']);
        }
    
        $this->db->where('id', $id);
        return $this->db->update('offpage_data', $data);
    }
    
    
    
    

    public function delete_offpage_data($id) {
        $this->db->where('id', $id); // Unique ID
        return $this->db->delete('offpage_data');
    }



    // public function get_project_offpage_numbers($project_id) {
    //     if (empty($project_id)) {
    //         return [];
    //     }
    
    //     $this->db->select('offpage_category_numbers.category_name, offpage_category_numbers.numbers, offpage_category_numbers.category_id, COUNT(offpage_data.off_page_link) AS link_count');
    //     $this->db->from('offpage_category_numbers');
    //     $this->db->join('offpage_data', 'offpage_data.project_id = offpage_category_numbers.project_id AND offpage_data.off_page_category = offpage_category_numbers.category_id', 'left');
    //     $this->db->where('offpage_category_numbers.project_id', $project_id);
    
    //     // Add the conditions for current month
    //     $this->db->where('YEAR(offpage_category_numbers.created_at) = YEAR(CURDATE())');
    //     $this->db->where('MONTH(offpage_category_numbers.created_at) = MONTH(CURDATE())');
    
    //     // Group by all non-aggregated columns
    //     $this->db->group_by(array('offpage_category_numbers.category_id', 'offpage_category_numbers.category_name', 'offpage_category_numbers.numbers'));
    
    //     $this->db->order_by('offpage_category_numbers.category_name', 'ASC');
    
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }
    
    
    public function get_project_offpage_numbers($project_id) {
        if (empty($project_id)) {
            return [];
        }
    
        $sql = "
            SELECT 
                off_page_category.category_id,
                off_page_category.off_Category_name,
                COALESCE(offpage_category_numbers.numbers, off_page_category.default_numbers) AS total_numbers,
                COUNT(offpage_data.off_page_link) AS link_count
            FROM off_page_category
            LEFT JOIN offpage_category_numbers 
                ON offpage_category_numbers.category_id = off_page_category.category_id
                AND offpage_category_numbers.project_id = ?
            LEFT JOIN offpage_data
                ON offpage_data.project_id = ?
                AND offpage_data.off_page_category = off_page_category.category_id
                AND YEAR(offpage_data.created_at) = YEAR(CURDATE())
                AND MONTH(offpage_data.created_at) = MONTH(CURDATE())
            GROUP BY off_page_category.category_id, 
                     off_page_category.off_Category_name,
                     offpage_category_numbers.numbers,
                     off_page_category.default_numbers
            ORDER BY off_page_category.off_Category_name ASC
        ";
    
        $query = $this->db->query($sql, array($project_id, $project_id));
        return $query->result_array();
    }
    
    
}
