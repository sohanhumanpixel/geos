<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Employee Time Sheet Entry
 * @purpose: Integrate time sheet
 */
Class Messaging extends BaseController {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load session library
		$this->load->library('session');
		$this->load->library('mahana_messaging');
		$this->isLoggedIn(); 
	}
	public function index()
	{
		$this->load->model('users');
		$data['title'] = 'Inbox';
		$data['vendorId'] = $this->vendorId;
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$this->load->model("mahana_model");
		$data['all_threads'] = $this->mahana_model->get_all_user_threads($this->vendorId);
        $this->session->set_userdata('back_url', current_url());
		$this->load->view('includes/header',$data);
		$this->load->view('messaging/inbox');
	}

	public function send_msg()
	{
		$this->load->model('users');
		$data['title'] = 'Messaging';
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$userInfo = $this->users->getUserInfo($this->vendorId);
		$data['username'] = $userInfo[0]->fname.' '.$userInfo[0]->lname;
		$data['usermail'] = $userInfo[0]->email;
		$data['userId'] = $userInfo[0]->id;
		$this->load->view('includes/header',$data);
		$this->load->view('messaging/send_message');
	}
	public function send_msgAction()
	{
		$this->load->library('form_validation');
            
        $userId = $this->vendorId;
        
        $this->form_validation->set_rules('message_msg','Message','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->send_msg();
        }
        else
	    {
			$this->load->model("mahana_model");
			if(!isset($_POST['msg_id'])){
				$result = $this->mahana_model->send_new_message($_POST['sender_id'], $_POST['recipient'], $_POST['subject_msg'], $_POST['message_msg'], '');
			}else{
				$result = $this->mahana_model->reply_to_message($_POST['msg_id'],$_POST['sender_id'],$_POST['message_msg'], '');
			}
			if($result>0){
				$this->session->set_flashdata('success','Message Sent Successfully');
				redirect($this->session->userdata('back_url'));
			}else{
				$this->session->set_flashdata('error','Error in sending message');
				redirect($this->session->userdata('back_url'));
			}
		}
	}
	public function conversations($thread_id = 0)
	{
		$this->load->model('users');
		$data['thread_id'] = $thread_id;
		$data['title'] = 'Conversations';
		$data['vendorId'] = $this->vendorId;
		$data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$this->load->model("mahana_model");
        $this->session->set_userdata('back_url', current_url());
		$data['full_thread'] = $this->mahana_model->get_full_thread($thread_id,$this->vendorId);
		$data['participants'] = $this->mahana_model->get_participant_list($thread_id, $this->vendorId);
		//mark all meesages as read when open conversation
		$qu = $this->db->query("SELECT id FROM msg_messages WHERE thread_id=$thread_id");
		$messagesArr = $qu->result_array();
		foreach($messagesArr as $message){
			$this->mahana_model->update_message_status($message['id'],$this->vendorId,1);
		}
		//mark thread read
		$this->mahana_model->update_thread_status($thread_id,$this->vendorId,1);
		$this->load->view('includes/header',$data);
		$this->load->view('messaging/conversations');
	}
	public function ajax_replyMsg()
	{
		$this->load->model("mahana_model");
		$result = $this->mahana_model->reply_to_message($_POST['msg_id'],$_POST['sender_id'],$_POST['reply_msg'], '');
		if($result>0){
			echo json_encode(array('status'=>'success','msg'=>'Sent Successfully'));
			die;
		}else{
			echo json_encode(array('status'=>'error','msg'=>'Sending failed'));
			die;
		}
	}
	public function ajax_deleteMsg()
	{
		$this->load->model("mahana_model");
		$result = $this->mahana_model->delete_message($_POST['msg_id']);
		if($result){
			echo json_encode(array('status'=>'success','msg'=>'Deleted Successfully'));
			die;
		}else{
			echo json_encode(array('status'=>'error','msg'=>'Deletion failed!!'));
			die;
		}
	}
	public function ajax_uploadFileMsg()
	{
		if ($this->input->is_ajax_request()) {
			if($_FILES['fileMsg']['name']!=''){
				$sender_id = $_POST['sender_id'];
				$upload_path = "assets/messages/";
				$imagetype = $_FILES['fileMsg']['type'];
				$filename = $_FILES['fileMsg']['name'];
				$tempname = $_FILES["fileMsg"]["tmp_name"];
				
				$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
				
				$t = preg_replace('/\s+/', '', time());
				$fileName = $t . ''.str_replace(' ','',$filename);
				if ($_FILES["fileMsg"]["size"] > 1000000) {
					echo json_encode(array('status'=>'error','message'=>'Sorry, your file is too large.'));
					die;
				}else{
					$moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
					if( $moved ) {
						$this->load->model('mahana_model');
						$this->mahana_model->reply_to_message($_POST['msg_id'],$_POST['sender_id'],$fileName,'','file');
						echo json_encode(array('status'=>'success','message'=>base_url().''.$upload_path.''.$fileName));die;
					}else{
						echo json_encode(array('status'=>'error','message'=>"Not uploaded because of error #".$_FILES["document_name"]["error"]));die;
					}
				}	
			}else{
				echo json_encode(array('status'=>'error','message'=>"Please Select File"));
				die;
			}
		}
		die;
	}
}