<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TimesheetsModel extends CI_Model {
	
	function getSheetData($projectTypeId,$emplyeeId,$startdate,$enddate){
        //$this->db->select('employee_id, project_id, instructions, date, time_from, time_to');
		$this->db->select("timesheets.instructions, timesheets.schedule_date,timesheets.job_number,projects.project_name,projects.induction, projects.project_address, CONCAT(clients.fname, ' ', clients.lname) AS client_name");
		//$this->db->group_by('employee_id'); 
		$this->db->from('timesheets');
		$this->db->join('projects', 'timesheets.project_id = projects.id');
		$this->db->join('clients', 'projects.client_id = clients.id');
		
		$this->db->where('timesheets.project_type_id', $projectTypeId);
		$this->db->where('timesheets.employee_id', $emplyeeId);
		$this->db->where((" timesheets.schedule_date >= '$startdate' AND timesheets.schedule_date <= '$enddate'"));
		$this->db->order_by('timesheets.schedule_date', 'ASC'); 
		$query = $this->db->get();
        return $query->result_array();
	}
	
	/**
	 *Add Schedule data
	 *date; 04 OCT, 2018
	 */
	 function addSchedule($scheduleData){
		 $this->db->insert('timesheets', $scheduleData);
		 $insert_id = $this->db->insert_id();
		 //
		 $this->db->where('id', $insert_id);
		 $jobid = date('ymd').''.$insert_id;
		 $udateData = array('job_number'=>$jobid);
		 
		 $this->db->update('timesheets',$udateData);
		 return $insert_id;
	 }
	 
	
}
?>