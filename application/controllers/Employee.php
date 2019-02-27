<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * User Controller
 * @purpose: user module integration
 */
Class Employee extends BaseController {
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
	public function index() {
			$this->load->model('groups');
			$data['title'] = 'Dashboard';
      $this->load->model('users');
      $this->load->model('timesheetsModel');
      $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
			$userLogin = $this->session->userdata ( 'logged_in' );
			$data['countGroup'] = $this->groups->countEmpGroup($userLogin['user_id']);
      $searchText = '';
      $data['countTask'] = $this->timesheetsModel->taskEmpCount($this->vendorId, $searchText);
			$this->load->view('includes/header',$data);
			$this->load->view('admin/empdashboard');
	}
/**
 *@method name: userListing
 *@other method: userListingCount, userListing  - both method exist into users model
 *@ Author: Human Pixel
 *@date: 01-10-2018
*/ 
 public function taskList(){
  $this->load->model('timesheetsModel');
	$this->load->library('pagination');
	$searchText = '';
	$count = $this->timesheetsModel->taskEmpCount($this->vendorId, $searchText);
	$returns = $this->paginationCompress ( "Employee/taskList/", $count, 10 );
  $data['taskLists'] = $this->timesheetsModel->getTasksByEmployee($this->vendorId, $searchText, $returns["page"], $returns["segment"]);
	$data['title'] = 'Task List';
  $this->load->model('users');
  $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	$this->load->view('includes/header',$data);
	$this->load->view('admin/employee_task_list');
 }
 
 public function projectList(){
  $this->load->model('timesheetsModel');
  $this->load->library('pagination');
  $searchText = '';
  $count = $this->timesheetsModel->projEmpCount($this->vendorId, $searchText);
  $returns = $this->paginationCompress ( "Employee/projectList/", $count, 10 );
  $data['projectLists'] = $this->timesheetsModel->getProjectsByEmployee($this->vendorId, $searchText, $returns["page"], $returns["segment"]);
  $data['title'] = 'My Projects';
  $this->load->model('users');
  $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
  $this->load->view('includes/header',$data);
  $this->load->view('admin/emp_projects');
 }

 public function projectView($projectId)
 {
  $this->load->model('project_type');
  $this->load->model('users');
  $data['title'] = 'Project View';
  $data['projectHistory'] = $this->project_type->getCompletedTaskPerProject($projectId,$this->vendorId);
  $data['incompProjects'] = $this->project_type->getIncompletedTaskPerProject($projectId,$this->vendorId);
  $data['compProjTasks'] = $this->project_type->getCompletedProjectTask($projectId,$this->vendorId);
  $data['incompProjTasks'] = $this->project_type->getIncompletedProjectTask($projectId,$this->vendorId);
  $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
  $projectdata = $this->project_type->getProjectById($projectId);
  $data['projectInfo'] = $projectdata;
  $data['project_id'] = $projectId;
  $data['tasks'] =$this->project_type->getTasksProject($projectId);
  $data['backUrl'] = base_url('Employee/projectList');
  $data['adminAccess'] = 'false';
  $this->load->view('includes/header',$data);
  $this->load->view('projects/project_history');
 }

 public function taskView($taskID=null,$ID=null)
 {
  if($taskID==null){
    redirect("Employee/taskList");
  }
  $data['title'] = 'Task View';
  $this->load->model('users');
  $this->load->model('timesheetsModel');
  $data['taskDetail'] = $this->timesheetsModel->getTaskDetail(convert_uudecode(base64_decode($taskID)));
  $data['subtaskDetail'] = $this->timesheetsModel->getSubTaskDetail(convert_uudecode(base64_decode($taskID)),convert_uudecode(base64_decode($ID)));
  $data['checkCompleteTask'] = $this->timesheetsModel->getEmpTaskById(convert_uudecode(base64_decode($ID)));
  $data['taskComments'] = $this->timesheetsModel->getCommentsTask(convert_uudecode(base64_decode($ID)));
  //$data['subTaskComments'] = $this->timesheetsModel->getCommentsSubTask(convert_uudecode(base64_decode($ID)));
  $data['taskPhotos'] = $this->timesheetsModel->getPhotosTask(convert_uudecode(base64_decode($ID)));
  $data['taskID'] = convert_uudecode(base64_decode($taskID));
  $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
  $this->load->view('includes/header',$data);
  $this->load->view('admin/employee_task_view');
 }
 /*
  *@method name: grouplist
  *@author: Human Pixel
  *@create date: 01-10-2018
  */
 public function grouplist(){
	$userLogin = $this->session->userdata ( 'logged_in' );
	$this->load->model('groups');
	$data['empGroupData'] = $this->groups->getEmpGroup($userLogin['user_id']);
	$data['title'] = 'Employee Group';
  $this->load->model('users');
    $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
	$this->load->view('includes/header',$data);
	$this->load->view('admin/employee_glist');	
 }
 
 /*
 * Project tasks list
 */
  public function projectTasks(){
    $this->load->model('timesheetsModel');
    $this->load->library('pagination');
    $searchText = '';
    $count = $this->timesheetsModel->projectTaskEmpCount($this->vendorId, $searchText);
    $returns = $this->paginationCompress ( "Employee/projectTasks/", $count, 10 );
    $data['taskLists'] = $this->timesheetsModel->getProjectTasksByEmployee($this->vendorId, $searchText, $returns["page"], $returns["segment"]);
    $data['title'] = 'Project Tasks';
    $this->load->model('users');
    $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
    $this->load->view('includes/header',$data);
    $this->load->view('admin/employee_project_tasks');
   }

 /*
 * Project tasks view
 */

   public function projTaskView($taskID=null,$ID=null)
   {
    if($taskID==null){
      redirect("Employee/projectTasks");
    }
    $data['title'] = 'Project Task View';
    $this->load->model('users');
    $this->load->model('timesheetsModel');
    $data['taskDetail'] = $this->timesheetsModel->getProjectTaskDetail(convert_uudecode(base64_decode($taskID)));
    $data['checkCompleteTask'] = $this->timesheetsModel->getEmpProjTaskById(convert_uudecode(base64_decode($ID)));
    $data['taskComments'] = $this->timesheetsModel->getCommentsProjTask(convert_uudecode(base64_decode($ID)));
    //$data['subTaskComments'] = $this->timesheetsModel->getCommentsSubTask(convert_uudecode(base64_decode($ID)));
    $data['taskPhotos'] = $this->timesheetsModel->getPhotosProjTask(convert_uudecode(base64_decode($ID)));
    $data['taskID'] = convert_uudecode(base64_decode($taskID));
    $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
    $this->load->view('includes/header',$data);
    $this->load->view('admin/emp_project_task_view');
   }

 /**
  * @method:ajax_checkEmailExists
  * @purpose: check duplicacy of user email on registration/edit page
  * model used: users
  */
  
 public function ajax_checkEmailExists(){
		$userId = $this->input->post("userId");
       $email = $this->input->post("email");
		$this->load->model('users');
        if(empty($userId)){
            $result = $this->users->checkEmailExists($email);
        } else {
            $result = $this->users->checkEmailExists($email, $userId);
        }
        if(empty($result)){
			echo("true"); 
			}
        else { echo("false"); }
 }
 
 /**
  * @method:ajax_checkUsernameExists
  * @purpose: check duplicacy of username on registration/edit page
  * model used: users
  */
 public function ajax_checkUsernameExists(){
	 $userId = $this->input->post("userId");
       $username = $this->input->post("username");
		$this->load->model('users');
        if(empty($userId)){
            $result = $this->users->checkUsernameExists($username);
        } else {
            $result = $this->users->checkUsernameExists($username, $userId);
        }
        if(empty($result)){
			echo("true"); 
			}
        else { echo("false"); }
 }
 
 /**
    * This function is used to delete the user using userId
    * @return boolean $result : TRUE / FALSE
  */
    public function ajax_deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
			$this->load->model('users');
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_at'=>date('Y-m-d H:i:s'));
            $result = $this->users->deleteUser($userId, $userInfo);
           if ($result > 0) {
			   echo(json_encode(array('status'=>TRUE)));
			   }else{
				   echo(json_encode(array('status'=>FALSE))); 
				}
        }
    }
	
	/**
	 *Get Role List
	 */
	 public function roleList(){
		$data['title'] = 'Admin Role List';
		$this->load->model('users');
		$data['roles'] = $this->users->getUserRoles();
    $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
		$this->load->view('includes/header',$data);
		$this->load->view('admin/admin_role_list');
	 }
	 
	 /**
	  *@get employeed Leave List
	  *@ajax request
	  *@created date: 16-10-2018
	  */
	public function ajax_getLeaveList(){
		echo '[
  {
    "title": "All Day Event",
    "start": "2018-10-01"
  },
  {
    "title": "New Year",
    "start": "2018-12-29",
    "end": "2019-01-01",
   "color": "#8A2BE2"
  },
  {
    "id": "999",
    "title": "Repeating Event",
    "start": "2018-10-09T16:00:00-05:00",
	"color": "green"
  },
  {
    "id": "999",
    "title": "Repeating Event",
    "start": "2018-10-16T16:00:00-05:00"
  },
  {
    "title": "Conference",
    "start": "2018-10-11",
    "end": "2018-10-13",
	"color": "red"
  },
  {
    "title": "Meeting",
    "start": "2018-10-12T10:30:00-05:00",
    "end": "2018-10-12T12:30:00-05:00"
  },
  {
    "title": "Lunch",
    "start": "2018-10-12T12:00:00-05:00"
  },
  {
    "title": "Meeting",
    "start": "2018-10-12T14:30:00-05:00"
  },
  {
    "title": "Happy Hour",
    "start": "2018-10-12T17:30:00-05:00"
  },
  {
    "title": "Dinner",
    "start": "2018-10-12T20:00:00"
  },
  {
    "title": "Birthday Party",
    "start": "2018-10-13T07:00:00-05:00"
  },
  {
    "title": "Click for Google",
    "url": "http://google.com/",
    "start": "2018-10-28"
  }
]';
	  die;
	}
  public function skills()
  {
    if($this->isTicketter() == TRUE)
    {
        $this->loadThis();
    }else{
      $this->load->model('users');
      $data['skills'] = $this->users->getAllSkills();
      $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
      $data['title'] = 'Skills';
      $this->load->view('includes/header',$data);
      $this->load->view('admin/admin_skills');
    }
  }
  public function addSkill()
  {
    if($this->isTicketter() == TRUE)
    {
        $this->loadThis();
    }else{
      $this->load->model('users');
      $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
      $data['title'] = 'Add Skill';
      $this->load->view('includes/header',$data);
      $this->load->view('admin/admin_add_skill');
    }
  }
  public function addSkillAction()
  {
    if($this->isTicketter() == TRUE)
    {
        $this->loadThis();
    }else{
      $skill_name = $this->input->post('skill_name');
      $dataInfo = array('skill_name'=>$skill_name, 'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
      
      $this->load->model('users');
      $result = $this->users->addNewSkill($dataInfo);
      if($result > 0)
      {
          $this->session->set_flashdata('success', 'New Skill created successfully');
          redirect('Employee/skills');
      }
      else
      {
          $this->session->set_flashdata('error', 'Skill creation failed');
          redirect('Employee/addSkill');
      }
    }
  }
  public function editSkill($skillID = null)
  {
    if($this->isTicketter() == TRUE)
    {
        $this->loadThis();
    }else{
      if($skillID == null)
      {
          redirect('Employee/skills');
      }
      $this->load->model('users');
      $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
      $data['skill'] = $this->users->getSkillById(convert_uudecode(base64_decode($skillID)));
      $data['title'] = 'Edit Skill';
      $this->load->view('includes/header',$data);
      $this->load->view('admin/admin_edit_skill');
    }
  }
  public function editSkillAction()
  {
    if($this->isTicketter() == TRUE)
    {
        $this->loadThis();
    }
    else
    {
      $skill_name = $this->input->post('skill_name');
      $skill_id = $this->input->post('skill_id');
      $dataInfo = array('skill_name'=>$skill_name);
      
      $this->load->model('users');
      $result = $this->users->editSkill($dataInfo,$skill_id);
      if($result)
      {
          $this->session->set_flashdata('success', 'Skill updated successfully');
          redirect('Employee/skills');
      }
      else
      {
          $this->session->set_flashdata('error', 'Skill updation failed');
          redirect('Employee/editSkill/'.base64_encode(convert_uuencode($skill_id)));
      }
    }
  }
  public function deleteSkill($deleteId=NULL){
    $this->load->model('users');
    $this->users->deleteSkill($deleteId);
    $this->session->set_flashdata('success', 'Skill has been deleted successfully');
    redirect('Employee/skills');
  }
  public function ajax_postTaskComment()
  {
    $this->load->model('users');
    $date = date("Y-m-d H:i");
    $data = array(
      'timesheet_id' => $_POST['timesheet_id'],
      'emp_task_id'  => $_POST['empT_id'],
      'task_id'      => $_POST['task_id'],
      'parent_task'  => 0,
      'comment'      => $_POST['content'],
      'commented_by' => $this->vendorId,
      'commented_at' => $date
    );
    $result = $this->users->postTaskComment($data);
    $uq = $this->db->query("SELECT fname,lname FROM users WHERE id=".$this->vendorId);
    $ur = $uq->result();
    $name = $ur[0]->fname.' '.$ur[0]->lname;
    if($result > 0){
      $responseData = array("status"=>'success','msg'=>'Comment added','id'=>$result,'name'=>$name,'comment'=>$_POST['content'],'date'=>$date);
      echo json_encode($responseData);
      die;
    }else{
      $responseData = array("status"=>'error','msg'=>'Comment adding failed!');
      echo json_encode($responseData);
      die;
    }
  }
  public function ajax_postProjTaskComment()
  {
    $this->load->model('users');
    $date = date("Y-m-d H:i");
    $data = array(
      'timesheet_id' => $_POST['timesheet_id'],
      'emp_task_id'  => $_POST['empT_id'],
      'task_id'      => $_POST['task_id'],
      'comment'      => $_POST['content'],
      'commented_by' => $this->vendorId,
      'commented_at' => $date
    );
    $result = $this->users->postProjTaskComment($data);
    $uq = $this->db->query("SELECT fname,lname FROM users WHERE id=".$this->vendorId);
    $ur = $uq->result();
    $name = $ur[0]->fname.' '.$ur[0]->lname;
    if($result > 0){
      $responseData = array("status"=>'success','msg'=>'Comment added','id'=>$result,'name'=>$name,'comment'=>$_POST['content'],'date'=>$date);
      echo json_encode($responseData);
      die;
    }else{
      $responseData = array("status"=>'error','msg'=>'Comment adding failed!');
      echo json_encode($responseData);
      die;
    }
  }
  public function ajax_postDeleteComment()
  {
    $id = $_POST['id'];
    $this->db->query("DELETE FROM comments_tasks WHERE id=$id");
    $responseData = array('status'=>'success','msg'=>'Comment deleted');
    echo json_encode($responseData);
    die;
  }
  public function ajax_postDeleteProjComment()
  {
    $id = $_POST['id'];
    $this->db->query("DELETE FROM comments_project_tasks WHERE id=$id");
    $responseData = array('status'=>'success','msg'=>'Comment deleted');
    echo json_encode($responseData);
    die;
  }
  public function ajax_postSubTaskComment()
  {
    $this->load->model('users');
    $date = date("Y-m-d H:i");
    $data = array(
      'timesheet_id' => $_POST['timesheet_id'],
      'emp_task_id'  => $_POST['empT_id'],
      'task_id'      => $_POST['task_id'],
      'parent_task'  => $_POST['parent_task'],
      'comment'      => $_POST['content'],
      'commented_by' => $this->vendorId,
      'commented_at' => $date
    );
    $result = $this->users->postTaskComment($data);
    $uq = $this->db->query("SELECT fname,lname FROM users WHERE id=".$this->vendorId);
    $ur = $uq->result();
    $name = $ur[0]->fname.' '.$ur[0]->lname;
    if($result > 0){
      $responseData = array("status"=>'success','msg'=>'Comment added','id'=>$result,'name'=>$name,'comment'=>$_POST['content'],'date'=>$date,'sub_id'=>$_POST['task_id']);
      echo json_encode($responseData);
      die;
    }else{
      $responseData = array("status"=>'error','msg'=>'Comment adding failed!');
      echo json_encode($responseData);
      die;
    }
  }
  public function ajax_uploadTaskPhoto()
  {
    if($_FILES['photo']['name']!=''){
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
      $upload_path = "assets/images/tasks/";
      $imagetype = $_FILES['photo']['type'];
      $filename = $_FILES['photo']['name'];
      $tempname = $_FILES["photo"]["tmp_name"];
      //$target_file = 
      
      $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
      
      $t = preg_replace('/\s+/', '', time());
      $fileName = $t . ''.str_replace(' ','',$filename);
      
      if ($_FILES["photo"]["size"] > 1000000) {
        echo json_encode(array('status'=>'error','message'=>'Sorry, your file is too large.'));
        die;
      }else if(!in_array($imageFileType, $valid_extensions)){
        echo json_encode(array('status'=>'error','message'=>$imageFileType));
        die;
      }else{
        $moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
        if( $moved ) {
          //unlink image
          $this->load->model('users');
          $currentUserId = $this->vendorId;
          $data = array('timesheet_id'=>$_POST['timesheet_id'],'emp_task_id'=>$_POST['empT_id'],'task_id'=>$_POST['task_id'],'photo'=>$fileName,'uploaded_by'=>$currentUserId,'uploaded_at'=>date("Y-m-d H:i:s"));
          $id = $this->users->insertTaskPhoto($data);
          echo json_encode(array('status'=>'success','message'=>base_url().''.$upload_path.''.$fileName,'id'=>$id));die;
        }else{
          echo json_encode(array('status'=>'success','message'=>"Not uploaded because of error #".$_FILES["document_name"]["error"]));die;
        }
      } 
    }else{
      echo json_encode(array('status'=>'error','message'=>'Please select image'));
      die;
    }
  }
  public function ajax_uploadProjTaskPhoto()
  {
    if($_FILES['photo']['name']!=''){
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
      $upload_path = "assets/images/tasks/";
      $imagetype = $_FILES['photo']['type'];
      $filename = $_FILES['photo']['name'];
      $tempname = $_FILES["photo"]["tmp_name"];
      //$target_file = 
      
      $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
      
      $t = preg_replace('/\s+/', '', time());
      $fileName = $t . ''.str_replace(' ','',$filename);
      
      if ($_FILES["photo"]["size"] > 1000000) {
        echo json_encode(array('status'=>'error','message'=>'Sorry, your file is too large.'));
        die;
      }else if(!in_array($imageFileType, $valid_extensions)){
        echo json_encode(array('status'=>'error','message'=>$imageFileType));
        die;
      }else{
        $moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
        if( $moved ) {
          //unlink image
          $this->load->model('users');
          $currentUserId = $this->vendorId;
          $data = array('timesheet_id'=>$_POST['timesheet_id'],'emp_task_id'=>$_POST['empT_id'],'task_id'=>$_POST['task_id'],'photo'=>$fileName,'uploaded_by'=>$currentUserId,'uploaded_at'=>date("Y-m-d H:i:s"));
          $id = $this->users->insertProjTaskPhoto($data);
          echo json_encode(array('status'=>'success','message'=>base_url().''.$upload_path.''.$fileName,'id'=>$id));die;
        }else{
          echo json_encode(array('status'=>'success','message'=>"Not uploaded because of error #".$_FILES["document_name"]["error"]));die;
        }
      } 
    }else{
      echo json_encode(array('status'=>'error','message'=>'Please select image'));
      die;
    }
  }
  public function ajax_uploadSubTaskPhoto()
  {
    if($_FILES['photo']['name']!=''){
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
      $upload_path = "assets/images/tasks/";
      $imagetype = $_FILES['photo']['type'];
      $filename = $_FILES['photo']['name'];
      $tempname = $_FILES["photo"]["tmp_name"];
      //$target_file = 
      
      $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
      
      $t = preg_replace('/\s+/', '', time());
      $fileName = $t . ''.str_replace(' ','',$filename);
      
      if ($_FILES["photo"]["size"] > 1000000) {
        echo json_encode(array('status'=>'error','message'=>'Sorry, your file is too large.','sub_id'=>$_POST['task_id']));
        die;
      }else if(!in_array($imageFileType, $valid_extensions)){
        echo json_encode(array('status'=>'error','message'=>$imageFileType,'sub_id'=>$_POST['task_id']));
        die;
      }else{
        $moved =  move_uploaded_file($tempname,$upload_path.''.$fileName);
        if( $moved ) {
          //unlink image
          $this->load->model('users');
          $currentUserId = $this->vendorId;
          $data = array('timesheet_id'=>$_POST['timesheet_id'],'emp_task_id'=>$_POST['empT_id'],'task_id'=>$_POST['task_id'],'parent_task'=>$_POST['parent_task'],'photo'=>$fileName,'uploaded_by'=>$currentUserId,'uploaded_at'=>date("Y-m-d H:i:s"));
          $id = $this->users->insertTaskPhoto($data);
          echo json_encode(array('status'=>'success','message'=>base_url().''.$upload_path.''.$fileName,'sub_id'=>$_POST['task_id'],'id'=>$id));die;
        }else{
          echo json_encode(array('status'=>'success','message'=>"Not uploaded because of error #".$_FILES["document_name"]["error"]));die;
        }
      } 
    }else{
      echo json_encode(array('status'=>'error','message'=>'Please select image','sub_id'=>$_POST['task_id']));
      die;
    }
  }
  public function ajax_deleteTaskPhoto()
  {
    $id = $_POST['id'];
    $this->db->query("DELETE FROM photos_tasks WHERE id=$id");
    $responseData = array('status'=>'success','msg'=>'Photo deleted');
    echo json_encode($responseData);
    die;
  }
  public function ajax_deleteProjTaskPhoto()
  {
    $id = $_POST['id'];
    $this->db->query("DELETE FROM photos_project_tasks WHERE id=$id");
    $responseData = array('status'=>'success','msg'=>'Photo deleted');
    echo json_encode($responseData);
    die;
  }
  public function leaves()
  {
    if($this->isTicketter() == TRUE)
    {
        $this->loadThis();
    }else{
      $this->load->model('users');
      $this->load->model('LeaveModel');
      $searchText = '';
      $count = $this->LeaveModel->LeaveCountAll($this->vendorId);
      $returns = $this->paginationCompress ( "Employee/leaves/", $count, 10 );
      $data['leaveRecords'] = $this->LeaveModel->leaveListingAll($returns["page"], $returns["segment"],$this->vendorId);
      $upcomingCount = $this->LeaveModel->upcomingLeaveCountAll(date('Y-m-d'));
      $ureturns = $this->paginationCompress ( "Employee/leaves/", $upcomingCount, 10 );
      $data['upcomingLeaveRecords'] = $this->LeaveModel->upcomingleaveListingAll($ureturns["page"], $ureturns["segment"],date('Y-m-d'));
      $pastCount = $this->LeaveModel->pastLeaveCountAll(date('Y-m-d'));
      $preturns = $this->paginationCompress ( "Employee/leaves/", $pastCount, 10 );
      $data['pastLeaveRecords'] = $this->LeaveModel->pastleaveListingAll($preturns["page"], $preturns["segment"],date('Y-m-d'));
      $data['currentUser'] = $this->users->getCurrentUser($this->vendorId);
      $data['title'] = 'Employee Leaves';
      $this->load->view('includes/header',$data);
      $this->load->view('admin/admin_emp_leaves.php');
    }
  }
  public function approveLeave($leaveId=NULL){
    $this->load->model('LeaveModel');
    $apprData = array('status' => 1,'approved_by'=>$this->vendorId,'leave_approve_date'=>date("Y-m-d H:i:s"));
    $this->LeaveModel->leaveAction($leaveId,$apprData);
    $leaveInfo = $this->LeaveModel->getLeaveInfo($leaveId);
    $emp_id = $leaveInfo[0]->emp_id;
    $empEmailQ = $this->db->query("SELECT email FROM users WHERE id=$emp_id");
    $empEmailR = $empEmailQ->result();
    $empEmail = $empEmailR[0]->email; 
    $this->load->library('email');
    $this->email->from('humanpixel.com.au', 'Geo Surv');
    $this->email->to($empEmail);

    $this->email->subject('Leave Approved');
    $this->email->set_mailtype("html");
    $leave_type = $leaveInfo[0]->leave_type_name;
    $leaveDays = 'From: '.date('d-m-Y',strtotime($leaveInfo[0]->leave_from_date)).' To: '.date('d-m-Y',strtotime($leaveInfo[0]->leave_to_date));
    $totalDays = $leaveInfo[0]->no_of_days;
    $apprvHtml = '<h4>Your leave application has been approved.Here are the details</h4><p>Leave Type: '.$leave_type.'</p><p>'.$leaveDays.'</p><p>Total Days: '.$totalDays.'</p>';
    $this->email->message($apprvHtml);

    $this->email->send();
    $this->session->set_flashdata('success', 'Leave has been approved successfully');
    redirect('Employee/leaves');
  }
  public function rejectLeave($leaveId=NULL){
    $this->load->model('LeaveModel');
    $apprData = array('status' => 2,'approved_by'=>$this->vendorId,'leave_approve_date'=>date("Y-m-d H:i:s"));
    $this->LeaveModel->leaveAction($leaveId,$apprData);
    $leaveInfo = $this->LeaveModel->getLeaveInfo($leaveId);
    $emp_id = $leaveInfo[0]->emp_id;
    $empEmailQ = $this->db->query("SELECT email FROM users WHERE id=$emp_id");
    $empEmailR = $empEmailQ->result();
    $empEmail = $empEmailR[0]->email; 
    $this->load->library('email');
    $this->email->from('humanpixel.com.au', 'Geo Surv');
    $this->email->to($empEmail);

    $this->email->subject('Leave Rejected');
    $this->email->set_mailtype("html");
    $leaveDays = 'from: '.date('d-m-Y',strtotime($leaveInfo[0]->leave_from_date)).' to: '.date('d-m-Y',strtotime($leaveInfo[0]->leave_to_date));
    $rejecHtml = '<h4>Your leave application '.$leaveDays.' has been rejected.</h4>';
    $this->email->message($rejecHtml);

    $this->email->send();
    $this->session->set_flashdata('success', 'Leave has been rejected successfully');
    redirect('Employee/leaves');
  }
  public function ajax_startTask()
  {
    $id = $_POST['id'];
    $parent_task = $_POST['parent_task'];
    $timesheetId = $_POST['timesheetId'];
    $this->load->model('timesheetsModel');
    $getTaskId = $this->timesheetsModel->getTaskIdByParentEntry($parent_task);
    $taskIdParent = $getTaskId[0]['task_id'];
    $getSubIds = $this->db->query("SELECT id FROM subtasks WHERE task_id=$taskIdParent");
    $subIds = $getSubIds->result_array();
    $SubIdAr = array();
    foreach($subIds as $subId){
      array_push($SubIdAr, $subId['id']);
    }
    $sub_ids = implode(',', $SubIdAr);
    $dayEntry = $this->timesheetsModel->empTaskDayEntry($timesheetId,$taskIdParent,$sub_ids);
    $taskStarted = 0;
    $date = date("Y-m-d H:i:s");
    $sTimHtml = 1;
    foreach($dayEntry as $vDEnt){
      //condition whether task is in progress
      if($vDEnt['start_task']==1 && $vDEnt['end_task']==0){
        $taskStarted = 1;
        break;
      }
    }
    foreach($dayEntry as $vDEnt){
      //condition whether any task is previously finished
      if($vDEnt['end_task']==1){
        $sTimHtml = 0;
        break;
      }
    }
    $error = '';
    if($sTimHtml==1)
      $this->db->query("UPDATE employee_tasks SET start_time='$date' WHERE id=$parent_task");
    if($taskStarted==0){
      $this->db->query("UPDATE employee_tasks SET start_task=1 WHERE id=$parent_task");
      $this->db->query("UPDATE employee_tasks SET start_task=1, start_time='$date' WHERE id=$id");
    }else{
      $error = 'Task already started for a day.Please end the previous task first and start again';
    }
    if($error==''){
      echo "true";
    }else{
      echo $error;
    }
  }
  public function ajax_endTask()
  {
    $id = $_POST['id'];
    $parent_task = $_POST['parent_task'];
    $projectId = $_POST['project_id'];
    $empId = $_POST['empId'];
    $clientId = $_POST['clientId'];
    $timesheetId = $_POST['timesheetId'];
    $this->load->model('timesheetsModel');
    $this->load->model('TimesheetentriesModel');
    $getTaskId = $this->timesheetsModel->getTaskIdByParentEntry($parent_task);
    $taskIdParent = $getTaskId[0]['task_id'];
    $getSubIds = $this->db->query("SELECT id FROM subtasks WHERE task_id=$taskIdParent");
    $subIds = $getSubIds->result_array();
    $SubIdAr = array();
    foreach($subIds as $subId){
      array_push($SubIdAr, $subId['id']);
    }
    $sub_ids = implode(',', $SubIdAr);
    $dayEntry = $this->timesheetsModel->empTaskDayEntry($timesheetId,$taskIdParent,$sub_ids);
    $taskFinsihed = 1;
    foreach($dayEntry as $vDEnt){
      if($vDEnt['start_task']==0 && $vDEnt['end_task']==0){
        $taskFinsihed = 0;
      }
    }
    $date = date("Y-m-d H:i:s");
    if($taskFinsihed==1){
      $this->db->query("UPDATE employee_tasks SET end_task=1,is_complete=1, end_time='$date' WHERE id=$parent_task");
    }
    $getStartTQ = $this->timesheetsModel->getStartTimeTask($id);
    $startTime = $getStartTQ[0]['start_time'];
    $subtaskId = $getStartTQ[0]['task_id'];
    $total_duration = strtotime(date("Y-m-d H:i:s")) - strtotime($startTime);
    $getTotalDurQ = $this->timesheetsModel->getStartTimeTask($parent_task);
    $taskId = $getTotalDurQ[0]['task_id'];
    $parent_total_duration = $getTotalDurQ[0]['total_duration'];
    $parent_total_duration += $total_duration;
    $this->db->query("UPDATE employee_tasks SET partial_complete=1,start_task=0,total_duration=$parent_total_duration WHERE id=$parent_task");
    $this->db->query("UPDATE employee_tasks SET start_task=0,end_task=1,is_complete=1, end_time='$date',total_duration=$total_duration WHERE id=$id");
    //send record to timesheet
    $dataSchedule = array('employee_id'=>$empId,'project_id'=>$projectId,'client_id'=>$clientId, 'task_id'=>$taskId, 'subtask_id'=>$subtaskId,'start_date'=>date('Y-m-d',strtotime($startTime)), 'time_from'=>date('H:i:s',strtotime($startTime)),'time_to'=>date('H:i:s'),'end_date'=>date('Y-m-d'), 'time_entry_duration'=>$total_duration,'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
   //Inseter into shcedule table
  $result = $this->TimesheetentriesModel->addTimesheetEntry($dataSchedule);
    echo "true";
  }
  public function ajax_startProjTask()
  {
    $id = $_POST['id'];
    $date = date("Y-m-d H:i:s");
    $this->db->query("UPDATE employee_project_tasks SET start_task=1, start_time='$date' WHERE id=$id");
    echo "true";
  }
  public function ajax_endProjTask()
  {
    $id = $_POST['id'];
    $sch_date = $_POST['sch_date'];
    $projectId = $_POST['project_id'];
    $empId = $_POST['empId'];
    $clientId = $_POST['clientId'];
    $timesheetId = $_POST['timesheetId'];
    $this->load->model('timesheetsModel');
    $this->load->model('TimesheetentriesModel');
    $date = date("Y-m-d H:i:s");
    $getStartTQ = $this->timesheetsModel->getStartTimeProTask($id);
    $startTime = $getStartTQ[0]['start_time'];
    $taskId = $getStartTQ[0]['task_id'];
    $total_duration = strtotime(date("Y-m-d H:i:s")) - strtotime($startTime);
    $this->db->query("UPDATE employee_project_tasks SET start_task=0,end_task=1,is_complete=1, end_time='$date',total_duration=$total_duration WHERE id=$id");
    //send record to timesheet
    $dataSchedule = array('employee_id'=>$empId,'project_id'=>$projectId,'client_id'=>$clientId, 'project_task_id'=>$taskId,'start_date'=>date('Y-m-d',strtotime($startTime)), 'time_from'=>date('H:i:s',strtotime($startTime)),'time_to'=>date('H:i:s'),'end_date'=>date('Y-m-d'), 'time_entry_duration'=>$total_duration,'created_by'=>$this->vendorId, 'created_at'=>date('Y-m-d H:i:s'));
   //Inseter into shcedule table
  $result = $this->TimesheetentriesModel->addTimesheetEntry($dataSchedule);
    echo "true";
  }
}
?>