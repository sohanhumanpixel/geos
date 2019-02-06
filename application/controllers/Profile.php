<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class Profile extends BaseController {
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
	
	/**
	 *@Updated Date: 19-10-2018
	 */
	 
    public function index(){
     	$this->load->model('users');
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
     	//$userdata = $this->users->getUserInfo($this->vendorId);
		$data['profileData'] = $this->users->userProfileData($this->vendorId);
     	//$data['userInfo'] = $userdata;
        $data['title'] = 'Edit Profile';
        if($this->isAdmin() == TRUE){
        	$data['isAdmin'] = FALSE;
        }else{
        	$data['isAdmin'] = TRUE;
        }
        $data['allEmployees']= $this->users->getAllEmployee();
        $data['excludedProjects'] = $this->users->getExcludedProjects();
        $this->session->set_userdata('referred_from', current_url());
		$this->load->view('includes/header',$data);
		$this->load->view('admin/myprofile');
    }
    public function action(){
     	$this->load->library('form_validation');
            
            $userId = $this->vendorId;
            
            $this->form_validation->set_rules('fname','First name','trim|required|max_length[128]');
			$this->form_validation->set_rules('lname','Last name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('username','Username','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {
				$this->load->model('users');
                if($this->input->post('profile')!=""){
                    $img = $this->input->post('profile');
                    $upload_path=base_url()."assets/images/profile/"; 
                    $uid='10'; //creare seperate folder for each user 
                    $upPath=$upload_path."/".$uid;
                    $config = array(
                    'upload_path' => $upPath,
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'overwrite' => TRUE,
                    'max_size' => "2048000", 
                    'max_height' => "768",
                    'max_width' => "1024"
                    );
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('profile');
                    die('kkk');
                    
                }
                $fname = ucwords(strtolower($this->input->post('fname')));
				$lname = ucwords(strtolower($this->input->post('lname')));
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                
                $userInfo = array();
                $password = '';
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'fname'=> $fname,'lname'=> $lname,'username'=>$username, 'updatedBy'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
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
					redirect('Profile');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
					 redirect('Profile');
                }
            }
        }
        public function password(){
	        $data['title'] = 'Change Password';
	        $this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->view('includes/header',$data);
			$this->load->view('admin/change_password');
        }
        public function changePass(){
        	$this->load->library('form_validation');
            
            $this->form_validation->set_rules('password', 'Current Password', 'trim|required');
	        $this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|min_length[4]');
	        $this->form_validation->set_rules('confirm_pass', 'Confirm New Password', 'trim|required|matches[new_pass]');
	        if($this->form_validation->run() == FALSE) {
	           $this->password();
	        }else {
	        	$this->load->model('users');
                $user_id=$this->vendorId;
	            $current_pwd = $this->input->post('password');
	            $pwd_check = $this->users->check_current_pwd($user_id,$current_pwd);
	            if(empty($pwd_check)){
	              $this->session->set_flashdata('error','Your Current Password is incorrect');
	              redirect('ChangePassword');
	            }else{
		            $dataUpdate = array(
		              'password' => md5($this->input->post('new_pass'))
		            );
	            
			        $result = $this->users->pass_update($user_id,$dataUpdate);
			        if($result==true){
			        $this->session->set_flashdata('success','Password Updated Successfully');
			        }else{
			          $this->session->set_flashdata('error','There is some problem in updating');
			        }
			        redirect('ChangePassword');
			    }
	        }
        }
		
		/**
		 * Get HTML Template for Uploade Image
		 * Created Date: 19-10-2018
		 */
		function ajax_editImageHtml(){
			if ($this->input->is_ajax_request()) {
				if($_FILES['profileimage']['name']!=''){
					$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
					$upload_path = "assets/images/profile/";
					$imagetype = $_FILES['profileimage']['type'];
					$filename = $_FILES['profileimage']['name'];
					$tempname = $_FILES["profileimage"]["tmp_name"];
					//$target_file = 
					
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
							$this->load->model('users');
							$currentUserId = $this->vendorId;
							$updateD = array('image'=>$fileName);
							$this->users->updateProfileimg($updateD,$currentUserId);
							echo json_encode(array('status'=>'success','message'=>base_url().''.$upload_path.''.$fileName));die;
						}else{
							echo json_encode(array('status'=>'success','message'=>"Not uploaded because of error #".$_FILES["document_name"]["error"]));die;
						}
					}	
				}
			}
			die;
		}

		function ajax_ExcludeProjectSave()
		{
			$this->load->model('users');
			$employee_id = $_POST['employee_name'];
			$client_id   = $_POST['client_id'];
			$project_ids = implode(',', $_POST['project_name']);
			$data = array(
				'employee_id' 	=> $employee_id,
				'client_id'   	=> $client_id,
				'project_id'  	=> $project_ids,
				'excluded_by' 	=> $this->vendorId,
				'excluded_date' => date("Y-m-d H:i:s")
			);
			$check = $this->users->checkForExcludedProjectEntry($employee_id);
			if(!empty($check)){
				$response = array('status'=>'already_exists','msg'=>'This employee already added for excluded projects');
	        	echo json_encode($response);
	        	die;
			}
			$result = $this->users->saveExludedProjects($data);
			if($result!=''){
	        	$response = array('status'=>'success');
	        	echo json_encode($response);
	        	die;
	        }else{
	            $response = array('status'=>'error');
	        	echo json_encode($response);
	        	die;
	        }
		}
		function deleteExcludeProjects()
		{
			$this->load->model('users');
			$id = $_POST['id'];
			$result = $this->users->deleteExcludedProjects($id);
			return true;
		}
		function editExcludeProjects()
		{
			$this->load->model('users');
			$this->load->model('project_type');
			$id = $_POST['id'];
			$result = $this->users->editExcludedProjects($id);
			$resul2 = $this->project_type->getProjectsByClient($result[0]->client_id);
			$response = array("data"=>$result,'html'=>$resul2);
			echo json_encode($response);
			die();
		}
		function ajax_ExcludeProjectUpdate()
		{
			$this->load->model('users');
			$edit_id     = $_POST['edit_id'];
			$employee_id = $_POST['editemployee_name'];
			$client_id   = $_POST['editclient_id'];
			$project_ids = implode(',', $_POST['editproject_name']);
			$data = array(
				'employee_id' 	=> $employee_id,
				'client_id'   	=> $client_id,
				'project_id'  	=> $project_ids
			);
			$result = $this->users->updateExludedProjects($data,$edit_id);
			if($result==true){
	        	$response = array('status'=>'success');
	        	echo json_encode($response);
	        	die;
	        }else{
	            $response = array('status'=>'error');
	        	echo json_encode($response);
	        	die;
	        }
		}
    }