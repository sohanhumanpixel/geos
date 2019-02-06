<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class project_type extends CI_Model {
	function getPList(){
		$this->db->select('id, project_type_name');
        $this->db->from('project_type');
		$this->db->order_by("id", "asc");
        $query = $this->db->get();
        return $query->result();
	}
    function getProjectsNames(){
        $this->db->select('id, project_name');
        $this->db->from('projects');
        $this->db->where('isDeleted',0);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        return $query->result();
    }
	function getInductions(){
		$this->db->select('id, name');
        $this->db->from('online_induction');
        $query = $this->db->get();
        return $query->result();
	}
	function addNewProject($data){
        $this->db->insert('projects', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
	}
	function projectCount($searchText = '')
    {
         $this->db->select('p.id');
        $this->db->from('projects as p');
        $this->db->join('companies as c', 'p.client_id = c.id','left');
        $this->db->where('p.isDeleted',0);
        $query = $this->db->get();
        return count($query->result());
    }
    public function getProjects($searchText = '', $page, $segment) {
        $this->db->select("p.*, c.company_name,u.fname as firstname,u.lname as lastname");
        $this->db->from("projects as p");
        $this->db->join('companies as c', 'p.client_id = c.id','left');
        $this->db->join('users as u', 'p.project_manager_id = u.id','left');
        $this->db->where('p.isDeleted',0);
        $this->db->order_by("p.id", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }
    public function getProjectById($id) {
        $this->db->select("*");
        $this->db->from("projects");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function editProject($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('projects', $data);
        
        return TRUE;
    }
    public function deleteProject($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('projects', $data);
        return $this->db->affected_rows();
    }
    function getLiveProjects($k, $id){
        $this->db->select('id, project_name');
        $this->db->from('projects');
        $this->db->where("client_id", $id);
        $this->db->where("isDeleted", 0);
        $this->db->where("project_name LIKE '%$k%'");
        $query = $this->db->get();
        return $query->result();
    }
    function getProjectsByClient($cid)
    {
        $query = $this->db->query("SELECT id, project_name FROM projects WHERE client_id=$cid AND isDeleted=0");
        $projects = $query->result_array();
        $html = '';
        foreach($projects as $project){
            $html .= '<option value="'.$project['id'].'">'.$project['project_name'].'</option>';
        }
        return $html;
        die;
    }
    function IsExcludedFilter($emp_id, $projects)
    {
        $this->db->select('project_id');
        $this->db->from('excluded_projects');
        $this->db->where("employee_id", $emp_id);
        $query = $this->db->get();
        $result = $query->result();
        if(!empty($result)){
            $project_ids = $result[0]->project_id;
            $project_ids = explode(',', $project_ids);
            $newPrjAr = array();
            foreach($projects as $k=>$project){
                $project_id = $project->id;
                if(in_array($project_id, $project_ids)){
                    unset($projects[$k]);
                }else{
                    array_push($newPrjAr, $project);
                }
                
            }
            echo json_encode($newPrjAr);
        }else{
            echo json_encode($projects);
        }
        die;   
    }
    public function getCompletedTaskPerProject($project_id,$employee_id=0)
    {
        $query = $this->db->query("SELECT task_ids FROM projects WHERE id=$project_id");
        $result = $query->result_array();
        $task_ids = $result[0]['task_ids'];
        $task_ids = explode(',', $task_ids);
        $reqrArr = array();
        $emplCond = '';
        if($employee_id!=0){
            $emplCond = ' AND employee_id='.$employee_id;
        }
        foreach($task_ids as $task_id){
            $q = $this->db->query("SELECT et.id as emp_tId,et.schedule_date,et.is_complete,et.partial_complete,t.id as task_id,t.title,t.abbr,CONCAT(u.fname,' ',u.lname) as employee_name FROM employee_tasks as et LEFT JOIN tasks as t ON et.task_id=t.id LEFT JOIN users as u ON et.employee_id=u.id WHERE et.task_id=$task_id AND et.parent_task=0 AND et.project_id=$project_id AND (et.is_complete=1 OR et.partial_complete=1)".$emplCond);
            $r = $q->result_array();
            if(!empty($r)){
                array_push($reqrArr, $r);
            }
        }
        $arraNew = array();
        foreach($reqrArr as $k=>$v){
            foreach($v as $val){
                array_push($arraNew, $val);
            }
        }
        return $arraNew;
    }

    public function getIncompletedTaskPerProject($project_id,$employee_id=0)
    {
        $query = $this->db->query("SELECT task_ids FROM projects WHERE id=$project_id");
        $result = $query->result_array();
        $task_ids = $result[0]['task_ids'];
        $task_ids = explode(',', $task_ids);
        $reqrArr = array();
        $emplCond = '';
        if($employee_id!=0){
            $emplCond = ' AND employee_id='.$employee_id;
        }
        foreach($task_ids as $task_id){
            $q = $this->db->query("SELECT et.id as emp_tId,et.schedule_date,t.id as task_id,t.title,t.abbr,CONCAT(u.fname,' ',u.lname) as employee_name FROM employee_tasks as et LEFT JOIN tasks as t ON et.task_id=t.id LEFT JOIN users as u ON et.employee_id=u.id WHERE et.task_id=$task_id AND et.parent_task=0 AND et.project_id=$project_id AND et.is_complete=0".$emplCond);
            $r = $q->result_array();
            if(!empty($r)){
                array_push($reqrArr, $r);
            }
        }
        $arraNew = array();
        foreach($reqrArr as $k=>$v){
            foreach($v as $val){
                array_push($arraNew, $val);
            }
        }
        return $arraNew;
    }

    public function getCompletedProjectTask($project_id,$employee_id=0)
    {
        $this->db->select("et.id as emp_tId,et.schedule_date,et.is_complete,t.id as task_id,t.title,CONCAT(u.fname,' ',u.lname) as employee_name");
        $this->db->from("employee_project_tasks as et");
        $this->db->join("tasks_project as t","t.id=et.task_id","left");
        $this->db->join("users as u","u.id=et.employee_id","left");
        $this->db->where("et.project_id",$project_id);
        $this->db->where("et.is_complete",1);
        if($employee_id!=0){
            $this->db->where("et.employee_id",$employee_id);
        }
        $this->db->order_by("et.schedule_date", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getIncompletedProjectTask($project_id,$employee_id=0)
    {
        $this->db->select("et.id as emp_tId,et.schedule_date,et.is_complete,t.id as task_id,t.title,CONCAT(u.fname,' ',u.lname) as employee_name");
        $this->db->from("employee_project_tasks as et");
        $this->db->join("tasks_project as t","t.id=et.task_id","left");
        $this->db->join("users as u","u.id=et.employee_id","left");
        $this->db->where("et.project_id",$project_id);
        $this->db->where("et.is_complete",0);
        if($employee_id!=0){
            $this->db->where("et.employee_id",$employee_id);
        }
        $this->db->order_by("et.schedule_date", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function getProjectsByClientInData($cid)
    {
        $query = $this->db->query("SELECT id, project_name FROM projects WHERE client_id=$cid AND isDeleted=0");
        $projects = $query->result_array();
        return json_encode($projects);
    }
    public function getTasksProject($id)
    {
        $this->db->select("t.id,t.title,t.description,CONCAT(u.fname,' ',u.lname) as full_name");
        $this->db->from("tasks_project as t");
        $this->db->join("users as u","u.id=t.created_by","left");
        $this->db->where("t.project_id",$id);
        $this->db->order_by("t.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function addTasksProject($data)
    {
        $this->db->insert('tasks_project', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function deleteTasksProject($id)
    {
        $this->db->where("id",$id);
        $this->db->delete('tasks_project');
        return true;
    }
    public function saveTasksProject($data,$id)
    {
        $this->db->where("id",$id);
        $this->db->update('tasks_project', $data);
        return true;
    }
    function categoryCount($searchText = '')
    {
        $this->db->select('id');
        $this->db->from('project_categories');
        $query = $this->db->get();
        return count($query->result());
    }
    public function getCategories($searchText = '', $page, $segment)
    {
        $this->db->select("c.*,u.fname,u.lname");
        $this->db->from("project_categories as c");
        $this->db->join("users as u","u.id=c.created_by","left");
        $this->db->limit($page, $segment);
        $this->db->order_by("c.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function addNewCategory($data)
    {
        $this->db->insert('project_categories', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
    public function getCategoryById($catId)
    {
        $this->db->select("*");
        $this->db->from("project_categories");
        $this->db->where("id",$catId);
        $query = $this->db->get();

        return $query->result();
    }
    public function editCategory($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('project_categories', $data);
        
        return TRUE;
    }
    public function deleteCategory($id)
    {
        $this->db->where("id",$id);
        $this->db->delete('project_categories');
        return true;
    }
    function stateCount($searchText = '')
    {
        $this->db->select('id');
        $this->db->from('project_states');
        $query = $this->db->get();
        return count($query->result());
    }
    public function getStates($searchText = '', $page, $segment)
    {
        $this->db->select("s.*,u.fname,u.lname");
        $this->db->from("project_states as s");
        $this->db->join("users as u","u.id=s.created_by","left");
        $this->db->limit($page, $segment);
        $this->db->order_by("s.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function addNewState($data)
    {
        $this->db->insert('project_states', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
    public function getStateById($stateId)
    {
        $this->db->select("*");
        $this->db->from("project_states");
        $this->db->where("id",$stateId);
        $query = $this->db->get();

        return $query->result();
    }
    public function editState($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('project_states', $data);
        
        return TRUE;
    }
    public function deleteState($id)
    {
        $this->db->where("id",$id);
        $this->db->delete('project_states');
        return true;
    }
    function jobTempCount($searchText = '')
    {
        $this->db->select('id');
        $this->db->from('job_templates');
        $query = $this->db->get();
        return count($query->result());
    }
    public function getJobTempBriefs($searchText = '', $page, $segment)
    {
        $this->db->select("t.*,u.fname,u.lname,c.category_name");
        $this->db->from("job_templates as t");
        $this->db->join("users as u","u.id=t.created_by","left");
        $this->db->join("project_categories as c","c.id=t.category_id","left");
        $this->db->limit($page, $segment);
        $this->db->order_by("t.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function addNewJobTemplate($data)
    {
        $this->db->insert('job_templates', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
    public function getJobTemplateById($templateId)
    {
        $this->db->select("*");
        $this->db->from("job_templates");
        $this->db->where("id",$templateId);
        $query = $this->db->get();

        return $query->result();
    }
    public function editJobTemplate($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('job_templates', $data);
        
        return TRUE;
    }
    public function deleteJobTemplate($id)
    {
        $this->db->where("id",$id);
        $this->db->delete('job_templates');
        return true;
    }
    public function getAllCategories()
    {
        $this->db->select("*");
        $this->db->from("project_categories");
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllStates()
    {
        $this->db->select("*");
        $this->db->from("project_states");
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function projectTypeCount($searchText = '')
    {
        $this->db->select('id');
        $this->db->from('project_type');
        $query = $this->db->get();
        return count($query->result());
    }
    public function getProjectTypes($searchText = '', $page, $segment)
    {
        $this->db->select("*");
        $this->db->from("project_type");
        $this->db->limit($page, $segment);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function addNewProjectType($data)
    {
        $this->db->insert('project_type', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
    public function getProjectTypeById($id)
    {
        $this->db->select("*");
        $this->db->from("project_type");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function editProjectType($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('project_type', $data);
        
        return TRUE;
    }
    public function deleteProjectType($id)
    {
        $this->db->where("id",$id);
        $this->db->delete('project_type');
        return true;
    }
    public function getProjectTasksByProjectId($projId)
    {
        $this->db->select("id,title");
        $this->db->from("tasks_project");
        $this->db->where("project_id",$projId);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function getAllJobTemplates()
    {
        $this->db->select("*");
        $this->db->from("job_templates");
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function insertSubbyPack($data)
    {
        $this->db->insert('subby_templates', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
    public function getProjectTaskById($id) 
    {
        $this->db->select("*");
        $this->db->from("tasks_project");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
}
?>