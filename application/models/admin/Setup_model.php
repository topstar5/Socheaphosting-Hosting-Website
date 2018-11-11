<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_model extends CI_model {


/*
|------------------------------------------------
|    
|------------------------------------------------
*/
 public function getCompanyInfo()
 {
 	return	$this->db->select('*')
 	->from('medicine_company_info')
 	->get()
 	->result();
 }
/*
|------------------------------------------------
|    
|------------------------------------------------
*/
 public function getGroupInfo()
 {
 	return	$result = $this->db->select('*')
 	->from('medicine_group_tbl')
 	->get()
 	->result();
 }
/*
|------------------------------------------------
|    
|------------------------------------------------
*/
 public function getMedicineCompanyInfo()
 {
 	return	$this->db->select('*')
 	->from('medicine_company_info')
 	->get()
 	->result();
 }

 
/*
|------------------------------------------------
|    
|------------------------------------------------
*/
 public function getMedicineList()
 {
 	
	$create_by = $this->session->userdata('doctor_id');
	$this->db->select("medecine_info.*,
   		medicine_company_info.*,
   		medicine_group_tbl.*");

         $this->db->from("medecine_info");
         $this->db->join('medicine_company_info', 'medicine_company_info.company_id= medecine_info.med_company_id'); 
         $this->db->join('medicine_group_tbl', 'medicine_group_tbl.med_group_id= medecine_info.med_group_id'); 
	     $query = $this->db->get();
	     return $result = $query->result();
 }


/*
|------------------------------------------------
|    
|------------------------------------------------
*/
public function getMedicineOne($id)
{
	$this->db->select("medecine_info.*,
	medicine_company_info.*,
	medicine_group_tbl.*");

	$this->db->from("medecine_info");
	$this->db->join('medicine_company_info', 'medicine_company_info.company_id= medecine_info.med_company_id'); 
	$this->db->join('medicine_group_tbl', 'medicine_group_tbl.med_group_id= medecine_info.med_group_id'); 
 	$this->db->where('medicine_id',$id);
 	$query = $this->db->get();
  	return $result= $query->row();
}
 	

} 	 