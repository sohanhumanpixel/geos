<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Client Controller
 */
Class Client extends BaseController {
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
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
		    $this->load->model('clients');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $this->load->library('pagination');
            $searchText = '';
            $count = $this->clients->ClientCount($searchText);
            $returns = $this->paginationCompress ( "Client", $count, 10 );
            $data['clients'] = $this->clients->getClients($searchText, $returns["page"], $returns["segment"]);
			$data['title'] = 'Contacts';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/client');
        }
		
	}
	public function add(){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->model('companies');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['companies'] = $this->companies->getAllCompanies();
        	$data['title'] = 'Add New Contact';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/add_client');
        }
	}
	public function addAction(){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','First name','trim|required|max_length[128]');
			$this->form_validation->set_rules('lname','Last name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('phone','Phone','trim|required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('company','Company','trim|required');
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $fname = ucwords(strtolower($this->input->post('fname')));
				$lname = ucwords(strtolower($this->input->post('lname')));
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $notes = $this->input->post('notes');
                $company = $this->input->post('company');
                $clientInfo = array('email'=>$email, 'fname'=> $fname,'lname'=> $lname, 'phone'=>$phone, 'company'=>$company, 'notes'=>$notes, 'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('clients');
                $result = $this->clients->addNewClient($clientInfo);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Client created successfully');
					redirect('Client');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Client creation failed');
					redirect('Client/add');
                }
            }
        }
	}
	public function edit($userId = NULL){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			if($userId == null)
            {
                redirect('client');
            }
			$this->load->model('clients');
			
			$clientdata = $this->clients->getClientById(convert_uudecode(base64_decode($userId)));
			if(empty($clientdata)){
				  redirect('client');
			}
            $this->load->model('companies');
            $data['companies'] = $this->companies->getAllCompanies();
			$data['clientInfo'] = $clientdata;
			$data['title'] = 'Edit Contact';
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->view('includes/header',$data);
			$this->load->view('admin/edit_client');
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
			
            $this->load->library('form_validation');
            
            $clientId = $this->input->post('clientId');
            
            $this->form_validation->set_rules('fname','First name','trim|required|max_length[128]');
			$this->form_validation->set_rules('lname','Last name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('phone','Phone','required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('company','Company','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit(base64_encode(convert_uuencode($clientId)));
            }
            else
            {
				$this->load->model('clients');
				
                $fname = ucwords(strtolower($this->input->post('fname')));
				$lname = ucwords(strtolower($this->input->post('lname')));
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $notes = $this->input->post('notes');
                $company = $this->input->post('company');
                $clientInfo = array('email'=>$email,
                        'fname'=> $fname,'lname'=> $lname,'phone'=>$phone,'company'=>$company,'notes'=>$notes, 'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
                
                
                $result = $this->clients->editClient($clientInfo, $clientId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Client updated successfully');
					redirect('client');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Client updation failed');
					 redirect('client');
                }
                
               
            }
        }
    }

	public function ajax_checkEmailExists(){
		$clientId = $this->input->post("clientId");
       $email = $this->input->post("email");
		$this->load->model('clients');
        if(empty($clientId)){
            $result = $this->clients->checkEmailExists($email);
        } else {
            $result = $this->clients->checkEmailExists($email, $clientId);
        }
        if(empty($result)){
			echo("true"); 
			}
        else { echo("false"); }
 }
 public function ajax_deleteClient()
    {
        if($this->isTicketter() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
			$this->load->model('clients');
            $clientId = $this->input->post('clientId');
            $clientInfo = array('isDeleted'=>1,'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
            $result = $this->clients->deleteClient($clientId, $clientInfo);
           if ($result > 0) {
			   echo(json_encode(array('status'=>TRUE)));
			   }else{
				   echo(json_encode(array('status'=>FALSE))); 
				}
        }
    }
    public function Detail($clientId){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
            
        }else{
            if($clientId == null)
            {
                redirect('Client');
            }
            $this->load->model('clients');
            $this->load->model('users');
            $data['title'] = 'Client Details';
            
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $cleintData = $this->clients->getClientById($clientId);
            $data['clientInfo'] = $cleintData;
            $this->load->view('includes/header',$data);
            $this->load->view('admin/client_details');
        }
    }
}