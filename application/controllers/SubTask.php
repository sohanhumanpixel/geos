<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Subtask Controller
 * @purpose: subtask module integration
 */
Class SubTask extends BaseController
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

	public function index($taskID = NULL)
	{
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	if($taskID == null)
            {
                redirect('TaskList');
            }
        	//$this->load->model('task_list');
           // $this->load->library('pagination');
            //$searchText = '';
            //$count = $this->task_list->taskCount($searchText);
            //$returns = $this->paginationCompress ( "TaskList", $count, 10 );
            //$data['tasks'] = $this->task_list->getTasks($searchText, $returns["page"], $returns["segment"]);
			$data['title'] = 'Sub Task List';
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->view('includes/header',$data);
			$this->load->view('subtask/subtask');
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
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
        	$data['title'] = 'Add New Subtask';
			$this->load->view('includes/header',$data);
			$this->load->view('subtask/add_subtask');
        }
	}
}