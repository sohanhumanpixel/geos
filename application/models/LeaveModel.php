<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LeaveModel extends CI_Model {
	
	function LeaveCount($empid)
    {
        $this->db->select('emp_leave.id');
        $this->db->from('emp_leave');
        $this->db->where('emp_id',$empid);
        $query = $this->db->get();
        return count($query->result());
    }
	
	/*
	 *@get Leavetype
	 */
	 function getLeaveType(){
		$this->db->select("*");
        $this->db->from(" leave_type");
        $query = $this->db->get();
		return $query->result();
	 }
	
	/**
	 *fetch all employee leave
	 *created date; 17-10-2018
	 *created by: Humanpixel
	 */
	 
	 function leaveListing($page, $segment,$empId){
		$this->db->select("emp_leave.*,leave_typetbl.leave_type_name");
        $this->db->from("emp_leave");
		 $this->db->join('leave_type as leave_typetbl', 'leave_typetbl.id = emp_leave.leave_type','left');
		 $this->db->where('emp_leave.emp_id', $empId);
		 
        $this->db->limit($page, $segment);
        $query = $this->db->get();
		return $query->result();
	 }
	
	/**
	 *Add Schedule data
	 *date; 15 OCT, 2018
	 */
	 function addNewLeaveRequest($leaveData){
		 $this->db->insert('emp_leave', $leaveData);
		 $insert_id = $this->db->insert_id();
		 return $insert_id;
	 }
	 
	/**
	  *Get get Document data by Id
	  *date: 18-10-2018
	 */
	function getLeaveById($leaveId){
		$this->db->select("*");
        $this->db->from("emp_leave");
		$this->db->where('id', $leaveId);
		$query = $this->db->get();
        return $query->result();
	}
	
	/**
	 *@update schedule data from here
	 */
	 function editLeaveRequest($editSdata, $leaveId){
		$this->db->where('id', $leaveId);
		$updateSt = $this->db->update('emp_leave',$editSdata);
		return $updateSt;
	 }
	 
	public function deleteLeave($id){
        $this->db->where('id', $id);
        $this->db->delete('emp_leave');
        return $this->db->affected_rows();
    }
	
	/**
	 *@Employee Calender Data
	 */
	function getEmpLeaveCalendar($empId){
		$this->db->select("emp_leave.leave_reason as title,emp_leave.leave_from_date as start,emp_leave.leave_to_date as end, emp_leave.color, leave_typetbl.leave_type_name");
        $this->db->from("emp_leave");
		 $this->db->join('leave_type as leave_typetbl', 'leave_typetbl.id = emp_leave.leave_type','left');
		 $this->db->where('emp_leave.emp_id', $empId);
        $query = $this->db->get();
		return $query->result();
	}
	
	/**
	 *Upcomming Leave start from here
	 *
	 */
	 function upcomingLeaveCount($empid,$startdate){
		$this->db->select('emp_leave.id');
        $this->db->from('emp_leave');
        $this->db->where('emp_id',$empid);
        $this->db->where('emp_leave.leave_from_date>=',$startdate);
        $query = $this->db->get();
        return count($query->result());
	 }
	 
	 /**
	 *Fetch employee upcomming Leave
	 *created date; 17-10-2018
	 *created by: Humanpixel
	 */
	 function UpcommingLeaveListing($page, $segment,$empId,$startDatefrom){
		$this->db->select("emp_leave.*,leave_typetbl.leave_type_name");
        $this->db->from("emp_leave");
		 $this->db->join('leave_type as leave_typetbl', 'leave_typetbl.id = emp_leave.leave_type','left');
		 $this->db->where('emp_leave.emp_id', $empId);
		 $this->db->where('emp_leave.leave_from_date >=',$startDatefrom);
		 
        $this->db->limit($page, $segment);
        $query = $this->db->get();
		return $query->result();
	 }
	
}
?>