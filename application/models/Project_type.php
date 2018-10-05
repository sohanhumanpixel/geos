<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class project_type extends CI_Model {
	function getPList(){
		$this->db->select('id, project_type_name');
        $this->db->from('project_type');
		$this->db->order_by("project_type_name", "asc");
        $query = $this->db->get();
        return $query->result();
	}
	function getInductions(){
		$this->db->select('id, name');
        $this->db->from('online_induction');
        $query = $this->db->get();
        return $query->result();
	}
	function addNewProject($data){
        $this->db->insert('projects', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
	}
	function projectCount($searchText = '')
    {
         $this->db->select('p.id');
        $this->db->from('projects as p');
        $this->db->join('clients as c', 'p.client_id = c.id','left');
        $query = $this->db->get();
        
        return count($query->result());
    }
    public function getProjects($searchText = '', $page, $segment) {
        $this->db->select("p.*, c.fname,c.lname,u.fname as firstname,u.lname as lastname");
        $this->db->from("projects as p");
        $this->db->join('clients as c', 'p.client_id = c.id','left');
        $this->db->join('users as u', 'p.project_manager_id = u.id','left');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }
    public function getProjectById($id) {
        $this->db->select("*");
        $this->db->from("projects");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function editProject($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('projects', $data);
        
        return TRUE;
    }
}
?>