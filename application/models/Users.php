<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Model {
	
	/**
	 * User login
	 */
	
	 public function login($data) {
      $condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . md5($data['password']) . "'";
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where($condition);
      $this->db->limit(1);
      $query = $this->db->get();
      if ($query->num_rows() == 1) {
		return $query->result();
      } else {
      return false;
      }
    }

	 /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.email, BaseTbl.fname, BaseTbl.lname, Role.role_name');
        $this->db->from('users as BaseTbl');
        $this->db->join('user_roles as Role', 'Role.id = BaseTbl.role_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.fname  LIKE '%".$searchText."%'
                            OR  BaseTbl.lname  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.role_id !=', 1);
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	 /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
	 * @created at: 28-09-2018
     */
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.id as userId, BaseTbl.email, BaseTbl.fname, BaseTbl.lname, BaseTbl.username, Role.role_name');
        $this->db->from('users as BaseTbl');
        $this->db->join('user_roles as Role', 'Role.id = BaseTbl.role_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.fname  LIKE '%".$searchText."%'
                            OR  BaseTbl.lname  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.role_id !=', 1);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	
    /**
	 * method name: addNewUser
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
	 * @author: Sohan
	 * @created_date	: 28-09-2018
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function checkUsernameExists($username, $userId = 0)
    {
        $this->db->select("username");
        $this->db->from("users");
        $this->db->where("username", $username);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	
	/*
	 *@method: getUserRoles
	 */
	 
	 function getUserRoles(){
		$this->db->select('id as roleId, role_name');
        $this->db->from('user_roles');
        $query = $this->db->get();
        return $query->result();
	 }
	 
	 /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', $userInfo);
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('id, fname, lname, email, username, role_id');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('id', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }
	/**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', $userInfo);
        
        return TRUE;
    }
	
	
/**
 * @method	:		logout
 * @purpose	:	logut to user and destroy session
 * @author : Humanpixel
 * @since : 27 Sep 2018
 * @not used now
 */
	public function logout(){
	}
}
?>