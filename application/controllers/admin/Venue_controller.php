<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Venue_Controller extends CI_Controller {
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

	    $this->load->model('admin/Venue_model','venue_model');
	}
/*
|-----------------------------------------------
|	 create_new_venue
|-----------------------------------------------
*/
	public function create_new_venue()
	{
		$data['title'] = "Create New Venue";
		$this->load->view('admin/_header');
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_create_venue');
		$this->load->view('admin/_footer');
	}
/*
|-----------------------------------------------
|	 venue_list
|-----------------------------------------------
*/	
	public function venue_list()
	{
		$data['title'] = "Venue List";
		$data['venue_info'] = $this->venue_model->get_venue_list();
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_venue_list');
		$this->load->view('admin/_footer');
	}

/*
|-----------------------------------------------
|	 edit_venue
|-----------------------------------------------
*/

	public function edit_venue($id)
	{
		$data['title'] = "Edit Venue";
		$data['venue_info'] = $this->venue_model->get_inde_venue($id);
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_edit_venue');
		$this->load->view('admin/_footer');
	}

/*
|-----------------------------------------------
|	 save_add_venue
|-----------------------------------------------
*/
    public function save_add_venue()
    {

	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('address', 'Address', 'trim|required');
	    $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[9]|max_length[15]');
	      
	    if ($this->form_validation->run()==true) {
		        $savedata['create_id'] = $this->session->userdata('doctor_id');
		        $savedata['venue_name'] = $this->input->post('name',TRUE); 
		        $savedata['venue_contact'] = $this->input->post('phone',TRUE);
		        $savedata['venue_address'] = $this->input->post('address',TRUE);
		        $savedata['venue_map'] = $this->input->post('venue_map',FALSE);
		       $this->venue_model->save_venue($savedata);
		       $this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('venue_add_msg').'</div>');
		       redirect('admin/Venue_controller/create_new_venue');

	    } else {
		    $this->load->view('admin/_header');
			$this->load->view('admin/_left_sideber');
			$this->load->view('admin/view_create_venue');
			$this->load->view('admin/_footer');
	    }
             
    }

/*
|-----------------------------------------------
|	save_edit_venue
|-----------------------------------------------
*/
    public function save_edit_venue()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[9]|max_length[15]');
              
        if ($this->form_validation->run()==true) {
            $savedata['create_id'] = $this->session->userdata('doctor_id');
            $savedata['venue_name'] = $this->input->post('name',TRUE); 
            $savedata['venue_contact'] = $this->input->post('phone',TRUE);
            $savedata['venue_address'] = $this->input->post('address',TRUE);
            $savedata['venue_map'] = $this->input->post('venue_map',FALSE);

           $this->venue_model->save_edit_venue($savedata,$id);
           
           $this->session->set_flashdata('message','<div class="alert alert-success msg"><a href="#" class="close" data-dismiss="alert" aria-label="close"></a>'.display('update_msg').'</div><br>');
           redirect('admin/Venue_controller/venue_list');

        } else {
            $data['venue_info'] = $this->venue_model->get_inde_venue($id);
			$this->load->view('admin/_header',$data);
			$this->load->view('admin/_left_sideber');
			$this->load->view('admin/view_edit_venue');
			$this->load->view('admin/_footer');
        }
             
    }

/*
|-----------------------------------------------
|	 Delete  venue
|-----------------------------------------------
*/
    public function delet_venue($id)
    {
      $this->db->where('venue_id',$id);
      $this->db->delete('venue_tbl');
      $this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('delete_msg').'</div>');
      redirect('admin/Venue_controller/venue_list');
    }

}