<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Announcements extends CI_Model {
	public function addAnnouncement($data) {
        $this->db->insert('announcements', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
    public function getAnnouncements($searchText = '', $page, $segment) {
        $this->db->select("ann.id,ann.subject,ann.message,ann.view,ann.active, User.fname,User.lname");
        $this->db->from("announcements as ann");
        $this->db->join('users as User', 'User.id = ann.created_by','left');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }
    public function getAnns($access) {
        $this->db->select("*");
        $this->db->from("announcements");
        $this->db->where('active',1);
        if($access!="")
        $this->db->where('view',$access);
        $query = $this->db->get();

        return $query->result();
    }
    public function getAnnouncementsById($id) {
        $this->db->select("*");
        $this->db->from("announcements");
        $this->db->where("id",$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function updateAnnouncement($data,$id) {
        $this->db->where('id', $id);
        $this->db->update('announcements', $data);
        
        return TRUE;
    }
    public function deleteAnnouncement($id){
        $this->db->where('id',$id);
        $this->db->delete('announcements');
        return TRUE;
    }
    function AnnouncementCount($searchText = '')
    {
         $this->db->select('ann.id');
        $this->db->from('announcements as ann');
        $this->db->join('users as User', 'User.id = ann.created_by','left');
        /*if(!empty($searchText)) {
            $likeCriteria = "(GroupTbl.group_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }*/
        $query = $this->db->get();
        
        return count($query->result());
    }
    public function getUserRole($id){
        $this->db->select("u.id,r.role_name");
        $this->db->from("users as u");
        $this->db->join('user_roles as r', 'u.role_id = r.id','left');
        $this->db->where('u.id',$id);
        $query = $this->db->get();

        return $query->result();
    }
    public function activeStatus($id){
        $this->db->where('id',$id);
        $this->db->update('announcements',array('active'=>1));
        return TRUE;
    }
    public function inactiveStatus($id){
        $this->db->where('id',$id);
        $this->db->update('announcements',array('active'=>0));
        return TRUE;
    }
}
?>