<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class Announcement extends BaseController {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		//$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		$this->isLoggedIn(); 
        $isLoggedIn = $this->session->userdata ( 'logged_in' );
	}
	public function index() {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
		    $this->load->model('announcements');
            $this->load->library('pagination');
            $searchText = '';
            $count = $this->announcements->AnnouncementCount($searchText);
            $returns = $this->paginationCompress ( "Announcement", $count, 10 );
            $data['announcements'] = $this->announcements->getAnnouncements($searchText, $returns["page"], $returns["segment"]);
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['title'] = 'Announcements';
			$this->load->view('includes/header',$data);
			$this->load->view('admin/announcement');
        }
	}
	public function add(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
    		$data['title'] = "Add New Announcement";
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
    		$this->load->view('includes/header',$data);
    		$this->load->view('admin/add_announcement');
        }
	}
	/**
   * This function is used to add new Announcement
  */
    public function addAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('a_subject','Subject','trim|required');
            $this->form_validation->set_rules('a_message','Message','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $subject = $this->input->post('a_subject');
                $message = htmlentities( $this->input->post('a_message') );
                $view = $this->input->post('a_view');
                $annInfo = array('subject'=>$subject, 'message'=>$message,'view'=>$view,'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('announcements');
                $result = $this->announcements->addAnnouncement($annInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success','Announcement added successfully');
                    redirect('Announcement');
                }
                else
                {
                    $this->session->set_flashdata('error','Announcement adding failed');
                    redirect('Announcement/add');
                }
                
                
            }
        }
    }
    public function editann($id){
    	if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
        	if($id == null)
            {
                redirect('announcement');
            }
	    	$data['title'] = 'Edit Announcement';
	    	$this->load->model('announcements');
	    	$announcement = $this->announcements->getAnnouncementsById(convert_uudecode(base64_decode($id)));
	    	$data['announcement'] = $announcement;
            $this->load->model('users');
            $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	    	$this->load->view('includes/header',$data);
	    	$this->load->view('admin/edit_announcement');
	    }
    }
    public function editAction($id)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('a_subject','Subject','trim|required');
            $this->form_validation->set_rules('a_message','Message','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editann($id);
            }
            else
            {
                $subject = $this->input->post('a_subject');
                $message = htmlentities( $this->input->post('a_message') );
                $view = $this->input->post('a_view');
                $annInfo = array('subject'=>$subject, 'message'=>$message,'view'=>$view,'created_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('announcements');
                $result = $this->announcements->updateAnnouncement($annInfo,convert_uudecode(base64_decode($id)));
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success','Announcement saved successfully');
                    redirect('Announcement');
                }
                else
                {
                    $this->session->set_flashdata('error','Announcement adding failed');
                    redirect('Announcement/edit/<?=$id?>');
                }
                
                
            }
        }
    }
    public function delann($id){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
        	$this->load->model('announcements');
        	$this->announcements->deleteAnnouncement(convert_uudecode(base64_decode($id)));
        	redirect('Announcement');
        }
    }
    public function statusActive($id){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('announcements');
            $this->announcements->activeStatus(convert_uudecode(base64_decode($id)));
            redirect('Announcement');
        }
    }
    public function statusinActive($id){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('announcements');
            $this->announcements->inactiveStatus(convert_uudecode(base64_decode($id)));
            redirect('Announcement');
        }
    }
}
?>