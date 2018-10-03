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
	
	$data['title'] = 'Time List2';
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
  */
 function getEmployee($type_id){
	$startdate = date('Y-m-d');
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
/**
 *@get Single User data
 *@scope fo this function -- Private
 */
private function __singleUser($userId){
	$singleUquery = $this->db->query("SELECT id as userid, fname, lname from users WHERE id=$userId");
	$singleU = $singleUquery->result_array();
	return $singleU;
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
  * @method:ajax_checkEmailExists
  * @purpose: check duplicacy of user email on registration/edit page
  * model used: users
  */
  
 public function ajax_checkEmailExists(){
		$userId = $this->input->post("userId");
       $email = $this->input->post("email");
		$this->load->model('users');
        if(empty($userId)){
            $result = $this->users->checkEmailExists($email);
        } else {
            $result = $this->users->checkEmailExists($email, $userId);
        }
        if(empty($result)){
			echo("true"); 
			}
        else { echo("false"); }
 }
 
 /**
  * @method:ajax_checkUsernameExists
  * @purpose: check duplicacy of username on registration/edit page
  * model used: users
  */
 public function ajax_checkUsernameExists(){
	 $userId = $this->input->post("userId");
       $username = $this->input->post("username");
		$this->load->model('users');
        if(empty($userId)){
            $result = $this->users->checkUsernameExists($username);
        } else {
            $result = $this->users->checkUsernameExists($username, $userId);
        }
        if(empty($result)){
			echo("true"); 
			}
        else { echo("false"); }
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
	 *Get Role List
	 */
	 public function roleList(){
		$data['title'] = 'Admin Role List';
		$this->load->model('users');
		$data['roles'] = $this->users->getUserRoles();
		$this->load->view('includes/header',$data);
		$this->load->view('admin/admin_role_list');
	 }
}
?>