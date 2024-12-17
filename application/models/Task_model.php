<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

    public function add($data)
    {
        $this->db->insert('tasks', $data);
        return true; 
    }
    public function getList($params){
        $case = '';
        if($params["only_requests"]){
            // $case = "WHERE status='0'";
        }
        return $this->db->query("SELECT *
                FROM `tasks` $case")->result_array();
    }
    public function updateAndAddCustomer($params){
            $this->db->where('id', $params["id"]);
            $query = $this->db->get('tasks'); 
            $task = $query->row();
            $this->db->insert('customers', ["name"=> $task->customer_name]);
            $this->db->where('id', $params["id"]);
            $this->db->update('tasks', ["status" => 1]);
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tasks');
        
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    
}
