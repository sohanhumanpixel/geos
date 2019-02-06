<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * TaskList Controller
 * @purpose: tasklist module integration
 */
Class TaskList extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		//$this->load->library('form_validation');
		// Load session library
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
        	$this->load->model('task_list');
            $this->load->library('pagination');
            $searchText = '';
            $count = $this->task_list->taskCount($searchText);
            $returns = $this->paginationCompress ( "TaskList", $count, 10 );
            $data['tasks'] = $this->task_list->getTasks($searchText, $returns["page"], $returns["segment"]);
			$data['title'] = 'Task List';
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->view('includes/header',$data);
			$this->load->view('tasklist/tasklist');
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
            $this->load->model('project_type');
            $data['projects'] = $this->project_type->getProjectsNames();
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
        	$data['title'] = 'Add New Task';
			$this->load->view('includes/header',$data);
			$this->load->view('tasklist/add_task');
        }
	}

	public function addAction()
	{
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->library('form_validation');
        	$this->form_validation->set_rules('title','Task Title','trim|required|max_length[128]');
            $this->form_validation->set_rules('abbr','Task Abbreviation','trim|required|max_length[128]');
        	if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
            	$title      = $this->input->post('title');
                $abbr      = $this->input->post('abbr');
            	$content    = $this->input->post('content');
                $data       = array('title'=>$title,'abbr'=>$abbr,'content'=>$content,'created_by'=>$this->vendorId,'created_at'=>date('Y-m-d H:i:s'));
				
                $this->load->model('task_list');
				
                $result = $this->task_list->addNewTask($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Task created successfully');
					redirect('TaskList');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Task creation failed');
					redirect('TaskList/add');
                }
            }
        }
	}

	public function edit($taskID = NULL)
	{
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			if($taskID == null)
            {
                redirect('TaskList');
            }
			$this->load->model('task_list');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$task_data = $this->task_list->getTaskById(convert_uudecode(base64_decode($taskID)));
			if(empty($task_data)){
				  redirect('TaskList');
			}
            $this->load->model('project_type');
            $data['projects'] = $this->project_type->getProjectsNames();
			$data['task'] = $task_data;
			$data['title'] = 'Edit Task';
			$this->load->view('includes/header',$data);
			$this->load->view('tasklist/edit_task');
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
			$task_id = $this->input->post('task_id');
            
            $this->form_validation->set_rules('title','Task Title','trim|required|max_length[128]');
            $this->form_validation->set_rules('abbr','Task Abbreviation','trim|required|max_length[128]');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit(base64_encode(convert_uuencode($task_id)));
            }
            else
            {
				$this->load->model('task_list');
				
                $title      = $this->input->post('title');
                $abbr      = $this->input->post('abbr');
                $content    = $this->input->post('content');
                $data       = array('title'=>$title,'abbr'=>$abbr,'content'=>$content,'updated_at'=>date('Y-m-d H:i:s'),'updated_by'=>$this->vendorId);
                
                
                $result = $this->task_list->editTask($data, $task_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Task updated successfully');
					redirect('TaskList');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Task updation failed');
					 redirect('TaskList/edit/'.base64_encode(convert_uuencode($task_id)));
                }
                
               
            }
        }
    }
    public function ajax_deleteTask()
    {
        if($this->isTicketter() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
			$this->load->model('task_list');
            $taskID = $this->input->post('taskID');
            $taskInfo = array('is_deleted'=>1,'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
            $result = $this->task_list->deleteTask($taskID, $taskInfo);
           if ($result > 0) {
			   echo(json_encode(array('status'=>TRUE)));
			   }else{
				   echo(json_encode(array('status'=>FALSE))); 
				}
        }
    }

    public function sub($taskID = null)
    {
    	if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			if($taskID == null)
            {
                redirect('TaskList');
            }
            $this->load->model('users');
            $this->load->model('task_list');
            $this->load->library('pagination');
            $searchText = '';
            $count = $this->task_list->subTaskCount($searchText,convert_uudecode(base64_decode($taskID)));
            $returns = $this->paginationCompress ( "TaskList", $count, 10 );
            $data['subtasks'] = $this->task_list->getSubTasks($searchText,convert_uudecode(base64_decode($taskID)), $returns["page"], $returns["segment"]);
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['title'] = 'Sub Task';
			$data['taskID'] = $taskID;
			$this->load->view('includes/header',$data);
			$this->load->view('tasklist/subtask_list');
        }
    }

    public function addsub($taskID = null)
    {
    	if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
            if($taskID == null)
            {
                redirect('TaskList');
            }
            $this->load->model('users');
            $this->load->model('task_list');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['title'] = ' Add Sub Task';
            $data['taskID'] = $taskID;
			$data['taskName'] = $this->task_list->getTaskName(convert_uudecode(base64_decode($taskID)));
			$this->load->view('includes/header',$data);
			$this->load->view('tasklist/add_subtask');
        }
    }

    public function subAddAction()
	{
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->library('form_validation');
        	$this->form_validation->set_rules('title','Subtask Title','trim|required|max_length[128]');
            $this->form_validation->set_rules('abbr','Subtask Abbreviation','trim|required|max_length[128]');
            $this->form_validation->set_rules('fixed_price','Fixed Price','trim|required');
            $this->form_validation->set_rules('hourly_rate','Hourly rate','trim|required');

        	if($this->form_validation->run() == FALSE)
            {
                $task_id = $this->input->post('task');
                $this->addsub(base64_encode(convert_uuencode($task_id)));
            }
            else
            {
            	$title = $this->input->post('title');
                $abbr = $this->input->post('abbr');
            	$task_id = $this->input->post('task');
            	$content = $this->input->post('content');
                $fixed_price    = $this->input->post('fixed_price');
                $hourly_rate    = $this->input->post('hourly_rate');
                $data = array('task_id'=>$task_id,'title'=>$title,'abbr'=>$abbr,'content'=>$content, 'fixed_price'=>$fixed_price, 'hourly_rate'=>$hourly_rate,'created_by'=>$this->vendorId,'created_at'=>date('Y-m-d H:i:s'));
                $this->load->model('task_list');
				
                $result = $this->task_list->addNewSubTask($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New SubTask created successfully');
					redirect('TaskList/sub/'.base64_encode(convert_uuencode($task_id)).'');
                }
                else
                {
                    $this->session->set_flashdata('error', 'SubTask creation failed');
					redirect('TaskList/addsub/'.base64_encode(convert_uuencode($task_id)).'');
                }
            }
        }
	}
    public function editsub($subTaskID = NULL)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
            if($subTaskID == null)
            {
                redirect('TaskList');
            }
            $this->load->model('task_list');
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
            $task_data = $this->task_list->getSubTaskById(convert_uudecode(base64_decode($subTaskID)));
            if(empty($task_data)){
                  redirect('TaskList');
            }
            $taskID = $this->task_list->getTaskIDBySubTaskID(convert_uudecode(base64_decode($subTaskID)));
            $data['taskName'] = $this->task_list->getTaskName($taskID);
            $data['subtask'] = $task_data;
            $data['title'] = 'Edit Subtask';
            $this->load->view('includes/header',$data);
            $this->load->view('tasklist/edit_subtask');
        }
    }

    public function subEditAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $subtask_id = $this->input->post('subtask_id');
            
            $this->form_validation->set_rules('title','Subtask Title','trim|required|max_length[128]');
            $this->form_validation->set_rules('abbr','Subtask Abbreviation','trim|required|max_length[128]');
            $this->form_validation->set_rules('fixed_price','Fixed Price','trim|required');
            $this->form_validation->set_rules('hourly_rate','Hourly rate','trim|required');
            $this->form_validation->set_rules('task','Task','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editSub(base64_encode(convert_uuencode($subtask_id)));
            }
            else
            {
                $this->load->model('task_list');
                
                $title   = $this->input->post('title');
                $abbr   = $this->input->post('abbr');
                $task_id = $this->input->post('task');
                $content = $this->input->post('content');
                $fixed_price    = $this->input->post('fixed_price');
                $hourly_rate    = $this->input->post('hourly_rate');
                $data    = array('title'=>$title, 'task_id'=>$task_id,'abbr'=>$abbr, 'content'=>$content, 'fixed_price'=>$fixed_price, 'hourly_rate'=>$hourly_rate, 'updated_at'=>date('Y-m-d H:i:s'), 'updated_by'=>$this->vendorId);
                
                $result = $this->task_list->editSubTask($data, $subtask_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'SubTask updated successfully');
                    redirect('TaskList/sub/'.base64_encode(convert_uuencode($task_id)).'');
                }
                else
                {
                    $this->session->set_flashdata('error', 'SubTask updation failed');
                     redirect('TaskList/editsub/'.base64_encode(convert_uuencode($task_id)).'');
                }
                
               
            }
        }
    }

    public function ajax_deleteSubTask()
    {
        if($this->isTicketter() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $this->load->model('task_list');
            $taskID = $this->input->post('taskID');
            $taskInfo = array('is_deleted'=>1,'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
            $result = $this->task_list->deleteSubTask($taskID, $taskInfo);
           if ($result > 0) {
               echo(json_encode(array('status'=>TRUE)));
               }else{
                   echo(json_encode(array('status'=>FALSE))); 
                }
        }
    }
}