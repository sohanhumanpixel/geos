<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class Employee extends BaseController {
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
			$this->load->model('groups');
			$data['title'] = 'Dashboard';
			$userLogin = $this->session->userdata ( 'logged_in' );
			$data['countGroup'] = $this->groups->countEmpGroup($userLogin['user_id']);
			$this->load->view('includes/header',$data);
			$this->load->view('admin/empdashboard');
	}
/**
 *@method name: userListing
 *@other method: userListingCount, userListing  - both method exist into users model
 *@ Author: Human Pixel
 *@date: 01-10-2018
*/ 
 public function taskList(){
	$this->load->model('users');
	$this->load->library('pagination');
	$searchText = '';
	$count = $this->users->userListingCount($searchText);
	$returns = $this->paginationCompress ( "employee_list/", $count, 1 );
	$data['userRecords'] = $this->users->userListing($searchText, $returns["page"], $returns["segment"]);
	$data['title'] = 'Task List';
	$this->load->view('includes/header',$data);
	$this->load->view('admin/employee_task_list');
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