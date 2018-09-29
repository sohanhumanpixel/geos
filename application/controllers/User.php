<?php
/**
 * User Controller
 * @purpose: user module integration
 */
Class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
	}
	public function index() {
		$this->load->view('users/login');
		
	}
	
	/*
	 *@method name	: login
	 *@prams		: null
	 */
	 
	public function login(){
		 $this->load->model('users');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		 if ($this->form_validation->run() == FALSE) {
			$this->index();
		}else{
			$data = array(
		'username' => $this->input->post('username'),
		'password' => $this->input->post('password')
		);
		$result = $this->users->login($data);
		if($result == FALSE) {
			$this->session->set_userdata('invalid', 'Invalid email or password');
			$this->index();
		 }else{
			 $session_data = array(
			'user_id'    => $result[0]->id,
			'uname' => $result[0]->username,
			'email' => $result[0]->email,
			'fname' => $result[0]->fname,
			'lname' => $result[0]->lname,
			'role_id' => $result[0]->role_id,
			'isLoggedIn' => TRUE
			);
			// Add user data in session
			$this->session->set_userdata('logged_in', $session_data);
			redirect('dashboard');
		 }
		}
	 }
	 
	 /**
	  *@method		: register
	  *@author		: acutweb
	  *@purpose		: new user registration
	  */
	  
	  public function register(){
		  $this->load->view('users/register');
	  }
	  
	  /**
	  *@method		: register
	  *@author		: acutweb
	  *@purpose		: new user registration
	  */
	  
	  public function forgot_password(){
		  $this->load->view('users/forgot_password');
	  }
	 
	 
}
?>