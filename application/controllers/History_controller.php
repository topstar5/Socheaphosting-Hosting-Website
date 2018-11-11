<?php defined('BASEPATH') OR exit('No direct script access allowed');

class History_controller extends CI_Controller {

/*
|-----------------------------------------------
|	 Constructor funcion
|-----------------------------------------------
*/
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');	
		$session_id = $this->session->userdata('session_id');	
	    
	    if($session_id == NULL ) {
	     redirect('logout');
	    }
	}
/*
|-----------------------------------------------
|	 patient_history funcion
|-----------------------------------------------
*/	
	public function patient_history($patient_id)
	{
		
		$data['p_info'] = $this->db->select('*')
		->from('patient_tbl')
		->where('patient_id',$patient_id)
		->get()
		->row();

		 $this->db->select("prescription.*,
             doctor_tbl.*");

         $this->db->from("prescription");
         $this->db->join('doctor_tbl', 'doctor_tbl.doctor_id = prescription.doctor_id '); 
         $this->db->where('prescription.patient_id',$patient_id);
         $query = $this->db->get();
         $result = $query->result();
    	 $data['app_info'] = $result;
		 $this->load->view('public/viewPatientHistory',$data);

	}
/*
|-----------------------------------------------
|	 search_patient
|-----------------------------------------------
*/	
	public function search_patient($search=NULL)
	{
		if(!empty($search)) {
			 	$keyword = $_GET['keyword'];
			 	// test query
	            $data['p_info'] = $this->db->select('*')
	            ->from('patient_tbl')
	            ->or_like('patient_name', $keyword)
				->or_like('birth_date', $keyword)
				->or_like('patient_phone', $keyword)
	            ->get()
	            ->result();
			    $this->load->view('Backend/header',$data);
				$this->load->view('Backend/left_sideber');
				$this->load->view('Backend/view_patient_search_list');
				$this->load->view('Backend/footer');
			} else {
				$this->load->view('Backend/header');
				$this->load->view('Backend/left_sideber');
				$this->load->view('Backend/patient_search_form');
				$this->load->view('Backend/footer');
			}
	}


}

