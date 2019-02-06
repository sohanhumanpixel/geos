<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class task_list extends CI_Model
{
	function addNewTask($data)
	{
        $this->db->insert('tasks', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
	}
	function taskCount($searchText = '')
    {
        $this->db->select('id');
        $this->db->from('tasks');
        $this->db->where('is_deleted',0);
        $query = $this->db->get();
        return count($query->result());
    }
    public function getTasks($searchText = '', $page, $segment) 
    {
        $this->db->select("t.*,u.fname as firstname,u.lname as lastname");
        $this->db->from("tasks as t");
        $this->db->join('users as u', 't.created_by = u.id','left');
        $this->db->where('t.is_deleted',0);
        $this->db->order_by("t.id", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }
    public function getTaskById($id) 
    {
        $this->db->select("*");
        $this->db->from("tasks");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function editTask($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tasks', $data);
        
        return TRUE;
    }
    public function deleteTask($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tasks', $data);
        return $this->db->affected_rows();
    }
    public function getTaskName($id)
    {
    	$this->db->select("id,title,abbr");
        $this->db->from("tasks");
        $this->db->where("id",$id);
        $this->db->where("is_deleted",0);
        $query = $this->db->get();

        return $query->result();
    }
    function addNewSubTask($data)
    {
        $this->db->insert('subtasks', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
	}
	function subTaskCount($searchText='',$id)
	{
		$this->db->select("id,COUNT(id) as count");
        $this->db->from("subtasks");
        $this->db->where("task_id",$id);
        $this->db->where("is_deleted",0);
        $query = $this->db->get();
        $result = $query->result();
        //echo "<pre>";print_r($result[0]->count);echo "</pre>";
        return $result[0]->count;
	}
    function getSubTasks($searchText = '', $id, $page, $segment) 
    {
        $this->db->select("st.*,t.title as taskTitle,t.abbr as taskAbbr,u.fname as firstname,u.lname as lastname");
        $this->db->from("subtasks as st");
        $this->db->join('users as u', 'st.created_by = u.id','left');
        $this->db->join('tasks as t', 'st.task_id = t.id','left');
        $this->db->where('st.task_id',$id);
        $this->db->where('st.is_deleted',0);
        $this->db->order_by("st.id", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }
    public function getSubTaskById($id) 
    {
        $this->db->select("*");
        $this->db->from("subtasks");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function editSubTask($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('subtasks', $data);
        
        return TRUE;
    }
    public function deleteSubTask($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('subtasks', $data);
        return $this->db->affected_rows();
    }
    public function getTaskIDBySubTaskID($id)
    {
        $this->db->select("task_id");
        $this->db->from("subtasks");
        $this->db->where("id",$id);
        $query = $this->db->get();

        $result = $query->result();
        return $result[0]->task_id;
    }
    public function countTaskByEmpId($id)
    {
        $this->db->select('id');
        $this->db->from('tasks');
        $this->db->where('is_deleted',0);
        $this->db->where('employee_id',$id);
        $query = $this->db->get();
        return count($query->result());
    }
    public function getAllTasks() 
    {
        $this->db->select("*");
        $this->db->from("tasks");
        $this->db->where('is_deleted',0);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();

        return $query->result();
    }

    public function addFixedPrice($task_id)
    {
        $this->db->select("SUM(fixed_price) as total_fixed_price");
        $this->db->from("subtasks");
        $this->db->where('is_deleted',0);
        $this->db->where('task_id',$task_id);
        $query = $this->db->get();

        $result = $query->result();
        return $result[0]->total_fixed_price;
    }

    public function addHourlyRatePrice($task_id)
    {
        $this->db->select("SUM(hourly_rate) as total_hourly_rate");
        $this->db->from("subtasks");
        $this->db->where('is_deleted',0);
        $this->db->where('task_id',$task_id);
        $query = $this->db->get();

        $result = $query->result();
        return $result[0]->total_hourly_rate;
    }
}