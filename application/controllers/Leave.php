<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *Employee Leave Management System
 *@ Author: Human Pixel
 *@date: 16-10-2018
 */
require APPPATH . '/libraries/BaseController.php';

Class Leave extends BaseController {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		// Load form validation library
		$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		$this->isLoggedIn(); 
	}
	
	/**
	 *@all leave list
	 *@author: Human Pixel
	 *@created date: 17-10-2018
	 */
	
	public function leavelist(){
		$this->load->model('LeaveModel');
		$this->load->library('pagination');
		$searchText = '';
		$count = $this->LeaveModel->LeaveCount($this->vendorId);
		$returns = $this->paginationCompress ( "Leave/leavelist/", $count, 10 );
		$data['leaveRecords'] = $this->LeaveModel->leaveListing($returns["page"], $returns["segment"],$this->vendorId);
		$data['title'] = 'Leave List';
		$this->load->model('users');
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$this->load->view('includes/header',$data);
		$this->load->view('leave/leave_list');
	}
	
	/**
	 *@method name: applyleave
	 *@purpose: add new leave requat by Employee
	 *@author: Human Pixel 
	 *@created Date: 17-10-2018
	 *@update date: 
	 */
	 
	public function applyleave(){
		//Get Type
		$data['title'] = 'Leave Request';
		$this->load->model('LeaveModel');
		$this->load->model('users');
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$data['leaveType'] = $this->LeaveModel->getLeaveType();
		$this->load->view('includes/header',$data);
		$this->load->view('leave/leave_request');
	}
	/**
	 *@method name: addleave
	 *@purpose: add new leave requat by Employee
	 *@author: Human Pixel 
	 *@created Date: 17-10-2018
	 *@update date: 
	 */
	 
	public function addleave(){
		//Get Type
		$data['title'] = 'Leave Request';
		$this->load->model('LeaveModel');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('leave_type','Leave Type','trim|required|numeric');
		
		$this->form_validation->set_rules('leave_from_date','Leave From','trim|required|date');
        $this->form_validation->set_rules('leave_to_date','Leave To','trim|required');
		$this->form_validation->set_rules('leave_reason','Leave Reason','trim|required');
		
            if($this->form_validation->run() == FALSE)
            {
                $this->applyleave();
            }else{
				//Save Process
				$leave_type = $this->input->post('leave_type');
				$leave_from_date = $this->input->post('leave_from_date');
                $leave_to_date = $this->input->post('leave_to_date');
                $leave_reason = $this->input->post('leave_reason');
                $join_date =  date('Y-m-d',strtotime($leave_to_date . ' +1 day'));
				
				$no_of_days = round((strtotime($leave_to_date)- strtotime($leave_from_date))/(60 * 60 * 24));
				$no_of_days = $no_of_days + 1;
				
                $userInfo = array('leave_type'=>$leave_type, 'leave_from_date'=>$leave_from_date, 'leave_to_date'=>$leave_to_date, 'leave_reason'=> $leave_reason,'no_of_days'=> $no_of_days,'join_date'=>$join_date, 'emp_id'=>$this->vendorId, 'leave_requested_date'=>date('Y-m-d H:i:s'));
				
                $result = $this->LeaveModel->addNewLeaveRequest($userInfo);
				if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Leave request created successfully');
					redirect('Leave/leavelist');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
					redirect('Leave/applyleave');
                }
				
			}
	}
	
	public function editleave($id){
		if($id == null)
            {
                redirect('Leave/leavelist');
            }
	    	$data['title'] = 'Edit Leave';
	    	$this->load->model('LeaveModel');
	    	$editLeaveD = $this->LeaveModel->getLeaveById(convert_uudecode(base64_decode($id)));
	    	$data['leaveType'] = $this->LeaveModel->getLeaveType();
	    	$data['editLeaveData'] = $editLeaveD;
	    	$this->load->model('users');
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	    	$this->load->view('includes/header',$data);
	    	$this->load->view('leave/edit_leave');
	}
	
	/**
	 *Edit Leave Action
	 *created date; 17-10-2018
	 *created by: Humanpixel
	 */
    public function editAction($id)
    {
		$this->load->model('LeaveModel');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('leave_type','Leave Type','trim|required|numeric');
		
		$this->form_validation->set_rules('leave_from_date','Leave From','trim|required|date');
        $this->form_validation->set_rules('leave_to_date','Leave To','trim|required');
		$this->form_validation->set_rules('leave_reason','Leave Reason','trim|required');
		
            if($this->form_validation->run() == FALSE)
            {
                $this->editleave($id);
            }else{
				
			$leave_type = $this->input->post('leave_type');
			$leave_from_date = $this->input->post('leave_from_date');
			$leave_to_date = $this->input->post('leave_to_date');
			$leave_reason = $this->input->post('leave_reason');
			$join_date =  date('Y-m-d',strtotime($leave_to_date . ' +1 day'));
			
			$no_of_days = round((strtotime($leave_to_date)- strtotime($leave_from_date))/(60 * 60 * 24));
			$no_of_days = $no_of_days + 1;
			$LeaveInfo = array('leave_type'=>$leave_type, 'leave_from_date'=>$leave_from_date, 'leave_to_date'=>$leave_to_date, 'leave_reason'=> $leave_reason,'no_of_days'=> $no_of_days,'join_date'=>$join_date, 'updated_at'=>date('Y-m-d H:i:s'));
			
			$result = $this->LeaveModel->editLeaveRequest($LeaveInfo,convert_uudecode(base64_decode($id)));
			if($result > 0){
			   $this->session->set_flashdata('success','Leave Request updated successfully');
			   redirect('Leave/leavelist');
			}else{
				$this->session->set_flashdata('error','Leave request updating failed');
				redirect('Leave/editleave/<?=$id?>');
			} 
		}
	}
	function leavedelete($leaveId){
		$this->load->model('LeaveModel');
        	$this->LeaveModel->deleteLeave(convert_uudecode(base64_decode($leaveId)));
			$this->session->set_flashdata('success','Leave deleted successfully!');
        	redirect('Leave/leavelist');
	}
	
	
	/**
	 *@purpose: employee leave upcomming
	 *@author: Human Pixel 
	 *@created Date: 17-10-2018
	 *@update date: 
	*/
	
	public function leavecomingup(){
		$loginEmpId = $this->vendorId;
		$this->load->model('LeaveModel');
		$this->load->library('pagination');
		$startDate = date('Y-m-d');
		$count = $this->LeaveModel->upcomingLeaveCount($loginEmpId,$startDate);
		$returns = $this->paginationCompress ( "Leave/leavecomingup/", $count, 10 );
		$data['leaveRecords'] = $this->LeaveModel->UpcommingLeaveListing($returns["page"], $returns["segment"],$loginEmpId,$startDate);
		$data['title'] = 'Leave List';
		$this->load->model('users');
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$this->load->view('includes/header',$data);
		$this->load->view('leave/upcomming_leave');
	}
	/**
	 *@get Employee Leave List
	 */
	 
	public function ajax_getEmpLeave(){
		$currentUserId = $this->vendorId;
		$this->load->model('LeaveModel');
		$leavedata = $this->LeaveModel->getEmpLeaveCalendar($currentUserId);
		//print_r($leavedata);
		echo json_encode($leavedata);
		
	die;	
	}
	
}
?>