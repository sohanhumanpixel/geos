<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TimesheetsModel extends CI_Model {
	
	function getSheetData($emplyeeId,$startdate,$enddate){
		//echo $projectTypeId.'<br>';echo $emplyeeId.'<br>';echo $startdate.'<br>';echo $enddate.'<br>';die('ooo');
        //$this->db->select('employee_id, project_id, instructions, date, time_from, time_to');
		$this->db->select("timesheets.id as schedule_id,timesheets.instructions, timesheets.schedule_date,timesheets.job_number,timesheets.task_ids,timesheets.is_locked,timesheets.all_day,projects.project_name,projects.	induction_url, projects.project_address, companies.company_name AS client_name, schedule_status.color_code");
		//$this->db->group_by('employee_id'); 
		$this->db->from('timesheets');
		$this->db->join('projects', 'timesheets.project_id = projects.id');
		$this->db->join('companies', 'projects.client_id = companies.id');
		$this->db->join('schedule_status', 'schedule_status.id = timesheets.status_id','left');
		//$this->db->where('timesheets.project_type_id', $projectTypeId);
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
		 
		 $jobid = date('ym').''.str_pad($insert_id, 3, '0', STR_PAD_LEFT);
		 
		 //check job id alredy or not
		 
		 $udateData = array('job_number'=>$jobid);
		 $this->db->where('id', $insert_id);
		 $this->db->update('timesheets',$udateData);
		 return $insert_id;
	 }
	 
	/**
	  *Get schedule data
	  *date: 13-10-2018
	 */
	function getEditSchedule($scheduleId){
		$this->db->select("timesheets.id, timesheets.project_id, timesheets.project_type_id, timesheets.client_id,timesheets.task_ids,timesheets.subtask_ids,timesheets.project_task_ids, timesheets.job_number, timesheets.schedule_date, timesheets.all_day, timesheets.status_id,timesheets.instructions, timesheets.employee_id,CONCAT(users.fname, ' ', users.lname) AS emplyeename");
		$this->db->from('timesheets');
		$this->db->join('users', 'timesheets.employee_id = users.id');
		$this->db->where('timesheets.id', $scheduleId);
		$query = $this->db->get();
        return $query->result_array();
	}
	
	/**
	 *@update schedule data from here
	 */
	 function editSchedule($editSdata, $schId){
		$this->db->where('id', $schId);
		$updateSt = $this->db->update('timesheets',$editSdata);
		return $updateSt;
	 }
	
    function getTasksByEmployee($id, $searchText = '', $page, $segment){
    	$this->db->select("e.*,p.project_name,CONCAT(users.fname, ' ', users.lname) AS creator_name");
		$this->db->from('employee_tasks as e');
		$this->db->join('timesheets as t', 't.id = e.timesheet_id');
        $this->db->join('projects as p', 'p.id = e.project_id');
		$this->db->join('users', 't.created_by = users.id');
        $this->db->where("e.employee_id",$id);
        $this->db->where("e.parent_task",0);
        $this->db->order_by("e.schedule_date", "desc");
        $this->db->limit($page, $segment);
		$query = $this->db->get();
        return $query->result();
    }
    function addEmpTasks($data)
    {
    	$this->db->insert('employee_tasks', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
    }
    function taskEmpCount($id, $searchText=""){
    	$this->db->select("id,COUNT(id) as count");
        $this->db->from("employee_tasks");
        $this->db->where("employee_id",$id);
        $this->db->where("parent_task",0);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->count;
    }
    function getTaskDetail($taskID)
    {
    	$this->db->select("*");
        $this->db->from("tasks");
        $this->db->where("id",$taskID);
        $query = $this->db->get();
        return $query->result();
    }
    function getSubTaskDetail($taskID,$etID)
    {
    	$q = $this->db->query("SELECT timesheet_id,task_id FROM employee_tasks WHERE id=$etID");
    	$r = $q->result_array();
    	$timesheet_id = $r[0]['timesheet_id'];
    	$task_id = $r[0]['task_id'];
    	$this->db->select("st.*,et.is_complete,et.start_task,et.end_task,et.id as empTaskId");
        $this->db->from("subtasks as st");
        $this->db->join('employee_tasks as et', 'st.id = et.task_id');
        $this->db->where("st.task_id",$taskID);
        $this->db->where("et.parent_task",$task_id);
        $this->db->where("et.timesheet_id",$timesheet_id);
        $query = $this->db->get();
        return $query->result();
    }
    function getEmpTaskById($id){
    	$this->db->select("employee_tasks.*,timesheets.client_id");
        $this->db->from("employee_tasks");
        $this->db->join('timesheets', 'timesheets.id = employee_tasks.timesheet_id');
        $this->db->where("employee_tasks.id",$id);
        $query = $this->db->get();
        return $query->result();
    }
    function editEmpTasks($data,$id)
    {
    	$this->db->where('timesheet_id', $id);
		$updateSt = $this->db->update('employee_tasks',$data);
		return $updateSt;
    }
    function getCommentsTask($emp_tid)
    {
    	$this->db->select("ct.*,u.fname,u.lname");
        $this->db->from("comments_tasks as ct");
        $this->db->join('users as u', 'ct.commented_by = u.id');
        $this->db->where("emp_task_id",$emp_tid);
        $this->db->order_by("ct.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function getPhotosTask($emp_tid)
    {
        $this->db->select("pt.*,u.fname,u.lname");
        $this->db->from("photos_tasks as pt");
        $this->db->join('users as u', 'pt.uploaded_by = u.id');
        $this->db->where("emp_task_id",$emp_tid);
        $this->db->order_by("pt.id", "asc");
        $query = $this->db->get();
        return $query->result();
    }
    function addEmpRows($data)
    {
        $this->db->insert('employee_rows', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateEmpRows($data,$eid,$pid)
    {
        $this->db->where('employee_id', $eid);
        $this->db->where('project_type_id', $pid);
        $updateSt = $this->db->update('employee_rows',$data);
        return $updateSt;
    }
    function deleteSchedule($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('timesheets');
        return true;
    }
    function deleteEmpTasks($id)
    {
        $this->db->where('timesheet_id', $id);
        $this->db->delete('employee_tasks');
        return true;
    }
    function deleteEmpProjectTasks($id)
    {
        $this->db->where('timesheet_id', $id);
        $this->db->delete('employee_project_tasks');
        return true;
    }
    function checkForLeave($emp_id,$booking_time)
    {
        $this->db->select("id");
        $this->db->from("emp_leave");
        $this->db->where("emp_id",$emp_id);
        $this->db->where("leave_from_date<=",$booking_time);
        $this->db->where("leave_to_date>=",$booking_time);
        $this->db->where("status",1);
        $query = $this->db->get();
        return $query->result();
    }
    function addEmpProjectTasks($data)
    {
        $this->db->insert('employee_project_tasks', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function projectTaskEmpCount($id, $searchText=""){
        $this->db->select("id,COUNT(id) as count");
        $this->db->from("employee_project_tasks");
        $this->db->where("employee_id",$id);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->count;
    }
    function getProjectTasksByEmployee($id, $searchText = '', $page, $segment){
        $this->db->select("e.*,p.project_name,CONCAT(users.fname, ' ', users.lname) AS creator_name");
        $this->db->from('employee_project_tasks as e');
        $this->db->join('timesheets as t', 't.id = e.timesheet_id');
        $this->db->join('projects as p', 'p.id = e.project_id');
        $this->db->join('users', 't.created_by = users.id');
        $this->db->where("e.employee_id",$id);
        $this->db->order_by("e.schedule_date", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    function getEmpProjTaskById($taskID)
    {
        $this->db->select("employee_project_tasks.*,timesheets.client_id");
        $this->db->from("employee_project_tasks");
        $this->db->join('timesheets', 'timesheets.id = employee_project_tasks.timesheet_id');
        $this->db->where("employee_project_tasks.id",$taskID);
        $query = $this->db->get();
        return $query->result();
    }
    function getProjectTaskDetail($taskID)
    {
        $this->db->select("*");
        $this->db->from("tasks_project");
        $this->db->where("id",$taskID);
        $query = $this->db->get();
        return $query->result();
    }
    function getCommentsProjTask($emp_tid)
    {
        $this->db->select("ct.*,u.fname,u.lname");
        $this->db->from("comments_project_tasks as ct");
        $this->db->join('users as u', 'ct.commented_by = u.id');
        $this->db->where("emp_task_id",$emp_tid);
        $this->db->order_by("ct.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function getPhotosProjTask($emp_tid)
    {
        $this->db->select("pt.*,u.fname,u.lname");
        $this->db->from("photos_project_tasks as pt");
        $this->db->join('users as u', 'pt.uploaded_by = u.id');
        $this->db->where("emp_task_id",$emp_tid);
        $this->db->order_by("pt.id", "asc");
        $query = $this->db->get();
        return $query->result();
    }
    function getScheduleStatus()
    {
        $this->db->select("id,status");
        $this->db->from("schedule_status");
        $query = $this->db->get();
        return $query->result();
    }
    function projEmpCount($id, $searchText="")
    {
        $this->db->select("id");
        $this->db->group_by('project_id');
        $this->db->from("employee_tasks");
        $this->db->where("employee_id",$id);
        $query = $this->db->get();
        return count($query->result());
    }
    function getProjectsByEmployee($id, $searchText = '', $page, $segment)
    {
        $this->db->select("t.project_id,p.id,p.project_name");
        $this->db->group_by('project_id');
        $this->db->from("employee_tasks as t");
        $this->db->join('projects as p', 'p.id = t.project_id');
        $this->db->where("employee_id",$id);
        $this->db->order_by("t.schedule_date", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    function checkAllDay($date,$emp_id)
    {
        $this->db->select("schedule_date,all_day");
        $this->db->from('timesheets');
        $this->db->where('schedule_date', $date);
        $this->db->where('employee_id', $emp_id);
        $query = $this->db->get();
        $result = $query->result_array();
        if(@$result[0]['all_day']==1){
            return 'style="display:none;"';
        }else{
            return 'style="border-top:none;width:209pt;"';
        }
    }
    function checkDayEntry($date,$emp_id,$timesheet_id=0)
    {
        $this->db->select("schedule_date");
        $this->db->from('timesheets');
        $this->db->where('schedule_date', $date);
        $this->db->where('employee_id', $emp_id);
        if($timesheet_id!=0)
            $this->db->where('id!=', $timesheet_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function empTaskDayEntry($timesheetId,$task_id,$sub_ids)
    {
        $query = $this->db->query("SELECT * FROM employee_tasks WHERE timesheet_id=$timesheetId AND parent_task=$task_id AND task_id IN ($sub_ids)");
        return $query->result_array();
    }
    function getStartTimeTask($emp_taskId)
    {
        $this->db->select("task_id,start_time,total_duration");
        $this->db->from('employee_tasks');
        $this->db->where('id', $emp_taskId);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getStartTimeProTask($emp_taskId)
    {
        $this->db->select("task_id,start_time,total_duration");
        $this->db->from('employee_project_tasks');
        $this->db->where('id', $emp_taskId);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getTaskIdByParentEntry($id)
    {
        $this->db->select("*");
        $this->db->from('employee_tasks');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>