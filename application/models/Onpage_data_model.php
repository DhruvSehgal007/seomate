<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onpage_data_model extends CI_Model {

 
    


public function get_all_categories()
{
    $query = $this->db->get('on_page_category');
    return $query->result_array(); // Return as an array of rows
}

public function get_entries_by_category_id($category_id)
{
    $this->db->where('category_id', $category_id);
    $query = $this->db->get('on_page_sub_category'); // Replace 'on_page_sub_category' with your table name
    return $query->result_array(); // Return all matching rows as an array
}
public function get_sub_categories_by_category_id($category_id)
{
    $this->db->where('category_id', $category_id);
    $query = $this->db->get('on_page_sub_category'); // Replace with your table name
    return $query->result_array(); // Return all matching rows as an array
}

public function insert_onpage_data($data)
{
    return $this->db->insert('onpage_data', $data);
}





public function get_onpage_data_by_project($project_id) {
    $this->db->select('on_page_category.on_category_name, projects.project_name, onpage_data.on_page_sub_category, onpage_data.*');
    $this->db->from('onpage_data');
    $this->db->join('on_page_category', 'onpage_data.on_page_category = on_page_category.category_id', 'left');
    $this->db->join('projects', 'onpage_data.project_id = projects.project_id', 'left');
    $this->db->where('onpage_data.project_id', $project_id);
    
    $query = $this->db->get();
    $data = $query->result_array(); // Fetch the results

    // Process each record to get the subcategory names
    foreach ($data as &$item) {
        $subCategoryIds = explode(',', $item['on_page_sub_category']); // Get IDs as array
        $subCategoryNames = [];

        // Fetch names for each subcategory ID
        foreach ($subCategoryIds as $subCategoryId) {
            $this->db->select('sub_category_name');
            $this->db->where('sub_category_id', $subCategoryId);
            $subCategoryQuery = $this->db->get('on_page_sub_category');
            $subCategory = $subCategoryQuery->row_array();
            
            if ($subCategory) {
                $subCategoryNames[] = $subCategory['sub_category_name']; // Add name to the list
            }
        }

        // Join names with commas and assign to the item
        $item['on_page_sub_category_names'] = implode(', ', $subCategoryNames);
    }

    return $data; // Return data with subcategory names
}


public function delete_onpage_data($id) {
    $this->db->where('id', $id); // Unique ID
    return $this->db->delete('onpage_data');
}

public function get_onpage_data_by_id($id) {
    $this->db->select('on_page_category.on_category_name, onpage_data.on_page_category, onpage_data.on_page_sub_category, projects.project_name, onpage_data.*');
    $this->db->from('onpage_data');
    $this->db->join('on_page_category', 'onpage_data.on_page_category = on_page_category.category_id', 'left');
    $this->db->join('projects', 'onpage_data.project_id = projects.project_id', 'left');
    $this->db->where('onpage_data.id', $id);
    
    $query = $this->db->get();
    return $query->row_array(); // Fetch the single record
}

public function entry_exists($project_id, $category_id, $sub_categories) {
    // Query to check if an entry with the same project ID, category ID, and subcategories exists
    $this->db->where('project_id', $project_id);
    $this->db->where('on_page_category', $category_id);
    $this->db->where('on_page_sub_category', $sub_categories);
    
    return $this->db->count_all_results('onpage_data') > 0; // Return true if exists
}


}
