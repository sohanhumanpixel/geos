<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DocumentModel extends CI_Model {
	
	
	function documentCount()
    {
        $this->db->select('document.id');
        $this->db->from('document');
        $query = $this->db->get();
        return count($query->result());
    }
	
	/**
	 *fetch all documents
	 *created date; 15-10-2018
	 *created by: Humanpixel
	 */
	 
	 function getDocuments($page, $segment){
		$this->db->select("*");
        $this->db->from("document");
        $this->db->limit($page, $segment);
        $query = $this->db->get();
		return $query->result();
	 }
	
	/**
	 *Add Schedule data
	 *date; 15 OCT, 2018
	 */
	 function addDocument($scheduleData){
		 $this->db->insert('document', $scheduleData);
		 $insert_id = $this->db->insert_id();
		 return $insert_id;
	 }
	 
	/**
	  *Get get Document data by Id
	  *date: 18-10-2018
	 */
	function getDocumentById($documentId){
		$this->db->select("*");
        $this->db->from("document");
		$this->db->where('id', $documentId);
		$query = $this->db->get();
        return $query->result();
	}
	
	/**
	 *@update schedule data from here
	 */
	 function editDocument($editSdata, $schId){
		$this->db->where('id', $schId);
		$updateSt = $this->db->update('document',$editSdata);
		return $updateSt;
	 }
	 
	public function deleteDocument($id){
		//before delete get file name and unlink
        $this->db->where('id', $id);
        $this->db->delete('document');
        return $this->db->affected_rows();
    }
	
}
?>