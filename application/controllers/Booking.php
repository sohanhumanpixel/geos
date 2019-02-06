<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Booking Controller
 * @purpose: tasklist module integration
 */
Class Booking extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		$this->load->library('session');
		$this->isLoggedIn(); 
	}

	public function index()
	{
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->model('bookings');
            $this->load->library('pagination');
            $searchText = '';
            $count = $this->bookings->BookingCount($searchText);
            $returns = $this->paginationCompress ( "Booking", $count, 10 );
            $data['bookings'] = $this->bookings->getBookings($searchText, $returns["page"], $returns["segment"]);
			$data['title'] = 'Bookings';
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->view('includes/header',$data);
			$this->load->view('booking/unassigned_booking');
        }
	}

	public function add()
	{
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->model('users');
            $this->load->model('companies');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['companies'] = $this->companies->getAllCompanies();
        	$data['title'] = 'Add New Booking';
			$this->load->view('includes/header',$data);
			$this->load->view('booking/add_booking');
        }
	}

	public function addAction()
	{
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$company   = $this->input->post('client_name');
            $contact   = $this->input->post('contact')!="" ? $this->input->post('contact') : "";
        	$project   = $this->input->post('project');
        	$task_ids  = $this->input->post('task_ids')!="" ? $this->input->post('task_ids') : array();
        	$task_ids  = implode(',', $task_ids);
            $subtask_ids  = $this->input->post('subtask_ids')!="" ? $this->input->post('subtask_ids') : array();
            $subtask_ids  = implode(',', $subtask_ids);
            $proj_task_ids  = $this->input->post('proj_task_ids')!="" ? $this->input->post('proj_task_ids') : array();
            $proj_task_ids  = implode(',', $proj_task_ids);
        	$pfrd_date  = $this->input->post('pfrd_date');
        	$est_time = $this->input->post('est_time');
            $must_done = $this->input->post('must_done')!="" ? 1 : 0;
            $all_day = $this->input->post('all_day')!="" ? 1 : 0;
            $instrctns = $this->input->post('instructions');
            $data      = array('company_id'=>$company,'contact_id'=>$contact,'project_id'=>$project,'task_ids'=>$task_ids,'subtask_ids'=>$subtask_ids,'project_task_ids'=>$proj_task_ids,'pfrd_date'=>$pfrd_date,'est_time'=>$est_time,'must_done'=>$must_done,'all_day'=>$all_day,'instructions'=>$instrctns,'created_by'=>$this->vendorId,'created_at'=>date('Y-m-d H:i:s'));
			
            $this->load->model('bookings');
			
            $result = $this->bookings->addNewBooking($data);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'New Booking created successfully');
				redirect('booking');
            }
            else
            {
                $this->session->set_flashdata('error', 'Booking creation failed');
				redirect('booking/add');
            }
        }
	}

	public function edit($bookingId = NULL)
	{
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			if($bookingId == null)
            {
                redirect('booking');
            }
            $this->load->model('bookings');
            $this->load->model('companies');
            $this->load->model('clients');
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $bookingData = $this->bookings->getBookingByID(convert_uudecode(base64_decode($bookingId)));
            $companyID = $bookingData[0]->company_id;
            $project_id = $bookingData[0]->project_id;
            $projquery = $this->db->query("SELECT task_ids FROM projects WHERE id=$project_id and isDeleted=0");
            $projdata = $projquery->result_array();
            $task_ids = $projdata[0]['task_ids'];
            $task_ids = explode(',', $task_ids);
            $data['contacts'] = $this->clients->getClientsByCompany($companyID);
            $data['projects'] = json_decode($this->project_type->getProjectsByClientInData($companyID));
            $data['companies'] = $this->companies->getAllCompanies();
            $taskArData = array();
            foreach($task_ids as $task_id){
		 		$taskquery = $this->db->query("SELECT id,title,abbr FROM tasks WHERE id=$task_id and is_deleted=0");
		 		$taskdata = $taskquery->result_array();
		 		array_push($taskArData, $taskdata[0]);
		 	}
            $data['project_tasks'] = $this->project_type->getProjectTasksByProjectId($project_id);
            $data['bookingData'] = $bookingData;
            $data['taskData'] = $taskArData;
			$data['title'] = 'Edit Booking';
			$this->load->view('includes/header',$data);
			$this->load->view('booking/edit_booking');
		}
	}

	public function editAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('bookings');
			
			$booking_id = $this->input->post('booking_id');
            $company    = $this->input->post('company');
            $contact    = $this->input->post('contact')!="" ? $this->input->post('contact') : "";
        	$project    = $this->input->post('project');
        	$task_ids   = $this->input->post('task_ids')!="" ? $this->input->post('task_ids') : array();
        	$task_ids   = implode(',', $task_ids);
            $subtask_ids   = $this->input->post('subtask_ids')!="" ? $this->input->post('subtask_ids') : array();
            $subtask_ids   = implode(',', $subtask_ids);
            $proj_task_ids   = $this->input->post('proj_task_ids')!="" ? $this->input->post('proj_task_ids') : array();
            $proj_task_ids   = implode(',', $proj_task_ids);
        	$pfrd_date   = $this->input->post('pfrd_date');
        	$est_time  = $this->input->post('est_time');
            $must_done = $this->input->post('must_done')!="" ? 1 : 0;
            $all_day = $this->input->post('all_day')!="" ? 1 : 0;
            $instrctns = $this->input->post('instructions');
            $data       = array('company_id'=>$company,'contact_id'=>$contact,'project_id'=>$project,'task_ids'=>$task_ids,'subtask_ids'=>$subtask_ids,'project_task_ids'=>$proj_task_ids,'pfrd_date'=>$pfrd_date,'est_time'=>$est_time,'must_done'=>$must_done,'all_day'=>$all_day,'instructions'=>$instrctns,'updated_by'=>$this->vendorId,'updated_at'=>date('Y-m-d H:i:s'));
            
            
            $result = $this->bookings->editBooking($data, $booking_id);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Booking updated successfully');
				redirect('booking');
            }
            else
            {
                $this->session->set_flashdata('error', 'Booking updation failed');
				 redirect('booking/edit/'.base64_encode(convert_uuencode($booking_id)));
            }
            
           
        }
    }

	public function ajax_getContactsByCompany()
	{
		$company_id = $_POST['company_id'];
		$this->db->select("id,CONCAT(fname,' ',lname) as fullname");
        $this->db->from("clients");
        $this->db->where("company",$company_id);
        $this->db->where("isDeleted",0);
        $query = $this->db->get();
		$contacts = $query->result_array();
		$optionsContacts = '<option>Select Contact</option>';
		foreach($contacts as $contact){
			$optionsContacts .= '<option value="'.$contact['id'].'">'.$contact['fullname'].'</option>';
		}
		$this->db->select("id,project_name");
        $this->db->from("projects");
        $this->db->where("client_id",$company_id);
        $this->db->where("isDeleted",0);
        $query = $this->db->get();
		$projects = $query->result_array();
		$optionsProjects = '<option>Select Project</option>';
		foreach($projects as $project){
			$optionsProjects .= '<option value="'.$project['id'].'">'.$project['project_name'].'</option>';
		}
		$responsedata = array('contacts'=>$optionsContacts,'projects'=>$optionsProjects);
		echo json_encode($responsedata);
		die;
	}
	public function ajax_deleteBooking()
	{
		$this->load->model('bookings');
		$booking_id = $_POST['id'];
		$data = array('isDeleted'=>1,'updated_by'=>$this->vendorId,'updated_at'=>date('Y-m-d H:i:s'));
        $result = $this->bookings->editBooking($data, $booking_id);
        if ($result > 0) {
	       echo(json_encode(array('status'=>TRUE)));
	    }else{
		   echo(json_encode(array('status'=>FALSE))); 
		}
	}
}