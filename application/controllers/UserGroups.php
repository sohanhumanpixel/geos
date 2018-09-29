<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 *@Controller Name: UserGroups
 *@permession to access this module  - Admin, Manager
 *@Author: Human Pixel
 *@created date: 29-09-2018
 */
 
class UserGroups extends BaseController {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		$this->isLoggedIn();
		//is Tickter for Amin and Manager
		$isLoggedIn = $this->session->userdata ( 'logged_in' );
	}
	
	public function grouplist(){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			$data['title'] = 'Groups List';
			$this->load->model('groups');
			$this->load->library('pagination');
			$searchText = '';
			$count = $this->groups->groupListingCount($searchText);
			$returns = $this->paginationCompress ( "UserGroups/grouplist", $count, 2 );
			$data['groupRecords'] = $this->groups->GroupListing($searchText, $returns["page"], $returns["segment"]);
			$this->load->view('includes/header',$data);
			$this->load->view('UserGroups/admin_group_list');
		}
	}
	
	/**
	 *@method name: addGroup
	 *@form persentation part
	 */
	
	public function addGroup(){
		if($this->isTicketter() == TRUE)
        {
			$this->loadThis();
			
        }else{
			$data['title'] = 'Add Group';
			$this->load->view('includes/header',$data);
			$this->load->view('UserGroups/admin_add_group');
		}
		
	}
	
	/**
	 *@this is submisstion Part
	 */
	 
	public function addNewGroup()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('group_name','First name','trim|required|max_length[128]');
		if($this->form_validation->run() == FALSE)
		{
			$this->addGroup();
		}
		else
		{
			$group_name = $this->input->post('group_name');
			
			$userInfo = array('group_name'=>$group_name,'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
			
			$this->load->model('groups');
			$result = $this->groups->addNewGroup($userInfo);
			if($result > 0)
			{
				$this->session->set_flashdata('success', 'New Group created successfully');
				redirect('UserGroups/grouplist');
			}
			else
			{
				$this->session->set_flashdata('error', 'Group creation failed');
				redirect('addGroup');
			}  
		}  
    }
	
	/**
	 *Method: EditGroup
	 *@prams: groupId
	 *@Author: Human Pixel
	 *
	 */
	
	public function editGroup($groupId=NULL){
		if($this->isTicketter() == TRUE)
        {
			$this->loadThis();
        }else{
			if($groupId == null)
            {
                redirect('grouplist');
            }
			
			$this->load->model('groups');
			$groupdata = $this->groups->getGroupInfo(convert_uudecode(base64_decode($groupId)));
			if(empty($groupdata)){
				  redirect('grouplist');
			}
			
			//update in same controller
			if($this->input->post('group_upate')){
				$realgroupId = convert_uudecode(base64_decode($groupId));
				$groupName = $this->input->post('group_name');
				$udateGroupInfo = array('group_name'=>$groupName,'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
			
				$result = $this->groups->updateGroup($udateGroupInfo,$realgroupId);
			 if($result == true)
               {
				$this->session->set_flashdata('success', 'Group has been update successfully');
				redirect('UserGroups/grouplist');
			}
			else
			{
				$this->session->set_flashdata('error', 'Group updations failed');
				redirect('grouplist');
			}  
			}
			
			$data['groupInfo'] = $groupdata;
			$data['title'] = 'Update Group';
			$this->load->view('includes/header',$data);
			$this->load->view('UserGroups/admin_edit_group');
			
		}
	}
	
	public function deleteGroup($deleteId=NULL){
			$this->load->model('groups');
			$this->groups->deleteGroup($deleteId);
			$this->session->set_flashdata('success', 'Group has been deleted successfully');
			redirect('UserGroups/grouplist');
	}
}
?>