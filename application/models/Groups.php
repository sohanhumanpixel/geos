<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Groups extends CI_Model {
	/**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function groupListingCount($searchText = '')
    {
         $this->db->select('GroupTbl.id');
        $this->db->from('groups as GroupTbl');
        $this->db->join('users as User', 'User.id = GroupTbl.created_by','left');
        /*if(!empty($searchText)) {
            $likeCriteria = "(GroupTbl.group_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }*/
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	 /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
	 * @created at: 29-09-2018
     */
    function GroupListing($searchText = '', $page, $segment)
    {
        $this->db->select('GroupTbl.id as groupId, GroupTbl.group_name, GroupTbl.created_by, GroupTbl.created_at, User.fname,User.lname');
        $this->db->from('groups as GroupTbl');
        $this->db->join('users as User', 'User.id = GroupTbl.created_by','left');
        /*if(!empty($searchText)) {
            $likeCriteria = "(GroupTbl.group_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }*/
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	
    /**
	 * method name: addNewGroup
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
	 * @author: Sohan
	 * @created_date	: 29-09-2018
     */
    function addNewGroup($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('groups', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	/**
     * This function used to get user information by id
     * @param number $groupId : This is user id
     * @return array $result : This is user information
     */
    function getGroupInfo($groupId)
    {
        $this->db->select('id, group_name');
        $this->db->from('groups');
        $this->db->where('id', $groupId);
        $query = $this->db->get();
        
        return $query->result();
    }
	/**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $groupId : This is user id
     */
    function updateGroup($groupInfo, $groupId)
    {
        $this->db->where('id', $groupId);
        $this->db->update('groups', $groupInfo);
        
        return TRUE;
    }
	function deleteGroup($groupId)
    {
        $this->db->where('id', $groupId);
		return $this->db->delete('groups');
		
    }
}
?>