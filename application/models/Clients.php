<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Clients extends CI_Model {
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("clients");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    function addNewClient($clientInfo)
    {
        $this->db->trans_start();
        $this->db->insert('clients', $clientInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    function ClientCount($searchText = '')
    {
         $this->db->select('c.id');
        $this->db->from('clients as c');
        $this->db->join('users as User', 'User.id = c.created_by','left');
        $this->db->where('c.isDeleted',0);
        $query = $this->db->get();
        
        return count($query->result());
    }
    public function getClients($searchText = '', $page, $segment) {
        $this->db->select("c.*, User.fname as firstname,User.lname as lastname");
        $this->db->from("clients as c");
        $this->db->join('users as User', 'User.id = c.created_by','left');
        $this->db->where('c.isDeleted',0);
        $this->db->order_by("c.id", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }
    public function getClientById($id) {
        $this->db->select("*");
        $this->db->from("clients");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function editClient($clientInfo, $clientId)
    {
        $this->db->where('id', $clientId);
        $this->db->update('clients', $clientInfo);
        
        return TRUE;
    }
    public function deleteClient($clientId, $clientInfo)
    {
        $this->db->where('id', $clientId);
        $this->db->update('clients', $clientInfo);
        return $this->db->affected_rows();
    }
    public function getAllClients()
    {
    	$this->db->select("id,fname,lname");
        $this->db->from("clients");
        $query = $this->db->get();

        return $query->result();
    }
}