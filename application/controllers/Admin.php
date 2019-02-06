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
		if($this->role==ROLE_EMPLOYEE){
			redirect('Employee/dashboard');
		}
        $this->load->model('announcements');
        $userRole = $this->announcements->getUserRole($this->vendorId);
        if($userRole[0]->role_name=='Employee'){
            $access = 'all';
        }else{
            $access = '';
        }
        $data['announcements'] = $this->announcements->getAnns($access);
		$data['title'] = 'Dashboard';
		$this->load->model('project_type');
		$data['projectCount'] = $this->project_type->projectCount();
        $this->load->model('users');
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$data['employeeCount'] = $this->users->employeeCount();
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
	 if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->library('pagination');
			$searchText = '';
			$count = $this->users->userListingCount($searchText);
			$returns = $this->paginationCompress ( "employee_list/", $count, 10 );
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            if($this->role!=1){
              $access='admin';
            }else{
                $access = '';
            }
			$data['userRecords'] = $this->users->userListing($searchText, $returns["page"], $returns["segment"],$this->vendorId,$access);
			$this->session->set_userdata('referred_from', current_url());
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
	 if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['roles'] = $this->users->getUserRoles();
			$data['title'] = 'Add New Employee';
			$data['allskills'] = $this->users->getAllSkills();
			$this->load->view('includes/header',$data);
			$this->load->view('admin/add_new_emp');
		}
 }
 
 
 /**
   * This function is used to add new user to the system
  */
    public function addNewUser()
    {
        if($this->isTicketter() == TRUE)
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
				$skillsInput = $this->input->post('user_skills');
				$constcartName = '';
				if($_FILES['construction_card']['name']!=''){
					//Upload
					$upload_path = "assets/images/usercard/";
					$imagetype = $_FILES['construction_card']['type'];
					$filename = $_FILES['construction_card']['name'];
					$tempname = $_FILES["construction_card"]["tmp_name"];
					$t = preg_replace('/\s+/', '', time());
					$fileName = $t . ''.str_replace(' ','',$filename);
					$moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
					if( $moved ) {
						$constcartName = $fileName;
					}
				}
                $userInfo = array('email'=>$email, 'password'=>md5($password), 'role_id'=>$roleId, 'fname'=> $fname,'lname'=> $lname,
                                    'username'=>$username,'contact_phone'=>$this->input->post('contact_phone'), 'address'=>$this->input->post('address'),'construction_card'=>$constcartName, 'createdBy'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('users');
                $result = $this->users->addNewUser($userInfo);
                
                if($result > 0)
                {
					if(!empty($skillsInput)){
						foreach($skillsInput as $skill){
							$this->db->query("INSERT INTO users_skills ( user_id, skill_id) VALUES ('$result', '$skill')");
						}
					}
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
		$this->load->model('users');
			if($userId == null)
            {
                redirect('employee_list');
            }
			
            if($this->role!=1){
                $access = 'admin';
            }else{
                $access = '';
            }
            $data['referred_from'] = $this->session->userdata('referred_from');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['roles'] = $this->users->getUserRoles($access);
			$data['allskills'] = $this->users->getAllSkills();
			$userdata = $this->users->getUserInfo(convert_uudecode(base64_decode($userId)));
			if(empty($userdata)){
				  redirect('employee_list');
			}
			$data['title'] = 'Edit Employee';
			$data['userInfo'] = $userdata;
			$data['userSkills'] = $this->users->getUserSkillIDs(convert_uudecode(base64_decode($userId)));
			
			$this->load->view('includes/header',$data);
			$this->load->view('admin/edit_emp');
		
	}
	
	
	/**
     * This function is used to edit the user information
     */
    public function editEmpSave()
    {
		$this->load->library('form_validation');
        $referred_from = $this->session->userdata('referred_from');
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
            $skillsInput = $this->input->post('user_skills');
			
			if($_FILES['construction_card']['name']!=''){
				//Upload
				$upload_path = "assets/images/usercard/";
				$imagetype = $_FILES['construction_card']['type'];
				$filename = $_FILES['construction_card']['name'];
				$tempname = $_FILES["construction_card"]["tmp_name"];
				$t = preg_replace('/\s+/', '', time());
				$fileName = $t . ''.str_replace(' ','',$filename);
				$moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
				if( $moved ) {
					$oldcons = $this->input->post('oldcard');
					$constcartName = $fileName;
					($oldcons!='') ? unlink($upload_path.''.$oldcons): '';
				}
			}else{
				$constcartName = '';
			}
			
			
            $userInfo = array();
            $password = '';
            if(empty($password))
            {
            	if($constcartName!=""){
                    $userInfo = array('email'=>$email, 'role_id'=>$roleId, 'fname'=> $fname,'lname'=> $lname,'username'=>$username,'contact_phone'=>$this->input->post('contact_phone'), 'address'=>$this->input->post('address'),'construction_card'=>$constcartName, 'updatedBy'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
                }else{
                	$userInfo = array('email'=>$email, 'role_id'=>$roleId, 'fname'=> $fname,'lname'=> $lname,'username'=>$username,'contact_phone'=>$this->input->post('contact_phone'), 'address'=>$this->input->post('address'), 'updatedBy'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
                }
            }
            else
            {
            	if($constcartName!=""){
                    $userInfo = array('email'=>$email, 'password'=>md5($password), 'role_id'=>$roleId,'fname'=> $fname,'lname'=> $lname,'username'=>$username, 'updatedBy'=>$this->vendorId,'contact_phone'=>$this->input->post('contact_phone'),'address'=>$this->input->post('address'),'construction_card'=>$constcartName,'updated_at'=>date('Y-m-d H:i:s'));
                }else{
                	$userInfo = array('email'=>$email, 'password'=>md5($password), 'role_id'=>$roleId,'fname'=> $fname,'lname'=> $lname,'username'=>$username, 'updatedBy'=>$this->vendorId,'contact_phone'=>$this->input->post('contact_phone'),'address'=>$this->input->post('address'),'updated_at'=>date('Y-m-d H:i:s'));
                }
            }
            
            $result = $this->users->editUser($userInfo, $userId);
            
            if($result == true)
            {
				if(!empty($skillsInput)){
					//First delete user skills then need to inseret
					$this->db->query("DELETE FROM users_skills WHERE user_id = $userId");
					foreach($skillsInput as $skill){
						$this->db->query("INSERT INTO users_skills ( user_id, skill_id) VALUES ('$userId', '$skill')");
					}
				}
                $this->session->set_flashdata('success', 'User updated successfully');
				redirect($referred_from);
            }
            else
            {
                $this->session->set_flashdata('error', 'User updation failed');
				 redirect($referred_from);
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
        if($this->isTicketter() == TRUE)
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
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$data['roles'] = $this->users->getUserRoles();
		$this->load->view('includes/header',$data);
		$this->load->view('admin/admin_role_list');
	 }
	 
	 /**
	  *@user's view Profile
	  *@created date: 18-10-2018
	  */
	  
    public function viewprofile($userId){
		if($this->isTicketter() == TRUE)
		{
			$this->loadThis();
		}else{
			$data['title'] = 'User Profile';
			$realuserId = convert_uudecode(base64_decode($userId));
			$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['profileData'] = $this->users->userProfileData($realuserId);
			//echo '<pre>';
			//print_r($userData);
			//die;
			$this->load->view('includes/header',$data);
			$this->load->view('admin/userprofile');
		}
	}
	
	/**
	 *Add User Skills
	 *@created date: 18-10-2018
	 */
	
    public function AddUserSkills($userId){
		if($this->isTicketter() == TRUE)
		{
			$this->loadThis();
			
		}else{
			$realuserId = convert_uudecode(base64_decode($userId));
			$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['title'] = 'User Profile';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/addskillstemp');
		}
		
	}
	
	/**
		 * Get HTML Template for Uploade Image
		 * Created Date: 19-10-2018
		 */
	function ajax_editImageHtml(){
		if ($this->input->is_ajax_request()) {
			if($_FILES['profileimage']['name']!=''){
				$currentUserId = convert_uudecode(base64_decode($_POST['uuid']));
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
				$upload_path = "assets/images/profile/";
				$imagetype = $_FILES['profileimage']['type'];
				$filename = $_FILES['profileimage']['name'];
				$tempname = $_FILES["profileimage"]["tmp_name"];
				
				$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
				
				$t = preg_replace('/\s+/', '', time());
				$fileName = $t . ''.str_replace(' ','',$filename);
				
				if ($_FILES["profileimage"]["size"] > 500000) {
					echo json_encode(array('status'=>'error','message'=>'Sorry, your file is too large.'));
					die;
				}else if(!in_array($imageFileType, $valid_extensions)){
					echo json_encode(array('status'=>'error','message'=>$imageFileType));
					die;
				}else{
					$moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
					if( $moved ) {
						//unlink image
						$oimage = $_POST['oimage'];
						($oimage!='') ? unlink($upload_path.''.$oimage): '';
						$this->load->model('users');
						$updateD = array('image'=>$fileName);
						$this->users->updateProfileimg($updateD,$currentUserId);
						echo json_encode(array('status'=>'success','message'=>base_url().''.$upload_path.''.$fileName));die;
					}else{
						echo json_encode(array('status'=>'error','message'=>"Not uploaded because of error #".$_FILES["document_name"]["error"]));die;
					}
				}	
			}else{
				echo json_encode(array('status'=>'error','message'=>"Please Select image"));
				die;
			}
		}
		die;
	}
	
   /**
	 *Add User Skills
	 *@created date: 18-10-2018
	*/
	
    public function GetUserSkills($userId){
			
	}	
	
	public function get_ajaxUsers()
	{
		$this->load->model('users');
	  	$search = $_REQUEST['q'];
		$users = $this->users->getAllLiveUsers($search);
	  	echo json_encode($users);
		die;
	}
}
?>