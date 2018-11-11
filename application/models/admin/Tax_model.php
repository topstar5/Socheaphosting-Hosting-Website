<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_model extends CI_model {



/*

|------------------------------------------------

|   insert_tax_name to tax_tbl

|------------------------------------------------

*/

	public function insert_tax($tesAdd)

	{

		$this->db->insert('tax_tbl', $tesAdd);

	}

/*

|------------------------------------------------

|   get_tax_name form tax_tbl

|------------------------------------------------

*/

	public function get_taxs()

	{

		return $query = $this->db->select('*')->from('tax_tbl')->get()->result();

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