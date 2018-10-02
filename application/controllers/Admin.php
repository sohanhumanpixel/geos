<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class Admin extends BaseController {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		$this->isLoggedIn(); 
	}
	public function index() {
			$data['title'] = 'Dashboard';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/dashboard');
	}
/**
 *@method name: userListing
 *@other method: userListingCount, userListing  - both method exist into users model
 *@ Author: Sohan
 *@date: 28-09-2018
*/ 
 public function userListing(){
	 if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
			$this->load->model('users');
			$this->load->library('pagination');
			$searchText = '';
			$count = $this->users->userListingCount($searchText);
			$returns = $this->paginationCompress ( "employee_list/", $count, 10 );
			$data['userRecords'] = $this->users->userListing($searchText, $returns["page"], $returns["segment"]);
			$data['title'] = 'User List';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/user_list');
		}
 }
 
 
 /*
  *@method name: add_new_employee
  *@author: Human Pixel
  *@create date: 28-09-2018
  */
 public function add_new_employee(){
	 if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
			$this->load->model('users');
			$data['roles'] = $this->users->getUserRoles();
			$data['title'] = 'Add New Employee';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/add_new_emp');
		}
 }
 
 
 /**
   * This function is used to add new user to the system
  */
    public function addNewUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','First name','trim|required|max_length[128]');
			$this->form_validation->set_rules('lname','Last name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('username','Username','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add_new_employee();
            }
            else
            {
                $fname = ucwords(strtolower($this->input->post('fname')));
				$lname = ucwords(strtolower($this->input->post('lname')));
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $userInfo = array('email'=>$email, 'password'=>md5($password), 'role_id'=>$roleId, 'fname'=> $fname,'lname'=> $lname,
                                    'username'=>$username, 'createdBy'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('users');
                $result = $this->users->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
					redirect('employee_list');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
					redirect('addNewEmployee');
                }
                
                
            }
        }
    }
	
	/**
	 *@Method name: editemp
	 *@purpose: Edit User/Employee details
	 *@isAdmin: check if super admin then only can access this page
	 */
	 
	public function editemp($userId = NULL){
		if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
			if($userId == null)
            {
                redirect('employee_list');
            }
			$this->load->model('users');
			$data['roles'] = $this->users->getUserRoles();
			
			$userdata = $this->users->getUserInfo(convert_uudecode(base64_decode($userId)));
			if(empty($userdata)){
				  redirect('employee_list');
			}
			$data['userInfo'] = $userdata;
			$data['title'] = 'Add New Employee';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/edit_emp');
		}
		
	}
	
	
	/**
     * This function is used to edit the user information
     */
    public function editEmpSave()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
			
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','First name','trim|required|max_length[128]');
			$this->form_validation->set_rules('lname','Last name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('username','Username','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editemp(base64_encode(convert_uuencode($userId)));
            }
            else
            {
				$this->load->model('users');
				
                $fname = ucwords(strtolower($this->input->post('fname')));
				$lname = ucwords(strtolower($this->input->post('lname')));
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $roleId = $this->input->post('role');
                
                $userInfo = array();
                $password = '';
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'role_id'=>$roleId, 'fname'=> $fname,'lname'=> $lname,'username'=>$username, 'updatedBy'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>md5($password), 'role_id'=>$roleId,
                        'fname'=> $fname,'lname'=> $lname,'username'=>$username, 'updatedBy'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->users->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
					redirect('employee_list');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
					 redirect('employee_list');
                }
                
               
            }
        }
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