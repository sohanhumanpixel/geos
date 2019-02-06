<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * TaskList Controller
 * @purpose: tasklist module integration
 */
Class Test extends BaseController
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
		$this->load->library('Phpword');
		$template = FCPATH.'assets/templates/subby_template.docx';
		$phpWord = new \PhpOffice\PhpWord\TemplateProcessor($template);
		$phpWord->setValue('placeholder','Santosh');

		$phpWord->saveAs(FCPATH.'assets/templates/new.docx');
		die('ppp');
	}
}