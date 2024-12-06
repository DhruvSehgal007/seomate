<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_client($data) {
        $data['id'] = mt_rand(100, 999);
        while ($this->db->get_where('clients', ['id' => $data['id']])->num_rows() > 0) {
            $data['id'] = mt_rand(100, 999);
        }
        return $this->db->insert('clients', $data);
    }

    public function get_clients() {
        $query = $this->db->get('clients');
        return $query->result_array();
    }

    public function get_client_by_id($id) {
        return $this->db->get_where('clients', ['id' => $id])->row_array();
    }

    public function update_client($id, $data) {

        $this->db->set('updated_at', 'NOW()', FALSE); // Use MySQL's NOW() function

        $this->db->where('id', $id);
        return $this->db->update('clients', $data);
    }



    public function delete_client_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->delete('clients');
    }
    
}
