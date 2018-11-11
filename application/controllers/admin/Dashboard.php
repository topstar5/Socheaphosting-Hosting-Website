<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

#------------------------------------------------
#       constructor function
#------------------------------------------------
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');
		$session_id = $this->session->userdata('session_id'); 
		$session_id = $this->session->userdata('user_type'); 

	    if($session_id == NULL ) {
	     redirect('logout');
	    }

	    $this->load->model('admin/Overview_model','overview_model');
	}
#------------------------------------------------
#       view home page form
#------------------------------------------------
	public function index()
	{
		 $data['title'] = "Dashboard";
		 
		 $data['last_30'] = $this->overview_model->last_30(); 
		 $data['last_15'] = $this->overview_model->last_15(); 
		 $data['last_7'] = $this->overview_model->last_7(); 
		 
		 //patient
		 $data['patient_30_day'] = $this->overview_model->patient_30_day();
		 $data['patient_15_day'] = $this->overview_model->patient_15_day();
		 $data['patient_7_day'] = $this->overview_model->patient_7_day();
		 
		 //precription
		 $data['total_prescription'] = $this->overview_model->total_prescription();
		 $data['today_prescription'] = $this->overview_model->today_prescription();
		 // sms
		 $data['total_sms'] = $this->overview_model->total_sms();
		 $data['today_sms'] = $this->overview_model->today_sms();
		 $data['auto_sms'] = $this->overview_model->auto_sms();
		 $data['coustom_sms'] = $this->overview_model->coustom_sms();
		 
		 // patient
		 $data['today_patient'] = $this->overview_model->today_patient();
		 $data['total_patient'] = $this->overview_model->total_patient();
		 // appointment
		 $data['to_day_appointment'] = $this->overview_model->to_day_appointment();
		 $data['to_day_get_appointment'] = $this->overview_model->to_day_get_appointment();
		 $data['total_appointment'] = $this->overview_model->total_appointment();
		 $data['total_email'] = $this->overview_model->email_list();
		
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/_deshboard');
		$this->load->view('admin/_footer');
	}

}