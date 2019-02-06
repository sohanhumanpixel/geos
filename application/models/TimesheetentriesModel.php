<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TimesheetentriesModel extends CI_Model {
	
	/**
	 *@get all Active Members
	 *created date: 23-10-2018
	 */
	 function getMember($page, $segment){
		 $this->db->select("users.id, users.fname,users.lname");
		 $this->db->from('users');
		 $this->db->where('isDeleted',0);
		 $this->db->order_by('users.fname', 'ASC');
		  $this->db->limit($page, $segment);
		 $query = $this->db->get();
        return $query->result_array();
	 }
	 
	 /**
	  *@user Count 
	  *date added: 24-10-2018
	  *
	  */
	  
	function userCount(){
		$this->db->select('users.id');
		$this->db->from('users');
		$this->db->where('users.isDeleted', 0);
		
		$query = $this->db->get();
        return count($query->result());
	}
	
	/**
	 *@list of all users
	 *@date: 24-10-2018
	 */
	function allMember($page, $segment){
		
		$this->db->limit($page, $segment);
	}
	
	 
	function getEntryData($emplyeeId,$startdate,$enddate){
		$this->db->select("timesheet_entries.id as entryId,timesheet_entries.employee_id, timesheet_entries.start_date,timesheet_entries.time_from,timesheet_entries.time_to,timesheet_entries.note_text, SUM(timesheet_entries.time_entry_duration) as totaltime,projects.project_name, projects.induction_url, projects.project_address");
		$this->db->from('timesheet_entries');
		$this->db->join('projects', 'timesheet_entries.project_id = projects.id');
		$this->db->where('timesheet_entries.employee_id', $emplyeeId);
		$this->db->where((" timesheet_entries.start_date >= '$startdate' AND timesheet_entries.start_date <= '$enddate'"));
		$this->db->group_by('DATE(timesheet_entries.start_date)');
		//$this->db->order_by('timesheet_entries.start_date', 'ASC'); 
		$query = $this->db->get();
        return $query->result_array();
	}
	
	/**
	 *Add TimeSheet data
	 *date; 23 OCT, 2018
	 */
	 function addTimesheetEntry($scheduleData){
		 $this->db->insert('timesheet_entries', $scheduleData);
		 $insert_id = $this->db->insert_id();
		 return $insert_id;
	 }
	 
	 function getSinleStaff($staffId){
		 
		 $this->db->select("users.id, users.fname,users.lname");
		 $this->db->from('users');
		 $this->db->where('id',$staffId);
		 $query = $this->db->get();
        return $query->result_array();
	 }
	 
	 function getUserDayTime($emplyeeId,$startdate,$enddate){
		
		 $this->db->select("id as entryId,employee_id, start_date, time_from, time_to, SUM(timesheet_entries.time_entry_duration) as totaltime");
		$this->db->from('timesheet_entries');
		$this->db->where('timesheet_entries.employee_id', $emplyeeId);
		$this->db->where('timesheet_entries.start_date >=', $startdate);
		$this->db->where('timesheet_entries.start_date <=', $enddate);
		$this->db->order_by('timesheet_entries.start_date', 'ASC'); 
		$query = $this->db->get();
        return $query->result_array();
	 }
	 
	/**
	  *Get schedule data
	  *date: 13-10-2018
	 */
	/*function getEditSchedule($scheduleId){
		$this->db->select("timesheets.id, timesheets.project_id, timesheets.project_type_id, timesheets.client_id, timesheets.job_number, timesheets.schedule_date,timesheets.instructions, timesheets.employee_id,CONCAT(users.fname, ' ', users.lname) AS emplyeename");
		$this->db->from('timesheets');
		$this->db->join('users', 'timesheets.employee_id = users.id');
		$this->db->where('timesheets.id', $scheduleId);
		$query = $this->db->get();
        return $query->result_array();
	}*/
	
	/**
	 *@update schedule data from here
	 */
	 /*function editSchedule($editSdata, $schId){
		$this->db->where('id', $schId);
		$updateSt = $this->db->update('timesheets',$editSdata);
		return $updateSt;
	 }*/
	
}
?>