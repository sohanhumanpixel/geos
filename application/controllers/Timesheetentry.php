<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Employee Time Sheet Entry
 * @purpose: Integrate time sheet
 */
Class Timesheetentry extends BaseController {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
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
 *@date: 23-10-2018
*/ 
 public function listtimesheet(){
	 if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
			
		}else{
			$this->load->model('TimesheetentriesModel');
			$this->load->model('users');
			$data['title'] = 'TimeSheet';
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->model('users');
			
			$count = $this->TimesheetentriesModel->userCount();
			
			$returns = $this->paginationCompress ( "Timesheetentry/listtimesheet", $count, 10 );
			
			$data['memberData'] = $this->TimesheetentriesModel->getMember($returns["page"],$returns["segment"]);
			
			$this->load->view('includes/header',$data);
			
			$this->load->view('timesheetentry/timesheetentrytemplate');
		}
 }
 
 public function ajax_getTimeModal(){
		$userId = $_POST['user_id'];
		// Get schedule data of specific table
		$this->layout = null; 
		$this->load->model('TimesheetentriesModel');
		$UserData = $this->__singleUser($userId);
		$projectquery = $this->db->query("SELECT id as pId, project_name, client_id FROM projects");
		
		$data['userData'] = $UserData;
		//$data['scheduleData'] = $scheduleData;
		$data['projectData'] = $projectquery->result_array();
		if ($this->input->is_ajax_request()) {
			$this->load->view('timesheetentry/ajax_add_time',$data);
		}
	}
 
 /**
 *@get Single User data
 *@scope fo this function -- Private not access out of this class
 */
private function __singleUser($userId){
	$singleUquery = $this->db->query("SELECT id as userid, fname, lname from users WHERE id=$userId");
	$singleU = $singleUquery->result_array();
	return $singleU;
}

function ajax_addTimeEntry(){
	$this->layout = null; 
	$this->load->model('TimesheetentriesModel');
	$timediff = strtotime($_POST['to_time'])- strtotime($_POST['from_time']);
	if(isset($_POST['subtask_ids']) && isset($_POST['proj_task_ids'])){
		$messageArray = array('status'=>'multiple_task_error','message'=>'Please select either task or project task at a time');
		echo json_encode($messageArray);
		die;
	}
	if(isset($_POST['subtask_ids']) && @$_POST['subtask_ids'][1]!=""){
		$messageArray = array('status'=>'multiple_task_error','message'=>'Please select only single task at a time');
		echo json_encode($messageArray);
		die;
	}
	if(isset($_POST['proj_task_ids']) && @$_POST['proj_task_ids'][1]!=""){
		$messageArray = array('status'=>'multiple_task_error','message'=>'Please select only single project task at a time');
		echo json_encode($messageArray);
		die;
	}
	if(!isset($_POST['subtask_ids']) && !isset($_POST['proj_task_ids'])){
		$messageArray = array('status'=>'multiple_task_error','message'=>'Please select task');
		echo json_encode($messageArray);
		die;
	}
	$task_id = isset($_POST['task_ids']) ? $_POST['task_ids'][0] : "";
	$subtask_id = isset($_POST['subtask_ids']) ? $_POST['subtask_ids'][0] : "";
	$proj_task_id = isset($_POST['proj_task_ids']) ? $_POST['proj_task_ids'][0] : "";
	//$hours = $timediff/3600;
	$dataSchedule = array('employee_id'=>$_POST['user_id'],'project_id'=>$_POST['sitename'],'client_id'=>$_POST['clientname'], 'task_id'=>$task_id, 'subtask_id'=>$subtask_id, 'project_task_id'=>$proj_task_id,'start_date'=>$_POST['start_date'], 'time_from'=>$_POST['from_time'],'time_to'=>$_POST['to_time'], 'time_entry_duration'=>$timediff, 'note_text'=>$_POST['note_text'],'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
	 //Inseter into shcedule table
	$result = $this->TimesheetentriesModel->addTimesheetEntry($dataSchedule);
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

/**
 *@this function is used in view (timesheettemplate.php)
 *@added date: 24-10-2018
 */
 
public function getUserEntry($userId,$startdate,$endate){
	
	$this->load->model('TimesheetentriesModel');
	$EntryData =  $this->TimesheetentriesModel->getEntryData($userId,$startdate,$endate);
	return $EntryData;
}

/**
 *@single user time sheet with details
 *@date: 24-10-2018
 */
 
 public function resourcetimesheet($userId=NULL){
	 if($userId==''){
		 redirect('Timesheetentry/listtimesheet');
	 }
	$this->load->model('TimesheetentriesModel');
	$data['title'] = 'GEOS | Staff TimeSheet';
	$this->load->model('users');
	
	$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	$data['singleStaff'] = $this->TimesheetentriesModel->getSinleStaff($userId);
	$contstartdate = (isset($_GET['date']) and $_GET['date'] !='') ? $_GET['date'] : date('Y-m-d');
	$newdate = new DateTime($contstartdate);
	$enddate = $newdate->modify('+6 day');
	$contrenddate = $newdate->format('Y-m-d');
	
	$allSheetQu = $this->db->query("SELECT tenty.*, projects.project_name, projects.induction_url, projects.project_address, projects.client_id,companies.company_name FROM timesheet_entries as tenty LEFT JOIN projects ON tenty.project_id = projects.id LEFT JOIN companies ON companies.id  = tenty.client_id WHERE tenty.employee_id = $userId AND (tenty.start_date >= '$contstartdate' AND tenty.start_date < NOW() + INTERVAL 6 DAY) ORDER BY tenty.start_date ASC");
	
	$data['allSheetData'] = $allSheetQu->result_array();
	$this->load->view('includes/header',$data);
	$this->load->view('timesheetentry/resourcetimesheettemp',$data);
 }
 
 public function getUserEntryReso($userId,$startdate,$endate){
	$this->load->model('TimesheetentriesModel');
	$EntryData =  $this->TimesheetentriesModel->getEntryData($userId,$startdate,$endate);
	return $EntryData;
}

 /**
  *@get Modal For Add TimeSheet
  */
 /*public function ajax_getTimeModal(){
	 $this->layout = null;
	 $clientId = $_POST['user_id'];
	 $projectquery = $this->db->query("SELECT id as pId, project_name, client_id FROM projects");
	 $projectdata = $projectquery->result_array();
	 $selectHtml = '<label>Site</label><select name="editsitename" id="editsitename" class="required form-control"><option value="">Select Project</option>';
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
 */
 
 /**
  *@method name: ajax_getProject
  *@prams: clientId
  *@whereUsing: add schedule/ Edit Schedule
  */
  /*
  public function ajax_getProject(){
	  $this->layout = null;
	 $clientId = $_POST['cid'];
	 $projectquery = $this->db->query("SELECT id as pId, project_name, 	client_id FROM projects WHERE client_id=$clientId");
	 $projectdata = $projectquery->result_array();
	 $selectHtml = '<label>Site</label><select name="sitename" id="sitename" class="required form-control"><option value="">Select Project</option>';
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
  */

	
}
?>