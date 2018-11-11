<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Print_pattern_controller extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');
		$session_id = $this->session->userdata('session_id');
	    if($session_id == NULL ){
	     redirect('SignOut');
	    }	    
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('admin/Venue_model','venue_model');
					
	}

#--------------------------------
#      view print pattern setup
#--------------------------------
	public function view_setup()
	{
		$data['venue_info'] = $this->venue_model->get_venue_list();
        $this->load->view('admin/_header',$data);
        $this->load->view('admin/_left_sideber');
        $this->load->view('admin/print_pattern/view_setup_print_pattern');
        $this->load->view('admin/_footer');
	}
	
#-------------------------------	
#      save setup	
#-------------------------------	
	public function save_setup(){
		$this->form_validation->set_rules('venue_id','Venue','required');
		$this->form_validation->set_rules('h_height','Header Height','required');
		$this->form_validation->set_rules('h_width','Header width','required');
		$this->form_validation->set_rules('f_height','Footer Height','required');
		$this->form_validation->set_rules('f_width','Footer width','required');
		$this->form_validation->set_rules('content1_height','Content height','required');
		$this->form_validation->set_rules('content1_width','Content width','required');
		if($this->form_validation->run()==False){
			$data['venue_info'] = $this->venue_model->get_venue_list();
			    $this->load->view('admin/_header',$data);
		        $this->load->view('admin/_left_sideber');
		        $this->load->view('admin/print_pattern/view_setup_print_pattern');
		        $this->load->view('admin/_footer');
		}else{
			$setup_data = array(
				'venue_id' => $this->input->post('venue_id'),
				'doctor_id' => $this->session->userdata('doctor_id'),
				'pattern_no' => $this->input->post('pattern'),
				'header_height' => $this->input->post('h_height'),
				'header_width' => $this->input->post('h_width'),
				'footer_height' => $this->input->post('f_height'),
				'footer_width' => $this->input->post('f_width'),
				'content_height_1' => $this->input->post('content1_height'),
				'content_width_1' => $this->input->post('content1_width'),
				'content_height_2' => $this->input->post('content2_height'),
				'content_width_2' => $this->input->post('content2_width')
			); 

			$result = $this->db->select('*')
			->from('print_pattern')
			->where('venue_id', $this->input->post('venue_id'))
			->where('doctor_id', $this->session->userdata('doctor_id'))
			->get()
			->row();
			if($result){
				$this->session->set_flashdata('message','<div class="alert alert-danger msg"> This Pattern allredy exist in this venue.</div>');
				redirect('admin/print_pattern/Print_pattern_controller/view_setup');
			}else{
				$this->db->insert('print_pattern',$setup_data);

				$this->session->set_flashdata('message','<div class="alert alert-success msg"> Setup Successfully.</div>');

				redirect('admin/print_pattern/Print_pattern_controller/view_setup');
			}


			
		}
	}

#--------------------------------
#      view print pattern setup list
#--------------------------------
	public function view_setup_list()
	{
		$data['setup_info'] = $this->db->select('print_pattern.*,venue_tbl.venue_id,venue_tbl.venue_name')
		->from('print_pattern')
		->join('venue_tbl','venue_tbl.venue_id=print_pattern.venue_id')
		->where('print_pattern.doctor_id',$this->session->userdata('doctor_id'))
		->get()
		->result();

        $this->load->view('admin/_header',$data);
        $this->load->view('admin/_left_sideber');
        $this->load->view('admin/print_pattern/view_setup_print_pattern_list');
        $this->load->view('admin/_footer');
	}

	public function edit_view($id){
		
		$data['pattern'] = $this->db->select('print_pattern.*,venue_tbl.venue_id,venue_tbl.venue_name')
		->from('print_pattern')
		->join('venue_tbl','venue_tbl.venue_id=print_pattern.venue_id')
		->where('print_pattern.id',$id)
		->get()
		->row();
		$data['venue_info'] = $this->venue_model->get_venue_list();

        $this->load->view('admin/_header',$data);
        $this->load->view('admin/_left_sideber');
        $this->load->view('admin/print_pattern/view_edit_setup_print_pattern');
        $this->load->view('admin/_footer');
	}

	public function update_setup(){

			$setup_data = array(
				'venue_id' => $this->input->post('venue_id'),
				'doctor_id' => $this->session->userdata('doctor_id'),
				'pattern_no' => $this->input->post('pattern'),
				'header_height' => $this->input->post('h_height'),
				'header_width' => $this->input->post('h_width'),
				'footer_height' => $this->input->post('f_height'),
				'footer_width' => $this->input->post('f_width'),
				'content_height_1' => $this->input->post('content1_height'),
				'content_width_1' => $this->input->post('content1_width'),
				'content_height_2' => $this->input->post('content2_height'),
				'content_width_2' => $this->input->post('content2_width')
			);
			//print_r($setup_data); exit;
			$id = $this->input->post('id'); 
			$this->db->where('id',$id)->update('print_pattern',$setup_data);
			$this->session->set_flashdata('message','<div class="alert alert-success msg"> Update Successfully.</div>');
			redirect('admin/print_pattern/Print_pattern_controller/view_setup_list');
			
	}

	public function delete_setup($id){
		$this->db->where('id',$id)->delete('print_pattern');
		$this->session->set_flashdata('message','<div class="alert alert-success msg"> Delete Successfully.</div>');
		redirect('admin/print_pattern/Print_pattern_controller/view_setup_list');

	}

}		