<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bookings extends CI_Model {
	public function addNewBooking($data)
	{
		$this->db->trans_start();
        $this->db->insert('bookings', $data);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
	}

	function BookingCount($searchText = '')
    {
        $this->db->select('b.id');
        $this->db->from('bookings as b');
        $this->db->join('users as User', 'User.id = b.created_by','left');
        $this->db->where('b.isDeleted',0);
        $query = $this->db->get();
        
        return count($query->result());
    }

    public function getBookings($searchText = '', $page, $segment) {
        $this->db->select("b.*, User.fname as firstname,User.lname as lastname,c.company_name,CONCAT(cl.fname,' ',cl.lname) as contact_name,p.project_name");
        $this->db->from("bookings as b");
        $this->db->join('users as User', 'User.id = b.created_by','left');
        $this->db->join('companies as c', 'c.id = b.company_id','left');
        $this->db->join('clients as cl', 'cl.id = b.contact_id','left');
        $this->db->join('projects as p', 'p.id = b.project_id','left');
        $this->db->where('b.isDeleted',0);
        $this->db->where('b.isAssigned',0);
        $this->db->order_by("b.id", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    public function getBookingByID($id) {
        $this->db->select("*");
        $this->db->from("bookings");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }

    public function editBooking($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('bookings', $data);
        
        return TRUE;
    }
	
	/**
	 *@fetch booking list on schedule page
	 */
	 
	public function getBookingSchedule(){
		 $this->db->select("b.*, User.fname as firstname,User.lname as lastname,c.company_name,CONCAT(cl.fname,' ',cl.lname) as contact_name,p.project_name");
        $this->db->from("bookings as b");
        $this->db->join('users as User', 'User.id = b.created_by','left');
        $this->db->join('companies as c', 'c.id = b.company_id','left');
        $this->db->join('clients as cl', 'cl.id = b.contact_id','left');
        $this->db->join('projects as p', 'p.id = b.project_id','left');
        $this->db->where('b.isDeleted',0);
        $this->db->where('b.isAssigned',0);
        $this->db->order_by("b.id", "desc");
        $query = $this->db->get();
        return $query->result();
	 }
	
}