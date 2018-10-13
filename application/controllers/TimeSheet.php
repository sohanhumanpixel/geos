<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class TimeSheet extends BaseController {
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
	
	$data['title'] = 'Schedule';
	$typedata = $this->project_type->getPList();
	
	//echo '<pre>';
	//print_r($typedata);
	//print_r($allEmp);
	$data['ptypedata'] = $typedata;
	$this->load->view('includes/header',$data);
	$this->load->view('timesheet/timesheettemplate');
 }
 
 /**
  *this function called into view 
  *getJob data datewise
  */
 function getEmployee($type_id,$startdate){
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
			$allEmp = $this->timesheetsModel->getSheetData($type_id, $userval['userId'], $startdate,$enddate);
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
  *@method name: ajax_getProject
  *@prams: clientId
  */
  
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
	 $dataSchedule = array('employee_id'=>$_POST['emp_id'],'project_id'=>$_POST['sitename'], 'project_type_id'=>$_POST['project_type_id'],'schedule_date'=>$_POST['bookingtime'], 'client_id'=>$_POST['clientname'],'client_name'=>$_POST['clientname'], 'instructions'=>$_POST['instructions'],'created_by'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'));
	 //Inseter into shcedule table
	 $result = $this->timesheetsModel->addSchedule($dataSchedule);
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
		 
	 }
	
}
?>