<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Company Controller
 */
Class Company extends BaseController {
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
		    $this->load->model('companies');
            $this->load->library('pagination');
            $searchText = '';
            if(isset($_GET['sort']) && $_GET['sort']=='asc'){
                $data['toSort'] = 'desc';
            }else{
                $data['toSort'] = 'asc';
            }
            if(isset($_GET['search']) && $_GET['search']!=''){
                $data['toSearch'] = $_GET['search'];
            }else{
                $data['toSearch'] = '';
            }
            $count = $this->companies->CompanyCount($searchText);
            $returns = $this->paginationCompress ( "Company", $count, 10 );
            $data['companies'] = $this->companies->getCompanies($searchText, $returns["page"], $returns["segment"],$data['toSort'],$data['toSearch']);
			$data['title'] = 'Companies';
			$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$this->load->view('includes/header',$data);
			$this->load->view('companies/company');
        }
		
	}
	public function add(){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
        	$data['title'] = 'Add New Company';
			$this->load->view('includes/header',$data);
			$this->load->view('companies/add_company');
        }
	}
	public function addAction(){
		if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else
        {
        	$this->load->library('form_validation');
            
            $this->form_validation->set_rules('cname','Company Name','trim|required|max_length[128]');
			$this->form_validation->set_rules('cowner','Company Owner','trim|required|max_length[128]');
            $this->form_validation->set_rules('cemail','Company Email','trim|required|valid_email|max_length[128]');
            //$this->form_validation->set_rules('cphone','Company Phone','trim|regex_match[/^[0-9]{10}$/]');
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $cname = ucwords(strtolower($this->input->post('cname')));
				$cowner = ucwords(strtolower($this->input->post('cowner')));
				$cweb = $this->input->post('cweb');
                $cemail = $this->input->post('cemail');
                $cphone = $this->input->post('cphone');
                $notes = $this->input->post('notes');
                $companyInfo = array('company_name'=>$cname, 'company_owner'=> $cowner,'company_website'=> $cweb, 'company_email'=>$cemail, 'company_phone'=>$cphone, 'notes'=>$notes, 'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
                
                $this->load->model('companies');
                $result = $this->companies->addNewCompany($companyInfo);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Company created successfully');
					redirect('Company');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Company creation failed');
					redirect('Company/add');
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
                redirect('company');
            }
			$this->load->model('companies');
			
			$companydata = $this->companies->getCompanyById(convert_uudecode(base64_decode($userId)));
			if(empty($companydata)){
				  redirect('company');
			}
			$data['companyInfo'] = $companydata;
			$this->load->model('users');
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$data['title'] = 'Edit Company';
			$this->load->view('includes/header',$data);
			$this->load->view('companies/edit_company');
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
            
            $companyId = $this->input->post('companyId');
            
            $this->form_validation->set_rules('cname','Company Name','trim|required|max_length[128]');
			$this->form_validation->set_rules('cowner','Company Owner','trim|required|max_length[128]');
            $this->form_validation->set_rules('cemail','Company Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('cphone','Company Phone','trim|regex_match[/^[0-9]{10}$/]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->edit(base64_encode(convert_uuencode($companyId)));
            }
            else
            {
				$this->load->model('companies');
				
                $cname = ucwords(strtolower($this->input->post('cname')));
				$cowner = ucwords(strtolower($this->input->post('cowner')));
				$cweb = $this->input->post('cweb');
                $cemail = $this->input->post('cemail');
                $cphone = $this->input->post('cphone');
                $notes = $this->input->post('notes');
                $companyInfo = array('company_name'=>$cname, 'company_owner'=> $cowner,'company_website'=> $cweb, 'company_email'=>$cemail, 'company_phone'=>$cphone, 'notes'=>$notes, 'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
                
                
                $result = $this->companies->editCompany($companyInfo, $companyId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Company updated successfully');
					redirect('company');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Company updation failed');
					 redirect('company');
                }
                
               
            }
        }
    }
    public function ajax_deleteCompany()
    {
        if($this->isTicketter() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
			$this->load->model('companies');
            $companyId = $this->input->post('companyId');
            $companyInfo = array('is_deleted'=>1,'updated_by'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
            $result = $this->companies->deleteCompany($companyId, $companyInfo);
           if ($result > 0) {
			   echo(json_encode(array('status'=>TRUE)));
			   }else{
				   echo(json_encode(array('status'=>FALSE))); 
				}
        }
    }
	
	/**
	 *@Client Details page
	 *@created date: 04-12-2018
	 *here Client ID is company Name
	 */
	public function Detail($clientId){
		if($this->isTicketter() == TRUE)
        {
			$this->loadThis();
			
        }else{
			if($clientId == null)
            {
                redirect('company');
            }
			$this->load->model('companies');
			$this->load->model('users');
			$data['title'] = 'Client Details';
			
			$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$companydata = $this->companies->getCompanyById($clientId);
			$data['companyInfo'] = $companydata;
			$data['notes'] =$this->companies->getNotesCompany($clientId);
            $data['contacts'] = $this->companies->getContactsByCompany($clientId);
            $data['employees']= $this->users->getAllEmployee();
            $data['tasks'] =$this->companies->getTasksCompany($clientId);
			$this->load->view('includes/header',$data);
			$this->load->view('companies/company_details');
		}
	}
	
	/**
	 *@Client Details page
	 *@created date: 04-12-2018
	 *here Client ID is company Name
	 */
	 public function addCompanyContact(){
		 if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
			
        }else
        {
			$fname = ucwords(strtolower($this->input->post('fname')));
			$lname = ucwords(strtolower($this->input->post('lname')));
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $company = $this->input->post('client_id');
                $clientInfo = array('email'=>$email, 'fname'=> $fname,'lname'=> $lname, 'phone'=>$phone, 'company'=>$company, 'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
				
                $this->load->model('clients');
				
                $result = $this->clients->addNewClient($clientInfo);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', "New Contact $fname was created successfully.");
					redirect($_SERVER['HTTP_REFERER']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'New Contact creation failed');
					redirect($_SERVER['HTTP_REFERER']);
                }
			
		}
	 }
	
    public function addNotesAjax()
    {
        $this->load->model('companies');
        $company_id   = $this->input->post('company_id');
        $note_title   = $this->input->post('note_title');
        $note_content = $this->input->post('note_content');
        $data         = array(
                            'company_id'   => $company_id,
                            'note_title'   => $note_title,
                            'note_content' => $note_content,
                            'created_by'   => $this->vendorId,
                            'created_date' => date('Y-m-d H:i:s')
                        );
        $result       = $this->companies->addNotesCompany($data);
        $i            = $this->vendorId;
        $q            = $this->db->query("SELECT fname,lname FROM users WHERE id=$i");
        $r            = $q->result();
        $name         = $r[0]->fname.' '.$r[0]->lname;
        $date         = date('D, d M Y H:i');
        if($result > 0)
        {
            $responsedata = array('status'=>'success','msg'=>'New Note added successfully','note_title'=>$note_title,'note_content'=>$note_content,'created_by'=>$name,'date'=>$date,'note_id'=>$result);
            echo json_encode($responsedata);
            die;
        }
        else
        {
            $responsedata = array('status'=>'error','msg'=>'New Note creation failed!');
            echo json_encode($responsedata);
            die;
        }

    }
    public function saveNotesAjax()
    {
        $this->load->model('companies');
        $note_id      = $this->input->post('edit_id');
        $note_title   = $this->input->post('edit_title');
        $note_content = $this->input->post('edit_content');
        $data         = array(
                            'note_title'   => $note_title,
                            'note_content' => $note_content,
                        );
        $result       = $this->companies->saveNotesCompany($data,$note_id);
        $i            = $this->vendorId;
        $q            = $this->db->query("SELECT fname,lname FROM users WHERE id=$i");
        $r            = $q->result();
        $name         = $r[0]->fname.' '.$r[0]->lname;
        $date         = date('D, d M Y H:i');
        if($result == true)
        {
            $responsedata = array('status'=>'success','msg'=>'Note updated successfully','note_title'=>$note_title,'note_content'=>$note_content,'created_by'=>$name,'date'=>$date);
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
    public function deleteNotesAjax()
    {
        $this->load->model('companies');
        $note_id = $_POST['note_id'];
        $result  = $this->companies->deleteNotesCompany($note_id);
        if($result == true)
        {
            $responsedata = array('status'=>'success','msg'=>'Note deleted successfully');
            echo json_encode($responsedata);
            die;
        }
        else
        {
            $responsedata = array('status'=>'error','msg'=>'Note deletion failed!');
            echo json_encode($responsedata);
            die;
        }
    }
    public function addTasksAjax()
    {
        $this->load->model('companies');
        $this->load->model('users');
        $company_id    = $this->input->post('company_id');
        $employee_id   = $this->input->post('employee_id');
        $task_title    = $this->input->post('task_title');
        $task_content  = $this->input->post('task_content');
        $data          = array(
                            'company_id'        => $company_id,
                            'employee_assigned' => $employee_id,
                            'title'             => $task_title,
                            'description'       => $task_content,
                            'created_by'        => $this->vendorId,
                            'created_at'        => date('Y-m-d H:i:s')
                        );
        $result       = $this->companies->addTasksCompany($data);
        $i            = $this->vendorId;
        $q            = $this->db->query("SELECT fname,lname FROM users WHERE id=$i");
        $r            = $q->result();
        $name         = $r[0]->fname.' '.$r[0]->lname;
        $date         = date('D, d M Y H:i');
        $employees    = $this->users->getAllEmployee();
        $optionHtm    = '';
        foreach($employees as $employee){
            if($employee_id==$employee->id){
                $selected = 'selected';
            }else{
                $selected = '';
            }
            $optionHtm .= '<option value="'.$employee->id.'" '.$selected.'>'.$employee->fname.' '.$employee->lname.'</option>';
        }
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
        $this->load->model('companies');
        $task_id = $_POST['task_id'];
        $result  = $this->companies->deleteTasksCompany($task_id);
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
        $this->load->model('companies');
        $task_id      = $this->input->post('edittask_id');
        $task_title   = $this->input->post('edittask_title');
        $task_content = $this->input->post('edittask_content');
        $employee_id  = $this->input->post('edit_empid');
        $data         = array(
                            'employee_assigned' => $employee_id,
                            'title'             => $task_title,
                            'description'       => $task_content,
                        );
        $result       = $this->companies->saveTasksCompany($data,$task_id);
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
}