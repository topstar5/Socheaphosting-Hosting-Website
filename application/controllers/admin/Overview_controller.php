<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Overview_controller extends CI_Controller {
/*
|--------------------------------------
| constructor function
|--------------------------------------
*/
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');
		 $session_id = $this->session->userdata('session_id'); 
	    if($session_id == NULL ){
	     redirect('logout');
	    }
	}
/*
|--------------------------------------
| 
|--------------------------------------
*/
	public function index()
	{
		$this->load->view('admin/_header');
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/_deshbord');
		$this->load->view('admin/_footer');
	}
}