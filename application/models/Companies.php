<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Companies extends CI_Model {
	function addNewCompany($companyInfo)
    {
        $this->db->trans_start();
        $this->db->insert('companies', $companyInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    function CompanyCount($searchText = '')
    {
         $this->db->select('c.id');
        $this->db->from('companies as c');
        $this->db->join('users as User', 'User.id = c.created_by','left');
        $this->db->where('c.is_deleted',0);
        $query = $this->db->get();
        
        return count($query->result());
    }
    public function getCompanies($searchText = '', $page, $segment,$sort='asc',$search='') {
        $this->db->select("c.*, User.fname as firstname,User.lname as lastname");
        $this->db->from("companies as c");
        $this->db->join('users as User', 'User.id = c.created_by','left');
        $this->db->where('c.is_deleted',0);
        $this->db->order_by("c.company_name", $sort);
        if($search!="")
        $this->db->like('c.company_name', $search);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }
    public function getCompanyById($id) {
        $this->db->select("*");
        $this->db->from("companies");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function editCompany($companyInfo, $companyId)
    {
        $this->db->where('id', $companyId);
        $this->db->update('companies', $companyInfo);
        
        return TRUE;
    }
    public function deleteCompany($companyId, $companyInfo)
    {
        $this->db->where('id', $companyId);
        $this->db->update('companies', $companyInfo);
        return $this->db->affected_rows();
    }
    public function getAllCompanies()
    {
    	$this->db->select("id,company_name");
        $this->db->from("companies");
        $this->db->where("is_deleted",0);
        $query = $this->db->get();

        return $query->result();
    }
    public function addNotesCompany($data)
    {
        $this->db->insert('notes', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getNotesCompany($id)
    {
        $this->db->select("n.id,n.note_title,n.note_content,CONCAT(u.fname,' ',u.lname) as full_name");
        $this->db->from("notes as n");
        $this->db->join("users as u","u.id=n.created_by","left");
        $this->db->where("n.company_id",$id);
        $this->db->order_by("n.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function saveNotesCompany($data,$id)
    {
        $this->db->where("id",$id);
        $this->db->update('notes', $data);
        return true;
    }
    public function deleteNotesCompany($id)
    {
        $this->db->where("id",$id);
        $this->db->delete('notes');
        return true;
    }
    public function getContactsByCompany($id)
    {
        $this->db->select("*");
        $this->db->from("clients");
        $this->db->where("company",$id);
        $this->db->where("isDeleted!=",1);
        $this->db->order_by("fname",'asc');
        $this->db->order_by("lname",'asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function addTasksCompany($data)
    {
        $this->db->insert('tasks_company', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getTasksCompany($id)
    {
        $this->db->select("t.id,t.employee_assigned,t.title,t.description,CONCAT(u.fname,' ',u.lname) as full_name");
        $this->db->from("tasks_company as t");
        $this->db->join("users as u","u.id=t.created_by","left");
        $this->db->where("t.company_id",$id);
        $this->db->order_by("t.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function deleteTasksCompany($id)
    {
        $this->db->where("id",$id);
        $this->db->delete('tasks_company');
        return true;
    }
    public function saveTasksCompany($data,$id)
    {
        $this->db->where("id",$id);
        $this->db->update('tasks_company', $data);
        return true;
    }
    public function getLiveCompanies($k)
    {
        $this->db->select("id,company_name as label");
        $this->db->from("companies");
        $this->db->where("company_name LIKE '%$k%'");
        $this->db->where("is_deleted",0);
        $query = $this->db->get();

        return $query->result();
    }
}