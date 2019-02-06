<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class Schedules extends BaseController {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		//$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		$this->isLoggedIn(); 
	}
	public function index() {
			$this->listtimesheet();
	}
/**
 *@method name: userListing
 *@other method: userListingCount, userListing  - both method exist into users model
 *@ Author: Human Pixel
 *@date: 01-10-2018
*/ 
 public function listtimesheet(){
	$this->load->model('timesheetsModel');
	$this->load->model('project_type');
	$this->load->model('users');
	$this->load->model('clients');
	$this->load->model('bookings');
	$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	$data['title'] = 'Schedule';
	$typedata = $this->project_type->getPList();
	//echo '<pre>';
	//print_r($typedata);
	//print_r($allEmp);
	$data['ptypedata'] = $typedata;
	$data['bookingData'] = $this->bookings->getBookingSchedule();
	$data['scheduleStatus'] = $this->timesheetsModel->getScheduleStatus();
	$this->load->view('includes/header',$data);
	$this->load->view('timesheet/timesheettemplate');
 }

 function testTemplate()
 {
 	$this->load->model('timesheetsModel');
	$this->load->model('project_type');
	$this->load->model('users');
	$this->load->model('clients');
	$this->load->model('bookings');
	$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	$data['title'] = 'Schedule';
	$typedata = $this->project_type->getPList();
	//echo '<pre>';
	//print_r($typedata);
	//print_r($allEmp);
	$data['ptypedata'] = $typedata;
	$data['bookingData'] = $this->bookings->getBookingSchedule();
	$this->load->view('includes/header',$data);
	$this->load->view('timesheet/schedule-template');
 }
 
 /**
  *this function called into view 
  *getJob data datewise
  */
 function getEmployee($startdate){
	//$startdate = date('Y-m-d');
	$enddate = date('Y-m-d', strtotime("+7 day"));
	//$query = $this->db->query("SELECT DISTINCT(employee_id) FROM timesheets WHERE project_id=$type_id AND (date >= '$startdate' AND date <= '$enddate')");
	$emprole = ROLE_EMPLOYEE;
	$query = $this->db->query("SELECT id as userId, fname,lname FROM users WHERE role_id=$emprole");
	$useIdss = $query->result_array();
	
	//Now going to fetch user and their data form time sheet
	$allData = array();
	if(!empty($useIdss)){
		foreach($useIdss as $k=>$userval){
			$allEmp = $this->timesheetsModel->getSheetData( $userval['userId'], $startdate,$enddate);
			//$singleUser = $this->__singleUser($userval['employee_id']);
			$allData[$k]['userData'] = $userval;
			$allData[$k]['userTimeSheetData'] = $allEmp;
			//print_r($allEmp);
			//print_r($singleUser);
		}
		
	}
	return $allData;
}

public function filtersamedate($arrayDara,$date){
	$newarray = array();
	foreach ($arrayDara as $data)
    {
        if ($data['schedule_date'] == $date){
           //$newarray[$date][] = $data;
		   $newarray[] = $data;
		}
    }
	return $newarray;
}

/**
 *@getClients List
 *this method calls in view 
 *created date: 04-10-2018
 */
 public function getAllClient(){
	$this->layout = null;
	//$this->load->model('clients');
	$clientquery = $this->db->query("SELECT fname, lname, id as clientId FROM clients WHERE isDeleted=0");
	return $clientquery->result_array();
	
 }
 
 /**
  *@method name: get_ajaxProjects
  *@prams: clientId
  *@whereUsing: add schedule/ Edit Schedule
  */
  
  public function get_ajaxProjects(){
  	 $this->load->model('project_type');
	 $clientId = $_REQUEST['cid'];
  	 $search = $_REQUEST['q'];
  	 $emp_id = $_REQUEST['empid'];
	 $projects = $this->project_type->getLiveProjects($search, $clientId);
	 $projects = $this->project_type->IsExcludedFilter($emp_id,$projects);
  	 echo $projects;
	 die;
  }
  public function get_ajaxClients(){
  	$this->load->model('companies');
  	$search = $_REQUEST['q'];
  	$clients = $this->companies->getLiveCompanies($search);
  	echo json_encode($clients);
	 die;
  }
  public function ajax_getEditProject(){
	  $this->layout = null;
	 $clientId = $_POST['cid'];
	 $projectquery = $this->db->query("SELECT id as pId, project_name, 	client_id FROM projects WHERE client_id=$clientId AND isDeleted=0");
	 $projectdata = $projectquery->result_array();
	 $selectHtml = '<label>Site</label><select name="editsitename" id="sitename" class="required form-control"><option value="">Select Project</option>';
	 $optinsval = '';
	 if(!empty($projectdata)){
		 foreach($projectdata as $pval){
			 $optinsval.='<option value="'.$pval['pId'].'">'.$pval['project_name'].'</option>';
		 }
	 }
	//print_r($projectquery->result_array());
     $selectHtml .= $optinsval.'</select>';
	 echo json_encode(array('resdata'=>$selectHtml));
	  die;
  }
 

/**
 *@get Single User data
 *@scope fo this function -- Private
 */
private function __singleUser($userId){
	$singleUquery = $this->db->query("SELECT id as userid, fname, lname from users WHERE id=$userId");
	$singleU = $singleUquery->result_array();
	return $singleU;
}

/**
 *@submti Time sheet Ajax
 */
 
 public function ajax_addSchedule(){
	  $this->layout = null; 
	 $this->load->model('timesheetsModel');
	 $emp_id = $_POST['emp_id'];
	 $booking_time = $_POST['bookingtime'];
	 $checkForLeave = $this->timesheetsModel->checkForLeave($emp_id,$booking_time);
	 if(!empty($checkForLeave)){
	 	echo json_encode(array('status'=>'isOnLeave','msg'=>'This employee is on leave this day.'));
	 	die;
	 } else{
	 	$task_ids  = $this->input->post('task_ids')!="" ? $this->input->post('task_ids') : array();
    	$task_ids  = implode(',', $task_ids);
        $subtask_ids  = $this->input->post('subtask_ids')!="" ? $this->input->post('subtask_ids') : array();
        $subtask_ids  = implode(',', $subtask_ids);
        $proj_task_ids  = $this->input->post('proj_task_ids')!="" ? $this->input->post('proj_task_ids') : array();
        $proj_task_ids  = implode(',', $proj_task_ids);
        $all_day  = $this->input->post('all_day')!="" ? 1 : 0;
        if($all_day==1){
        	$checkDayEntry = $this->timesheetsModel->checkDayEntry($_POST['bookingtime'],$emp_id);
        	if(!empty($checkDayEntry)){
        		$messageArray = array('status'=>'alreadyAss','msg'=>'Task already added on this day,so you cannot set this task to full day');
        		echo json_encode($messageArray);
        		die;
        	}
        }
		$dataSchedule = array('employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['sitename'], 'project_type_id'=>$_POST['project_type_id'],'task_ids'=>$task_ids,'subtask_ids'=>$subtask_ids,'project_task_ids'=>$proj_task_ids,'schedule_date'=>$_POST['bookingtime'], 'client_id'=>$_POST['clientname'], 'status_id'=>$_POST['status'], 'all_day'=>$all_day,'client_name'=>$_POST['clientname'], 'instructions'=>$_POST['instructions'],'created_by'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'));
		 //Inseter into shcedule table
		$taskAr = $_POST['task_ids'];
		$result = $this->timesheetsModel->addSchedule($dataSchedule);
		 foreach($taskAr as $tId){
		 	$data = array('timesheet_id'=>$result,'employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['sitename'],'task_id'=>$tId,'parent_task'=>0,'schedule_date'=>$_POST['bookingtime']);
		 	$this->timesheetsModel->addEmpTasks($data);
		 	$subTasks = $this->input->post('subtask_ids');
		 	foreach($subTasks as $subT){
		 		$dataSub = array('timesheet_id'=>$result,'employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['sitename'],'task_id'=>$subT,'parent_task'=>$tId,'schedule_date'=>$_POST['bookingtime']);
		 		$this->timesheetsModel->addEmpTasks($dataSub);
		 	}
		 }
		 if($proj_task_ids!=""){
		 	$projectTaskIds = $this->input->post('proj_task_ids');
		 	foreach($projectTaskIds as $projectTaskId){
			 	$data = array('timesheet_id'=>$result,'employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['sitename'],'task_id'=>$projectTaskId,'schedule_date'=>$_POST['bookingtime']);
			 	$this->timesheetsModel->addEmpProjectTasks($data);
			}
		 }
	     if($result > 0){
				$messageArray = array('status'=>'success','message'=>'schedule added success');
			} else {
				$messageArray = array('status'=>'error','message'=>'Internal Error!');
			}
			$this->output
	    ->set_content_type('application/json');
		 echo json_encode($messageArray);
		  die;
	 }
	 
 }
 
 /*
  *@method name: grouplist
  *@author: Human Pixel
  *@create date: 01-10-2018
  */
 public function grouplist(){
	$userLogin = $this->session->userdata ( 'logged_in' );
	$this->load->model('groups');
	$data['empGroupData'] = $this->groups->getEmpGroup($userLogin['user_id']);
	$data['title'] = 'Employee Group';
	$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	$this->load->view('includes/header',$data);
	$this->load->view('admin/employee_glist');	
 }
 
 /**
    * This function is used to delete the user using userId
    * @return boolean $result : TRUE / FALSE
  */
    public function ajax_deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
			$this->load->model('users');
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
            $result = $this->users->deleteUser($userId, $userInfo);
           if ($result > 0) {
			   echo(json_encode(array('status'=>TRUE)));
			   }else{
				   echo(json_encode(array('status'=>FALSE))); 
				}
        }
    }
	
	/**
	 *@get Edit Data for sheet
	 */
	 public function ajax_editScheduleData(){
		$scheduleId = $_POST['scheduleId'];
		$empId = $_POST['epmId'];
		// Get schedule data of specific table
		$this->layout = null; 
		$this->load->model('timesheetsModel');
		$this->load->model('project_type');
		$clientData = $this->getAllClient();
		$scheduleData = $this->timesheetsModel->getEditSchedule($scheduleId);
		$clientId = $scheduleData[0]['client_id'];
		$projectId = $scheduleData[0]['project_id'];
		$projectquery = $this->db->query("SELECT id as pId, project_name, client_id FROM projects WHERE client_id=$clientId and isDeleted=0");

		$projquery = $this->db->query("SELECT task_ids FROM projects WHERE id=$projectId and isDeleted=0");
	 	$projdata = $projquery->result_array();
		$task_ids = $projdata[0]['task_ids'];
	 	$task_ids = explode(',', $task_ids);
	 	$taskArData = array();
	 	foreach($task_ids as $task_id){
	 		$taskquery = $this->db->query("SELECT id,title,abbr FROM tasks WHERE id=$task_id and is_deleted=0");
	 		$taskdata = $taskquery->result_array();
	 		array_push($taskArData, $taskdata[0]);
	 	}
		$data['cliendata'] = $clientData;
		$data['scheduleData'] = $scheduleData;
		$data['empId'] = $empId;
		$data['projectData'] = $projectquery->result_array();
		$data['taskData'] = $taskArData;
		$data['project_tasks'] = $this->project_type->getProjectTasksByProjectId($projectId);
		$typedata = $this->project_type->getPList();
		$data['scheduleStatus'] = $this->timesheetsModel->getScheduleStatus();
		$data['ptypedata'] = $typedata;
		if ($this->input->is_ajax_request()) {
			$this->load->view('timesheet/ajax_edit_schedule',$data);
		}
		//$this->load->view('timesheet/ajax_edit_schedule');
		//echo json_encode(array('status'=>'success','scheData'=>$scheduleData));
		//die;
	 }
	 
	 /**
	  *@method: ajax_updateScheduleData
	  */
	  
	  public function ajax_updateScheduleData(){
		  if ($this->input->is_ajax_request()) {
			 $this->layout = null; 
			$this->load->model('timesheetsModel'); 
			$scheduleId = $_POST['schedule_id'];
			$task_ids = isset($_POST['task_ids']) ? implode(',', $_POST['task_ids']) : "";
			$subtask_ids = isset($_POST['subtask_ids']) ? implode(',', $_POST['subtask_ids']) : "";
			$project_task_ids = isset($_POST['proj_task_ids']) ? implode(',', $_POST['proj_task_ids']) : "";
			$all_day = isset($_POST['all_day']) ? 1 : 0;
			if($all_day==1){
	        	$checkDayEntry = $this->timesheetsModel->checkDayEntry($_POST['editbookingtime'],$_POST['emp_id'],$scheduleId);
	        	if(!empty($checkDayEntry)){
	        		$messageArray = array('status'=>'alreadyAss','msg'=>'Task already added on this day,so you cannot set this task to full day');
	        		echo json_encode($messageArray);
	        		die;
	        	}
	        }
			$editScheduleD = array('project_id'=>$_POST['editsitename'], 'project_type_id'=>$_POST['project_type_id'],'task_ids'=>$task_ids,'subtask_ids'=>$subtask_ids,'project_task_ids'=>$project_task_ids,'schedule_date'=>$_POST['editbookingtime'], 'client_id'=>$_POST['editclientname'], 'status_id'=>$_POST['status'], 'all_day'=>$all_day,'client_name'=>$_POST['editclientname'], 'instructions'=>$_POST['instructions'],'updated_at'=>date('Y-m-d H:i:s'));
			//Inseter into shcedule table
			$result = $this->timesheetsModel->editSchedule($editScheduleD,$scheduleId);
			$this->db->where('timesheet_id',$scheduleId);
			$this->db->delete('employee_tasks');
			$this->db->where('timesheet_id',$scheduleId);
			$this->db->delete('employee_project_tasks');
			if(isset($_POST['task_ids']) && $_POST['task_ids']!=""){
				$taskAr = $_POST['task_ids'];
				foreach($taskAr as $tId){
				 	$data = array('timesheet_id'=>$scheduleId,'employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['editsitename'],'task_id'=>$tId,'schedule_date'=>$_POST['editbookingtime']);
				 	$this->timesheetsModel->addEmpTasks($data);
				 	$subTasks = $_POST['subtask_ids'];
				 	foreach($subTasks as $subT){
				 		$dataSub = array('timesheet_id'=>$scheduleId,'employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['editsitename'],'task_id'=>$subT,'parent_task'=>$tId,'schedule_date'=>$_POST['editbookingtime']);
				 		$this->timesheetsModel->addEmpTasks($dataSub);
				 	}
				 }
			}
			if($project_task_ids!=""){
			 	$projectTaskIds = $_POST['proj_task_ids'];
			 	foreach($projectTaskIds as $projectTaskId){
				 	$data = array('timesheet_id'=>$scheduleId,'employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['editsitename'],'task_id'=>$projectTaskId,'schedule_date'=>$_POST['editbookingtime']);
				 	$this->timesheetsModel->addEmpProjectTasks($data);
				}
			 }
     if($result){
			$messageArray = array('status'=>'success','message'=>'Schedule updated success');
		} else {
			$messageArray = array('status'=>'error','message'=>'Internal Error!');
		}
		$this->output
    ->set_content_type('application/json');
	 echo json_encode($messageArray);
	  die; 
		  }
	  }
	
	public function ajax_getTasks(){
		$this->layout = null;
	 	$projectId = $_POST['pid'];
	 	$projquery = $this->db->query("SELECT task_ids FROM projects WHERE id=$projectId and isDeleted=0");
	 	$projdata = $projquery->result_array();
	 	$task_ids = $projdata[0]['task_ids'];
	 	$task_ids = explode(',', $task_ids);
	 	$htmlCh = '<label>Tasks</label><div>';
	 	$inpVal = '';
	 	if(!empty($task_ids)){
		 	foreach($task_ids as $task_id){
		 		$taskquery = $this->db->query("SELECT id,title,abbr FROM tasks WHERE id=$task_id and is_deleted=0");
		 		$taskdata = $taskquery->result_array();
			 	$inpVal.='<input name="task_ids[]" type="checkbox" class="t_'.$taskdata[0]['id'].'" value="'.$taskdata[0]['id'].'">'.$taskdata[0]['title'].' '.$taskdata[0]['abbr'];
			 	$inpVal .= '<br><span class="st_space"></span>';
			 	$subtaskQu = $this->db->query("SELECT id,title,abbr FROM subtasks WHERE task_id=$task_id and is_deleted=0");
			 	$subtasks = $subtaskQu->result_array();
			 	foreach($subtasks as $subtask){
			 		$inpVal.='<input name="subtask_ids[]" data-parent="'.$taskdata[0]['id'].'" class="st_'.$taskdata[0]['id'].'" type="checkbox" value="'.$subtask['id'].'">'.$subtask['title'].' '.$subtask['abbr'];
			 	}
			 	$inpVal .= '<br>';
		 	}
	 	}else{
	 		$inpVal.='No Tasks';
	 	}
	 	$customTaskQu = $this->db->query("SELECT id,title FROM tasks_project WHERE project_id=$projectId");
	 	$customTaskRe = $customTaskQu->result_array();
	 	$custVal = '<label class="pjt_label">Project Tasks</label><div>';
	 	if(!empty($customTaskRe)){
		 	foreach($customTaskRe as $custom_task){
			 	$custVal.='<input name="proj_task_ids[]" type="checkbox" value="'.$custom_task['id'].'">'.$custom_task['title'];
		 	}
	 	}else{
	 		$custVal.='No Project Tasks';
	 	}
		//print_r($projectquery->result_array());
     	$htmlCh .= $inpVal.'</div>'.$custVal.'</div>';
	 	echo json_encode(array('resdata'=>$htmlCh));
	  	die;
  }
  public function ajax_lockSchedule()
  {
  	$is_lock = $_REQUEST['is_lock'];
  	$scheduleId = $_REQUEST['scheduleId'];
  	$this->load->model('timesheetsModel');
  	$data = array('is_locked'=>!$is_lock); 
  	$result = $this->timesheetsModel->editSchedule($data,$scheduleId);
  	if($result){
		$messageArray = array('status'=>'success','message'=>'Success');
	} else {
		$messageArray = array('status'=>'error','message'=>'Internal Error!');
	}
  	die;
  }
  public function getProjectsByClient()
  {
  	$cid  = $_REQUEST['cid'];
  	$query = $this->db->query("SELECT id, project_name FROM projects WHERE client_id=$cid AND isDeleted=0");
	$projects = $query->result_array();
	$html = '';
	foreach($projects as $project){
		$html .= '<option value="'.$project['id'].'">'.$project['project_name'].'</option>';
	}
	echo $html;
	die;
  }
  public function ajax_saveDraggedSchedule()
  {
  	$this->load->model('timesheetsModel');
  	$emp_id = $_POST['empid'];
	 $booking_time = $_POST['date'];
	 $checkForLeave = $this->timesheetsModel->checkForLeave($emp_id,$booking_time);
	 if(!empty($checkForLeave)){
	 	echo json_encode(array('status'=>'isOnLeave','msg'=>'This employee is on leave this day.'));
	 	die;
	 }else{
	  	$booking_id = $_POST['id'];
	  	$bookingQu = $this->db->query("SELECT * FROM bookings WHERE id=$booking_id");
	  	$bookingData = $bookingQu->result_array();
	  	$is_locked = $bookingData[0]['must_done']==1 ? 1 : 0;
	  	$all_day = $bookingData[0]['all_day']==1 ? 1 : 0;
	  	$dataSchedule = array('employee_id'=>$_POST['empid'],'project_id'=>$bookingData[0]['project_id'], 'project_type_id'=>$_POST['ptype_id'],'task_ids'=>$bookingData[0]['task_ids'],'subtask_ids'=>$bookingData[0]['subtask_ids'],'project_task_ids'=>$bookingData[0]['project_task_ids'],'schedule_date'=>$_POST['date'], 'client_id'=>$bookingData[0]['company_id'],'client_name'=>$bookingData[0]['company_id'], 'instructions'=>$bookingData[0]['instructions'], 'is_locked'=>$is_locked, 'all_day'=>$all_day,'created_by'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'));
		 //Inseter into shcedule table
		$taskAr = explode(',', $bookingData[0]['task_ids']);
		$result = $this->timesheetsModel->addSchedule($dataSchedule);
		foreach($taskAr as $tId){
		 	$data = array('timesheet_id'=>$result,'employee_id'=>$_POST['empid'],'project_id'=>$bookingData[0]['project_id'],'task_id'=>$tId,'schedule_date'=>$_POST['date']);
		 	$this->timesheetsModel->addEmpTasks($data);
		 	$subTasks = explode(',', $bookingData[0]['subtask_ids']);
		 	foreach($subTasks as $subT){
		 		$dataSub = array('timesheet_id'=>$result,'employee_id'=>$_POST['empid'],'project_id'=>$bookingData[0]['project_id'],'task_id'=>$subT,'parent_task'=>$tId,'schedule_date'=>$_POST['date']);
		 		$this->timesheetsModel->addEmpTasks($dataSub);
		 	}
		}
		if($bookingData[0]['project_task_ids']!=""){
		 	$projectTaskIds = explode(',', $bookingData[0]['project_task_ids']);
		 	foreach($projectTaskIds as $projectTaskId){
			 	$data = array('timesheet_id'=>$result,'employee_id'=>$_POST['empid'],'project_id'=>$bookingData[0]['project_id'],'task_id'=>$projectTaskId,'schedule_date'=>$_POST['date']);
			 	$this->timesheetsModel->addEmpProjectTasks($data);
			}
		 }
		$this->db->query("UPDATE bookings SET isAssigned=1 WHERE id=$booking_id");
		if($result > 0){
			$messageArray = array('status'=>'success','message'=>'schedule added success');
		} else {
			$messageArray = array('status'=>'error','message'=>'Internal Error!');
		}
		echo json_encode($messageArray);
		die;
	}
  }
  public function ajax_moveDraggedSchedule()
  {
  	$this->load->model('timesheetsModel');
  	$emp_id = $_POST['empid'];
	 $booking_time = $_POST['date'];
	 $checkForLeave = $this->timesheetsModel->checkForLeave($emp_id,$booking_time);
	 if(!empty($checkForLeave)){
	 	echo json_encode(array('status'=>'isOnLeave','msg'=>'This employee is on leave this day.'));
	 	die;
	 }else{
	  	$job_id = $_POST['job_id'];
	  	$key = $_POST['key'];
	  	$schQu = $this->db->query("SELECT * FROM timesheets WHERE id=$job_id");
	  	$scheduleD = $schQu->result_array();
	  	$dataSchedule = array('employee_id'=>$_POST['empid'],'project_id'=>$scheduleD[0]['project_id'], 'project_type_id'=>$_POST['ptype_id'],'task_ids'=>$scheduleD[0]['task_ids'],'subtask_ids'=>$scheduleD[0]['subtask_ids'],'project_task_ids'=>$scheduleD[0]['project_task_ids'],'schedule_date'=>$_POST['date'], 'client_id'=>$scheduleD[0]['client_id'],'client_name'=>$scheduleD[0]['client_id'], 'instructions'=>$scheduleD[0]['instructions'],'created_by'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'));
	  	$taskAr = explode(',', $scheduleD[0]['task_ids']);
	  	if($key==1){
	  		$result = $this->timesheetsModel->editSchedule($dataSchedule, $job_id);
	  		$data = array('employee_id'=>$_POST['empid'],'schedule_date'=>$_POST['date']);
			 $this->timesheetsModel->editEmpTasks($data,$job_id);
	  		if($result){
				$messageArray = array('status'=>'success','message'=>'schedule updated');
			} else {
				$messageArray = array('status'=>'error','message'=>'Internal Error!');
			}
	  	}else{
			$result = $this->timesheetsModel->addSchedule($dataSchedule);
			foreach($taskAr as $tId){
			 	$data = array('timesheet_id'=>$result,'employee_id'=>$_POST['empid'],'project_id'=>$scheduleD[0]['project_id'],'task_id'=>$tId,'schedule_date'=>$_POST['date']);
			 	$this->timesheetsModel->addEmpTasks($data);
			 	$subTasks = explode(',', $scheduleD[0]['subtask_ids']);
			 	foreach($subTasks as $subT){
			 		$dataSub = array('timesheet_id'=>$result,'employee_id'=>$_POST['empid'],'project_id'=>$scheduleD[0]['project_id'],'task_id'=>$subT,'parent_task'=>$tId,'schedule_date'=>$_POST['date']);
			 		$this->timesheetsModel->addEmpTasks($dataSub);
			 	}
			}
			if($scheduleD[0]['project_task_ids']!=""){
			 	$projectTaskIds = explode(',', $scheduleD[0]['project_task_ids']);
			 	foreach($projectTaskIds as $projectTaskId){
				 	$data = array('timesheet_id'=>$result,'employee_id'=>$_POST['empid'],'project_id'=>$scheduleD[0]['project_id'],'task_id'=>$projectTaskId,'schedule_date'=>$_POST['date']);
				 	$this->timesheetsModel->addEmpProjectTasks($data);
				}
			 }
			if($result > 0){
				$messageArray = array('status'=>'success','message'=>'schedule added success');
			} else {
				$messageArray = array('status'=>'error','message'=>'Internal Error!');
			}
	  	}
		echo json_encode($messageArray);
		die;
	}
  }
  public function ajax_lockAllSchedule()
  {
  	$todayDate = $_POST['todaydate'];
  	$endDate = date('Y-m-d', strtotime($todayDate.'+4 days'));
  	$result = $this->db->query("UPDATE timesheets SET is_locked=1 WHERE schedule_date>='$todayDate' AND schedule_date<='$endDate'");
  	if($result){
		$messageArray = array('status'=>'success','message'=>'schedule updated');
	} else {
		$messageArray = array('status'=>'error','message'=>'Internal Error!');
	}
	echo json_encode($messageArray);
	die;
  }
  public function ajax_addRowEmp()
  {
  	$this->load->model("timesheetsModel");
  	$eid = $_POST['eid'];
  	$pid = $_POST['pid'];
  	$row = $_POST['row'];
  	$todaydate = $_POST['todayDate'];
  	$date = new DateTime($todaydate);
  	for($i=1; $i <= 6; $i++){
		$date->modify('+1 day');
		$weekOfdays[] = $date->format('D');
		$weekOfdate[] = $date->format('Y-m-d');
	}
  	$checkQ = $this->db->query("SELECT id,extra_rows FROM employee_rows WHERE employee_id=$eid AND project_type_id=$pid");
  	$checkR = $checkQ->result();
  	if(empty($checkR)){
  		$data = array(
  			'employee_id'     => $eid,
  			'project_type_id' => $pid,
  			'extra_rows'      => 1,
  			'total_rows'      => $row+1
  		);
  		$result = $this->timesheetsModel->addEmpRows($data);
  	}else{
  		$currentExR = $checkR[0]->extra_rows;
  		$data = array(
  			'employee_id'     => $eid,
  			'project_type_id' => $pid,
  			'extra_rows'      => $currentExR+1,
  			'total_rows'      => $row+1
  		);
  		$result = $this->timesheetsModel->updateEmpRows($data,$eid,$pid);
  	}
  	$empNameQ = $this->db->query("SELECT fname,lname FROM users WHERE id=$eid");
  	$empNameR = $empNameQ->result();
  	$empName = $empNameR[0]->fname.' '.$empNameR[0]->lname;
  	$inRow = $row+1;
  	//$html = '<tr height="20" class="collapse in accordion_'.$pid.'  subtbale_'.$eid.'_'.$pid.' lower_trs lower_trs_0"><td height="20" style="height:15.0pt;border-top:none;border-left:none">Task '.$inRow.'</td><td style="border-top:none;width:209pt" class="ui-droppable"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="" data-ptypeid="'.$pid.'" data-date="'.$todaydate.'" data-empname="'.$empName.'">Add</button></td></td><td style="border-top:none;width:209pt" class="ui-droppable"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$eid.'" data-ptypeid="'.$pid.'" data-date="'.$weekOfdate[0].'" data-empname="'.$empName.'">Add</button></td><td style="border-top:none;width:209pt" class="ui-droppable"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$eid.'" data-ptypeid="'.$pid.'" data-date="'.$weekOfdate[1].'" data-empname="'.$empName.'">Add</button></td><td style="border-top:none;width:209pt" class="ui-droppable"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$eid.'" data-ptypeid="'.$pid.'" data-date="'.$weekOfdate[2].'" data-empname="'.$empName.'">Add</button></td><td style="border-top:none;width:209pt" class="ui-droppable"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$eid.'" data-ptypeid="'.$pid.'" data-date="'.$weekOfdate[3].'" data-empname="'.$empName.'">Add</button></td></tr>';
  	//echo json_encode($html);
  	die;
  }
  public function ajax_minusRowEmp()
  {
  	$this->load->model("timesheetsModel");
  	$eid = $_POST['eid'];
  	$pid = $_POST['pid'];
  	$row = $_POST['row'];
  	$checkQ = $this->db->query("SELECT id,extra_rows FROM employee_rows WHERE employee_id=$eid AND project_type_id=$pid");
  	$checkR = $checkQ->result();
	$currentExR = $checkR[0]->extra_rows;
	$data = array(
		'employee_id'     => $eid,
		'project_type_id' => $pid,
		'extra_rows'      => $currentExR-1,
		'total_rows'      => $row-1
	);
	$result = $this->timesheetsModel->updateEmpRows($data,$eid,$pid);
  }
  public function ajax_deleteSchedule()
  {
  	$timesheet_id = $_POST['id'];
  	$this->load->model("timesheetsModel");
  	$this->timesheetsModel->deleteSchedule($timesheet_id);
  	$this->timesheetsModel->deleteEmpTasks($timesheet_id);
  	$this->timesheetsModel->deleteEmpProjectTasks($timesheet_id);
  	echo json_encode(array('status'=>'success','msg'=>'Schedule Deleted Successfully'));
  	die;
  }
}
?>