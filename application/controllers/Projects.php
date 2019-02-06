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
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
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
        	$this->load->model('companies');
            $this->load->model('task_list');
        	$data['project_types'] = $this->project_type->getPList();
        	$data['companies'] = $this->companies->getAllCompanies();
            $data['tasks'] = $this->task_list->getAllTasks();
            $data['categories'] = $this->project_type->getAllCategories();
            $data['states'] = $this->project_type->getAllStates();
        	//$data['inductions'] = $this->project_type->getInductions();
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
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
            $this->form_validation->set_rules('task[]','Tasks','trim|required');
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
                $task_ids = implode(',', $this->input->post('task'));
                $category_id = $this->input->post('categories');
                $state_id = $this->input->post('states');
                $project_code = mt_rand(100000, 999999);
				$is_induction = (isset($_POST['is_induction'])) ? $this->input->post('is_induction') : 0;
                //$induction = implode(',', $this->input->post('induction'));
				$induction = $this->input->post('induction_url');
                $data = array('project_name'=>$project_name,'client_id'=>$client_id,'project_type'=>$project_type,'task_ids'=>$task_ids,'category_id'=>$category_id,'state_id'=>$state_id,'is_induction'=>$is_induction,'induction_url'=>$induction, 'instructions'=>$induction_instruction,'project_manager_id'=>$this->vendorId,'project_code'=>$project_code,'project_address'=>$site_address,'created_date'=>date('Y-m-d H:i:s'));
				
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
			$this->load->model('companies');
            $this->load->model('task_list');
			$data['project_types'] = $this->project_type->getPList();
        	$data['companies'] = $this->companies->getAllCompanies();
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
        	//$data['inductions'] = $this->project_type->getInductions();
            $data['categories'] = $this->project_type->getAllCategories();
            $data['states'] = $this->project_type->getAllStates();
			$project_data = $this->project_type->getProjectById(convert_uudecode(base64_decode($projectId)));
            $data['tasks'] = $this->task_list->getAllTasks();
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
            $this->form_validation->set_rules('task[]','Tasks','trim|required');
            
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
                $task_ids = implode(',', $this->input->post('task'));
                //$induction = implode(',', $this->input->post('induction'));
				$category_id = $this->input->post('categories');
                $state_id = $this->input->post('states');
				$is_induction = (isset($_POST['is_induction'])) ? $this->input->post('is_induction') : 0;
				$induction = $this->input->post('induction_url');
                $data = array('project_name'=>$project_name,'client_id'=>$client_id,'project_type'=>$project_type,'task_ids'=>$task_ids,'category_id'=>$category_id,'state_id'=>$state_id,'is_induction'=>$is_induction,'induction_url'=>$induction,'instructions'=>$induction_instruction,'project_address'=>$site_address,'updated_at'=>date('Y-m-d H:i:s'),'updated_by'=>$this->vendorId);
                
                
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
    public function History($projectId){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis(); 
        }else{
            if($projectId == null)
            {
                redirect('Projects');
            }
            $this->load->model('project_type');
            $this->load->model('users');
            $data['title'] = 'Project History';
            $data['projectHistory'] = $this->project_type->getCompletedTaskPerProject($projectId);
            $data['incompProjects'] = $this->project_type->getIncompletedTaskPerProject($projectId);
            $data['compProjTasks'] = $this->project_type->getCompletedProjectTask($projectId);
            $data['incompProjTasks'] = $this->project_type->getIncompletedProjectTask($projectId);
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $projectdata = $this->project_type->getProjectById($projectId);
            $data['projectInfo'] = $projectdata;
            $data['backUrl'] = base_url('Projects');
            $data['adminAccess'] = 'true';
            $data['project_id'] = $projectId;
            //$data['employees']= $this->users->getAllEmployee();
            $data['tasks'] =$this->project_type->getTasksProject($projectId);
            $this->load->view('includes/header',$data);
            $this->load->view('projects/project_history');
        }
    }

    public function projectTypes()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['title'] = 'Project Types';
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $searchText = '';
            $count = $this->project_type->projectTypeCount($searchText);
            $returns = $this->paginationCompress ( "Projects/projectTypes", $count, 10 );
            $data['project_types'] = $this->project_type->getProjectTypes($searchText, $returns["page"], $returns["segment"]);
            $this->load->view('includes/header',$data);
            $this->load->view('projects/project_types');
        }
    }

    public function addProjectType(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['title'] = 'Add Project Type';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/add_project_type');
        }
    }

    public function addProjectTypeAction(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('project_type_name','Project Type Name','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {
                $this->addProjectType();
            }
            else
            {
                $project_type_name = $this->input->post('project_type_name');
                $data = array('project_type_name'=>$project_type_name,'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('project_type');
                
                $result = $this->project_type->addNewProjectType($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Project Type created successfully');
                    redirect('projects/projectTypes');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Project Type creation failed');
                    redirect('projects/addProjectType');
                }
            }
        }
    }

    public function editProjectType($projTid = NULL){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
            if($projTid == null)
            {
                redirect('projects/projectTypes');
            }
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $projTypedata = $this->project_type->getProjectTypeById($projTid);
            if(empty($projTypedata)){
                  redirect('projects/projectTypes');
            }
            $data['projTinfo'] = $projTypedata;
            $data['title'] = 'Edit Project Type';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/edit_project_type');
        }
    }

    public function editProjectTypeAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $project_type_id = $this->input->post('project_type_id');
            
            $this->form_validation->set_rules('project_type_name','Project Type Name','trim|required|max_length[128]');;
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editProjectType($project_type_id);
            }
            else
            {
                $this->load->model('project_type');
                
                $project_type_name = $this->input->post('project_type_name');
                $data = array('project_type_name'=>$project_type_name);
                
                
                $result = $this->project_type->editProjectType($data, $project_type_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Project Type updated successfully');
                    redirect('Projects/projectTypes');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Project Type updation failed');
                     redirect('Projects/editProjectType/'.$project_type_id);
                }
                
               
            }
        }
    }

    public function deleteProjectType($projTid)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->project_type->deleteProjectType($projTid);
            $this->session->set_flashdata('success', 'Project Type successfully deleted');
            redirect('projects/projectTypes');
        }
    }

    public function categories()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['title'] = 'Categories';
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $searchText = '';
            $count = $this->project_type->categoryCount($searchText);
            $returns = $this->paginationCompress ( "Projects/categories", $count, 10 );
            $data['categories'] = $this->project_type->getCategories($searchText, $returns["page"], $returns["segment"]);
            $this->load->view('includes/header',$data);
            $this->load->view('projects/categories');
        }
    }

    public function addCategory(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['title'] = 'Add New Category';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/add_category');
        }
    }

    public function addCatAction(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_name','Category Name','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {
                $this->addCategory();
            }
            else
            {
                $category_name = $this->input->post('category_name');
                $data = array('category_name'=>$category_name,'created_by'=>$this->vendorId,'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('project_type');
                
                $result = $this->project_type->addNewCategory($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Category created successfully');
                    redirect('projects/categories');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Category creation failed');
                    redirect('projects/addCategory');
                }
            }
        }
    }

    public function editCategory($categoryId = NULL){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
            if($categoryId == null)
            {
                redirect('projects/catgeories');
            }
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $catgeory_data = $this->project_type->getCategoryById($categoryId);
            if(empty($catgeory_data)){
                  redirect('projects/catgeories');
            }
            $data['categoryInfo'] = $catgeory_data;
            $data['title'] = 'Edit Category';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/edit_category');
        }
    }

    public function editCatAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $category_id = $this->input->post('category_id');
            
            $this->form_validation->set_rules('category_name','Category Name','trim|required|max_length[128]');;
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editCategory($category_id);
            }
            else
            {
                $this->load->model('project_type');
                
                $category_name = $this->input->post('category_name');
                $data = array('category_name'=>$category_name);
                
                
                $result = $this->project_type->editCategory($data, $category_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Category updated successfully');
                    redirect('Projects/categories');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Category updation failed');
                     redirect('Projects/editCategory/'.$category_id);
                }
                
               
            }
        }
    }

    public function deleteCategory($categoryId)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->project_type->deleteCategory($categoryId);
            $this->session->set_flashdata('success', 'Category successfully deleted');
            redirect('projects/categories');
        }
    }

    public function states()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['title'] = 'States';
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $searchText = '';
            $count = $this->project_type->stateCount($searchText);
            $returns = $this->paginationCompress ( "Projects/states", $count, 10 );
            $data['states'] = $this->project_type->getStates($searchText, $returns["page"], $returns["segment"]);
            $this->load->view('includes/header',$data);
            $this->load->view('projects/states');
        }
    }

    public function addState(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['title'] = 'Add New State';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/add_state');
        }
    }

    public function addStateAction(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('state_name','State','trim|required');
            $this->form_validation->set_rules('state_rate','State rate','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $this->addState();
            }
            else
            {
                $state_name = $this->input->post('state_name');
                $state_rate = $this->input->post('state_rate');
                $data = array('state_name'=>$state_name,'state_rate'=>$state_rate,'created_by'=>$this->vendorId,'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('project_type');
                
                $result = $this->project_type->addNewState($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New State created successfully');
                    redirect('projects/states');
                }
                else
                {
                    $this->session->set_flashdata('error', 'State creation failed');
                    redirect('projects/addState');
                }
            }
        }
    }

    public function editState($stateId = NULL){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
            if($stateId == null)
            {
                redirect('projects/states');
            }
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $state_date = $this->project_type->getStateById($stateId);
            if(empty($state_date)){
                  redirect('projects/states');
            }
            $data['stateInfo'] = $state_date;
            $data['title'] = 'Edit State';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/edit_state');
        }
    }

    public function editStateAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $state_id = $this->input->post('state_id');
            
            $this->form_validation->set_rules('state_name','State','trim|required');
            $this->form_validation->set_rules('state_rate','State rate','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editState($state_id);
            }
            else
            {
                $this->load->model('project_type');
                
                $state_name = $this->input->post('state_name');
                $state_rate = $this->input->post('state_rate');
                $data = array('state_name'=>$state_name,'state_rate'=>$state_rate);
                
                
                $result = $this->project_type->editState($data, $state_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'State updated successfully');
                    redirect('Projects/states');
                }
                else
                {
                    $this->session->set_flashdata('error', 'State updation failed');
                     redirect('Projects/editState/'.$state_id);
                }
                
               
            }
        }
    }

    public function deleteState($stateId)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->project_type->deleteState($stateId);
            $this->session->set_flashdata('success', 'State successfully deleted');
            redirect('projects/states');
        }
    }

    public function jobBriefs()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['title'] = 'Job Brief Template';
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $searchText = '';
            $count = $this->project_type->jobTempCount($searchText);
            $returns = $this->paginationCompress ( "Projects/jobBriefs", $count, 10 );
            $data['jobBriefs'] = $this->project_type->getJobTempBriefs($searchText, $returns["page"], $returns["segment"]);
            $this->load->view('includes/header',$data);
            $this->load->view('projects/job_templates');
        }
    }

    public function addJobBriefTemp(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['categories'] = $this->project_type->getAllCategories();
            $data['title'] = 'Add Job Brief Template';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/add_job_template');
        }
    }

    public function addJobBriefTempAction(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('template_name','Template Name','trim|required');
            $this->form_validation->set_rules('categories','Category','required');
            if (empty($_FILES['template_file']['name']))
            {
                $this->form_validation->set_rules('template_file', 'Template File', 'required');
            }

            if($this->form_validation->run() == FALSE)
            {
                $this->addJobBriefTemp();
            }
            else
            {
                $template_name = $this->input->post('template_name');
                $description = $this->input->post('description');
                $category_id = $this->input->post('categories');
                $upload_path = "assets/templates/";
                $template_file = ""; 
                $filename = "";
                if($_FILES['template_file']['name']!=''){
                    $imagetype = $_FILES['template_file']['type'];
                    $filename = $_FILES['template_file']['name'];
                    $tempname = $_FILES["template_file"]["tmp_name"];
                    $t = preg_replace('/\s+/', '', time());
                    $fileName = $t . ''.str_replace(' ','',$filename);
                    $moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
                    if( $moved ) {
                        $template_file = $fileName; 
                    } else {
                        $this->session->set_flashdata('error',"Not uploaded because of error #".$_FILES["template_file"]["error"]);
                        redirect('Projects/addJobBriefTemp');
                    }
                }
                $data = array('template_name'=>$template_name,'description'=>$description,'template_file'=>$template_file,'template_real'=>$filename,'category_id'=>$category_id,'created_by'=>$this->vendorId,'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('project_type');
                
                $result = $this->project_type->addNewJobTemplate($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Job Template created successfully');
                    redirect('Projects/jobBriefs');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Job Template creation failed');
                    redirect('Projects/addJobBriefTemp');
                }
            }
        }
    }

    public function editJobBriefTemp($tempId = NULL){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
            if($tempId == null)
            {
                redirect('projects/jobBriefs');
            }
            $this->load->model('project_type');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['categories'] = $this->project_type->getAllCategories();
            $template_data = $this->project_type->getJobTemplateById($tempId);
            if(empty($template_data)){
                  redirect('projects/jobBriefs');
            }
            $data['tempInfo'] = $template_data;
            $data['title'] = 'Edit Job Template';
            $this->load->view('includes/header',$data);
            $this->load->view('projects/edit_job_template');
        }
    }

    public function editJobBriefTempAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $template_id = $this->input->post('template_id');

            $this->form_validation->set_rules('template_name','Template Name','trim|required');
            $this->form_validation->set_rules('categories','Category','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editJobBriefTemp($template_id);
            }
            else
            {
                $this->load->model('project_type');
                
                $template_name = $this->input->post('template_name');
                $description = $this->input->post('description');
                $category_id = $this->input->post('categories');
                $upload_path = "assets/templates/";
                $template_file = ""; 
                $filename = '';
                $data = array('template_name'=>$template_name,'description'=>$description,'category_id'=>$category_id);
                if($_FILES['template_file']['name']!=''){
                    $imagetype = $_FILES['template_file']['type'];
                    $filename = $_FILES['template_file']['name'];
                    $tempname = $_FILES["template_file"]["tmp_name"];
                    $t = preg_replace('/\s+/', '', time());
                    $fileName = $t . ''.str_replace(' ','',$filename);
                    $moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
                    if( $moved ) {
                        $template_file = $fileName; 
                        $data = array('template_name'=>$template_name,'template_file'=>$template_file,'template_real'=>$filename,'description'=>$description,'category_id'=>$category_id);
                    } else {
                        $this->session->set_flashdata('error',"Not uploaded because of error #".$_FILES["template_file"]["error"]);
                        redirect('Projects/addJobBriefTemp');
                    }
                }

                $result = $this->project_type->editJobTemplate($data, $template_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Job Template updated successfully');
                    redirect('Projects/jobBriefs');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Job Template updation failed');
                     redirect('Projects/editJobBriefTemp/'.$template_id);
                }
                
               
            }
        }
    }

    public function deleteJobTemp($tempId)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('project_type');
            $this->project_type->deleteJobTemplate($tempId);
            $this->session->set_flashdata('success', 'Job Template successfully deleted');
            redirect('Projects/jobBriefs');
        }
    }

    public function selectTemplate($projectId)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($projectId == null)
            {
                redirect('Projects');
            }
            $this->load->model('project_type');
            $this->load->model('users');
            $data['title'] = 'Select Template';
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $data['jobBriefs'] = $this->project_type->getAllJobTemplates();
            $data['project_id'] = $projectId;
            $this->load->view('includes/header',$data);
            $this->load->view('projects/select_template');
        }
    }

    public function generateJobBrief()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $project_id = $this->input->post('project_id');

            $this->form_validation->set_rules('template','Choose Template','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->selectTemplate($project_id);
            }
            else
            {
                $this->load->library('Phpword');
                $this->load->model('project_type');
                $template_id = $this->input->post('template');
                $vendorId = $this->vendorId;
                $templateS = $this->project_type->getJobTemplateById($template_id);
                $projectS = $this->project_type->getProjectById($project_id);
                $template_file = $templateS[0]->template_file;
                $project_name = $projectS[0]->project_name;
                $path = FCPATH.'assets/templates/';
                $subby_path = FCPATH.'assets/subby_templates/';
                $template = $path.$template_file;
                $phpWord = new \PhpOffice\PhpWord\TemplateProcessor($template);
                $phpWord->setValue('ClientName',$this->name);
                $phpWord->setValue('ProjectName',$project_name);
                $stripped = preg_replace('/\s/', '', $project_name);
                $newFile = $stripped.$vendorId.$templateS[0]->template_real;

                $phpWord->saveAs(FCPATH.'assets/subby_templates/'.$newFile);
                $data = array('template_name'=>$newFile,'project_id'=>$project_id,'generated_by'=>$vendorId,'generated_at'=>date("Y-m-d H:i:s"));
                $checkQ = $this->db->query("SELECT * FROM subby_templates WHERE project_id=$project_id AND generated_by=$vendorId");
                $check = $checkQ->result();
                if(empty($check))
                    $this->project_type->insertSubbyPack($data);
                
                redirect('Projects/printTemplate/'.$project_id);
            }
        }
    }

    public function printTemplate($project_id=NULL)
    {
        if($project_id==NULL)
            redirect('Projects');
        $vendorId = $this->vendorId;
        $templateQ = $this->db->query("SELECT * FROM subby_templates WHERE project_id=$project_id AND generated_by=$vendorId");
        $templateR = $templateQ->result();
        if(empty($templateR))
            redirect('Projects');
        $data['template'] = $templateR[0]->template_name;
        $this->load->model('users');
        $data['title'] = 'Print Job Brief';
        $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
        $this->load->view('includes/header',$data);
        $this->load->view('projects/print_template');
    }

    public function addTasksAjax()
    {
        $this->load->model('project_type');
        $this->load->model('users');
        $project_id    = $this->input->post('project_id');
        $task_title    = $this->input->post('task_title');
        $task_content  = $this->input->post('task_content');
        $data          = array(
                            'project_id'        => $project_id,
                            'title'             => $task_title,
                            'description'       => $task_content,
                            'created_by'        => $this->vendorId,
                            'created_at'        => date('Y-m-d H:i:s')
                        );
        $result       = $this->project_type->addTasksProject($data);
        $i            = $this->vendorId;
        $q            = $this->db->query("SELECT fname,lname FROM users WHERE id=$i");
        $r            = $q->result();
        $name         = $r[0]->fname.' '.$r[0]->lname;
        $date         = date('D, d M Y H:i');
        $employees    = $this->users->getAllEmployee();
        $optionHtm    = '';
        if($result > 0)
        {
            $responsedata = array('status'=>'success','msg'=>'New Task added successfully','task_title'=>$task_title,'task_content'=>$task_content,'created_by'=>$name,'empHtml'=>$optionHtm,'date'=>$date,'task_id'=>$result);
            echo json_encode($responsedata);
            die;
        }
        else
        {
            $responsedata = array('status'=>'error','msg'=>'New Task creation failed!');
            echo json_encode($responsedata);
            die;
        }
    }
    public function deleteTasksAjax()
    {
        $this->load->model('project_type');
        $task_id = $_POST['task_id'];
        $result  = $this->project_type->deleteTasksProject($task_id);
        if($result == true)
        {
            $responsedata = array('status'=>'success','msg'=>'Task deleted successfully');
            echo json_encode($responsedata);
            die;
        }
        else
        {
            $responsedata = array('status'=>'error','msg'=>'Task deletion failed!');
            echo json_encode($responsedata);
            die;
        }
    }
    public function saveTasksAjax()
    {
        $this->load->model('project_type');
        $task_id      = $this->input->post('edittask_id');
        $task_title   = $this->input->post('edittask_title');
        $task_content = $this->input->post('edittask_content');
        $data         = array(
                            'title'             => $task_title,
                            'description'       => $task_content,
                        );
        $result       = $this->project_type->saveTasksProject($data,$task_id);
        $i            = $this->vendorId;
        $q            = $this->db->query("SELECT fname,lname FROM users WHERE id=$i");
        $r            = $q->result();
        $name         = $r[0]->fname.' '.$r[0]->lname;
        $date         = date('D, d M Y H:i');
        if($result == true)
        {
            $responsedata = array('status'=>'success','msg'=>'Note updated successfully','task_title'=>$task_title,'task_content'=>$task_content,'created_by'=>$name,'date'=>$date);
            echo json_encode($responsedata);
            die;
        }
        else
        {
            $responsedata = array('status'=>'error','msg'=>'Note updation failed!');
            echo json_encode($responsedata);
            die;
        }

    }
    public function ajax_getCommentsByTask()
    {
        $emp_tId = $_POST['emp_tId'];
        $this->db->select("ct.*,u.fname,u.lname");
        $this->db->from('comments_tasks as ct');
        $this->db->join('users as u','u.id=ct.commented_by','left');
        $this->db->where('emp_task_id',$emp_tId);
        $this->db->order_by("ct.id", "desc");
        $query = $this->db->get();
        $comments = $query->result();
        $html = '<h4>Comments</h4>';
        if(!empty($comments)){
            foreach($comments as $comment){ 
                $html .= '<div class="comment-view col-md-12"><p><strong>'.$comment->fname.' '.$comment->lname.'</strong><span class="pull-right"><i class="fa fa-clock-o"></i>'.date('d-m-Y H:i',strtotime($comment->commented_at)).'</span></p><p>'.$comment->comment.'</p></div>';
            }
        }else{
            $html .= '<div class="comment-view col-md-12">No comments</div>';
        }
        $responsedata = array('status'=>'success','msg'=>$html);
        echo json_encode($responsedata);
        die;
    }
    public function ajax_getPhotosByTask()
    {
        $emp_tId = $_POST['emp_tId'];
        $this->db->select("pt.*,u.fname,u.lname");
        $this->db->from('photos_tasks as pt');
        $this->db->join('users as u','u.id=pt.uploaded_by','left');
        $this->db->where('emp_task_id',$emp_tId);
        $this->db->order_by("pt.id", "asc");
        $query = $this->db->get();
        $photos = $query->result();
        $html = '<h4>Photos</h4><div class="photo-view col-md-12">';
        if(!empty($photos)){
            foreach($photos as $photo){ 
                $html .= '<img src="'.base_url().'assets/images/tasks/'.$photo->photo.'" class="pic_t">';
            }
        }else{
            $html .= 'No photos';
        }
        $html .= "</div>";
        $responsedata = array('status'=>'success','msg'=>$html);
        echo json_encode($responsedata);
        die;
    }
    public function ajax_getProjCommentsByTask()
    {
        $emp_tId = $_POST['emp_tId'];
        $this->db->select("ct.*,u.fname,u.lname");
        $this->db->from('comments_project_tasks as ct');
        $this->db->join('users as u','u.id=ct.commented_by','left');
        $this->db->where('emp_task_id',$emp_tId);
        $this->db->order_by("ct.id", "desc");
        $query = $this->db->get();
        $comments = $query->result();
        $html = '<h4>Comments</h4>';
        if(!empty($comments)){
            foreach($comments as $comment){ 
                $html .= '<div class="comment-view col-md-12"><p><strong>'.$comment->fname.' '.$comment->lname.'</strong><span class="pull-right"><i class="fa fa-clock-o"></i>'.date('d-m-Y H:i',strtotime($comment->commented_at)).'</span></p><p>'.$comment->comment.'</p></div>';
            }
        }else{
            $html .= '<div class="comment-view col-md-12">No comments</div>';
        }
        $responsedata = array('status'=>'success','msg'=>$html);
        echo json_encode($responsedata);
        die;
    }
    public function ajax_getProjPhotosByTask()
    {
        $emp_tId = $_POST['emp_tId'];
        $this->db->select("pt.*,u.fname,u.lname");
        $this->db->from('photos_project_tasks as pt');
        $this->db->join('users as u','u.id=pt.uploaded_by','left');
        $this->db->where('emp_task_id',$emp_tId);
        $this->db->order_by("pt.id", "asc");
        $query = $this->db->get();
        $photos = $query->result();
        $html = '<h4>Photos</h4><div class="photo-view col-md-12">';
        if(!empty($photos)){
            foreach($photos as $photo){ 
                $html .= '<img src="'.base_url().'assets/images/tasks/'.$photo->photo.'" class="pic_t">';
            }
        }else{
            $html .= 'No photos';
        }
        $html .= "</div>";
        $responsedata = array('status'=>'success','msg'=>$html);
        echo json_encode($responsedata);
        die;
    }
}
?>