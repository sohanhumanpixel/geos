<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Documents Controller
 * @purpose: Documents module integration
 * @created at: 15-10-2018
 * @created by: HumanPixel
 */
 require APPPATH . '/libraries/BaseController.php';
Class Documents extends BaseController {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form','url');
		// Load form validation library
		//$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		$this->isLoggedIn(); 
        $isLoggedIn = $this->session->userdata ( 'logged_in' );
	}
	/**
	 *List of documents
	 */
	public function index() {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
			$this->load->model('documentModel');
            $this->load->library('pagination');
            $count = $this->documentModel->documentCount();
            $returns = $this->paginationCompress ( "Documents", $count, 10 );
            $data['documentData'] = $this->documentModel->getDocuments($returns["page"], $returns["segment"]);
			$data['title'] = 'Document';
			$this->load->view('includes/header',$data);
			$this->load->view('documents/list_document_temp');
        }
	}
	/**
	 *@add Document
	 */
	public function add(){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
    		$data['title'] = "Upload New Document";
    		$this->load->view('includes/header',$data);
    		$this->load->view('documents/add_document');
        }
	}
	
	/**
	* This function is used to add new document
	* Date; 15-10-2018
	*/
    public function addAction()
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
		   
		  
		   $upload_path = "assets/documentupload/";
		   if($_FILES['document_name']['name']!=''){
			   $imagetype = $_FILES['document_name']['type'];
			   $filename = $_FILES['document_name']['name'];
				$tempname = $_FILES["document_name"]["tmp_name"];
				$t = preg_replace('/\s+/', '', time());
				$fileName = $t . ''.str_replace(' ','',$filename);
				$moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
				if( $moved ) {
					$this->load->model('documentModel');
					$document_title = $this->input->post('document_title');
					$descriptions = $this->input->post('descriptions');
					
					$fileArrayData = array('document_title'=>$document_title, 'document_name'=>$fileName,'document_real_name'=>$filename,'document_type'=>$imagetype,'descriptions'=>$descriptions,'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
					$result = $this->documentModel->addDocument($fileArrayData);
					if($result > 0){
                    $this->session->set_flashdata('success','Document File added successfully');
                    redirect('Documents');
					}
					else
					{
						$this->session->set_flashdata('error','Document file adding failed');
						redirect('Documents/add');
					}
				} else {
					$this->session->set_flashdata('error',"Not uploaded because of error #".$_FILES["document_name"]["error"]);
                    redirect('Documents/add');
				}
		   }
        }
    }
	
	/**
	 *Edit Document View form
	 */
	 
    public function editdocu($id){
    	if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
        	if($id == null)
            {
                redirect('Documents');
            }
	    	$data['title'] = 'Edit Documents';
	    	$this->load->model('documentModel');
	    	$announcement = $this->documentModel->getDocumentById(convert_uudecode(base64_decode($id)));
	    	$data['editDocumentData'] = $announcement;
	    	$this->load->view('includes/header',$data);
	    	$this->load->view('documents/edit_document');
	    }
    }
	
	/**
	 *Edit Dcoument Action
	 *created date; 16-10-2018
	 *created by: Humanpixel
	 */
    public function editAction($id)
    {
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
			$document_title = $this->input->post('document_title');
			$descriptions = $this->input->post('descriptions');
			
			$fileArrayData = array('document_title'=>$document_title,'descriptions'=>$descriptions,'updated_at'=>date('Y-m-d H:i:s'));
	
			$upload_path = "assets/documentupload/";
			
			if($_FILES['document_name']['name']!=''){
			   $imagetype = $_FILES['document_name']['type'];
			   $filename = $_FILES['document_name']['name'];
				$tempname = $_FILES["document_name"]["tmp_name"];
				$t = preg_replace('/\s+/', '', time());
				$fileName = $t . ''.str_replace(' ','',$filename);
				$moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
				if( $moved ) {
					//Unlink image
					$oldimagename = $this->input->post('old_imgname');
					unlink($upload_path.''.$oldimagename);
					
					$fileArrayData = array('document_title'=>$document_title, 'document_name'=>$fileName,'document_real_name'=>$filename,'document_type'=>$imagetype,'descriptions'=>$descriptions, 'updated_at'=>date('Y-m-d H:i:s'));
				}
			}
			
				$this->load->model('documentModel');
				
				$result = $this->documentModel->editDocument($fileArrayData,convert_uudecode(base64_decode($id)));
				
				
				if($result > 0)
                {
                    $this->session->set_flashdata('success','Document saved successfully');
                    redirect('Documents');
                }
                else
                {
                    $this->session->set_flashdata('error','Document updating failed');
                    redirect('Documents/editdocu/<?=$id?>');
                }    
        }
    }
	
	/**
	 *@delete Document
	 */
    public function deltedocu($id){
        if($this->isTicketter() == TRUE)
        {
            $this->loadThis();
        }else{
        	$this->load->model('documentModel');
        	$this->documentModel->deleteDocument(convert_uudecode(base64_decode($id)));
			$this->session->set_flashdata('success','Document deleted successfully!');
        	redirect('Documents');
        }
    }
}
?>