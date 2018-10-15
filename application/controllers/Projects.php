<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class Projects extends BaseController {
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
	
	/**
	 *@purpose: All Project List
	 *@Author: Humen Pixel
	 */
	 
	public function index() {
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->model('project_type');
            $this->load->library('pagination');
            $searchText = '';
            $count = $this->project_type->projectCount($searchText);
            $returns = $this->paginationCompress ( "Projects", $count, 10 );
            $data['projects'] = $this->project_type->getProjects($searchText, $returns["page"], $returns["segment"]);
			$data['title'] = 'Projects';
			$this->load->view('includes/header',$data);
			$this->load->view('projects/projects');
        }
	}
    public function add(){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->model('project_type');
        	$this->load->model('clients');
        	$data['project_types'] = $this->project_type->getPList();
        	$data['clients'] = $this->clients->getAllClients();
        	//$data['inductions'] = $this->project_type->getInductions();
        	$data['title'] = 'Add New Project';
			$this->load->view('includes/header',$data);
			$this->load->view('projects/add_project');
        }
	}
	public function addAction(){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->library('form_validation');
        	$this->form_validation->set_rules('project_name','Project Name','trim|required|max_length[128]');
        	$this->form_validation->set_rules('client_name','Client Name','required');
        	$this->form_validation->set_rules('site_address','Project Site Address','trim|required');
			if($this->input->post('is_induction')){
				$this->form_validation->set_rules('induction_url','Induction URL','trim|required');
			}
        	$this->form_validation->set_rules('project_type[]','Project Type','trim|required');
        	if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
            	$project_name = $this->input->post('project_name');
                $client_id = $this->input->post('client_name');
                $site_address = $this->input->post('site_address');
                $induction_instruction = $this->input->post('induction_instruction');
                $project_type = implode(',', $this->input->post('project_type'));
                $project_code = mt_rand(100000, 999999);
				$is_induction = (isset($_POST['is_induction'])) ? $this->input->post('is_induction') : 0;
                //$induction = implode(',', $this->input->post('induction'));
				$induction = $this->input->post('induction_url');
                $data = array('project_name'=>$project_name,'client_id'=>$client_id,'project_type'=>$project_type,'is_induction'=>$is_induction,'induction_url'=>$induction, 'instructions'=>$induction_instruction,'project_manager_id'=>$this->vendorId,'project_code'=>$project_code,'project_address'=>$site_address,'created_date'=>date('Y-m-d H:i:s'));
				
                $this->load->model('project_type');
				
                $result = $this->project_type->addNewProject($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Project created successfully');
					redirect('projects');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Project creation failed');
					redirect('projects/add');
                }
            }
        }
	}
	public function edit($projectId = NULL){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			if($projectId == null)
            {
                redirect('projects');
            }
			$this->load->model('project_type');
			$this->load->model('clients');
			$data['project_types'] = $this->project_type->getPList();
        	$data['clients'] = $this->clients->getAllClients();
        	//$data['inductions'] = $this->project_type->getInductions();
			$project_data = $this->project_type->getProjectById(convert_uudecode(base64_decode($projectId)));
			if(empty($project_data)){
				  redirect('projects');
			}
			$data['projectInfo'] = $project_data;
			$data['title'] = 'Edit Project';
			$this->load->view('includes/header',$data);
			$this->load->view('projects/edit_project');
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
			$project_id = $this->input->post('project_id');
            
            $this->form_validation->set_rules('project_name','Project Name','trim|required|max_length[128]');
        	$this->form_validation->set_rules('client_name','Client Name','required');
        	$this->form_validation->set_rules('site_address','Project Site Address','trim|required');
			
			if($this->input->post('is_induction')){
				$this->form_validation->set_rules('induction_url','Induction URL','trim|required');
			}
			
        	$this->form_validation->set_rules('project_type[]','Project Type','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->edit(base64_encode(convert_uuencode($project_id)));
            }
            else
            {
				$this->load->model('project_type');
				
                $project_name = $this->input->post('project_name');
                $client_id = $this->input->post('client_name');
                $site_address = $this->input->post('site_address');
                $induction_instruction = $this->input->post('induction_instruction');
                $project_type = implode(',', $this->input->post('project_type'));
                //$induction = implode(',', $this->input->post('induction'));
				
				$is_induction = (isset($_POST['is_induction'])) ? $this->input->post('is_induction') : 0;
				$induction = $this->input->post('induction_url');
                $data = array('project_name'=>$project_name,'client_id'=>$client_id,'project_type'=>$project_type,'is_induction'=>$is_induction,'induction_url'=>$induction,'instructions'=>$induction_instruction,'project_address'=>$site_address,'updated_at'=>date('Y-m-d H:i:s'),'updated_by'=>$this->vendorId);
                
                
                $result = $this->project_type->editProject($data, $project_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Project updated successfully');
					redirect('Projects');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Project updation failed');
					 redirect('Projects/edit/'.base64_encode(convert_uuencode($project_id)));
                }
                
               
            }
        }
    }
    public function ajax_deleteProject()
    {
        if($this->isTicketter() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
			$this->load->model('project_type');
            $projectId = $this->input->post('projectId');
            $projectInfo = array('isDeleted'=>1,'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
            $result = $this->project_type->deleteProject($projectId, $projectInfo);
           if ($result > 0) {
			   echo(json_encode(array('status'=>TRUE)));
			   }else{
				   echo(json_encode(array('status'=>FALSE))); 
				}
        }
    }
}
?>