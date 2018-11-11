<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Treatment_model extends CI_model {



/*

|------------------------------------------------

|   insert_treatment_name to treatment_tbl

|------------------------------------------------

*/

	public function insert_treatment($tesAdd)

	{

		$this->db->insert('treatment_tbl', $tesAdd);

	}

/*

|------------------------------------------------

|   get_treatment_name form treatment_tbl

|------------------------------------------------

*/

	public function get_treatments()

	{

		return $query = $this->db->select('*')->from('treatment_tbl')->get()->result();

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