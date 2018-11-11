<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Disease_test_model extends CI_model {

/*
|------------------------------------------------
|   insert_test_name to test_name_tbl
|------------------------------------------------
*/
	public function insert_test_name($tesAdd)
	{
		$this->db->insert('test_name_tbl', $tesAdd);
	}
/*
|------------------------------------------------
|   get_test_name form test_name_tbl
|------------------------------------------------
*/
	public function get_test_name()
	{
		return $query = $this->db->select('*')->from('test_name_tbl')->get()->result();
	}
/*
|------------------------------------------------
|   get prescription comments form prescription_comments
|------------------------------------------------
*/
	public function get_p_comments($appointment_id)
	{

		return $query = $this->db->select('*')
		->from('prescription_comments')
		->where('appointment_id',$appointment_id)
		->get()->row();
	}
/*
|------------------------------------------------
|   get_medicine_info  form medecine_info
|------------------------------------------------
*/
	public function get_medicine_info()
	{
		return $query = $this->db->select('*')
		->from('medecine_info')
		->get()
		->result();
	}

	
}