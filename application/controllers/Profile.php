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
    public function index(){
     	$this->load->model('users');
     	$userdata = $this->users->getUserInfo($this->vendorId);
     	$data['userInfo'] = $userdata;
        $data['title'] = 'Edit Profile';
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
    }