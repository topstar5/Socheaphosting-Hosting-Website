<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Doctor_controller extends CI_Controller {
  
  /*
  |--------------------------------------
  |  Construction function 
  |--------------------------------------
  */
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');
		 $session_id = $this->session->userdata('session_id'); 
	    if($session_id == NULL ) {
	     redirect('logout');
	    }
	  $this->load->model('admin/Doctor_model','doctor_model');
	}

  /*
  |--------------------------------------
  | Profile
  |--------------------------------------
  */
	public function profile()
	{
     $data['title'] = "Profile";
		$data['doctor_info'] = $this->doctor_model->get_doctor_info();
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/profile_setup');
		$this->load->view('admin/_footer');
	}
  /*
  |--------------------------------------
  | update_profile
  |--------------------------------------
  */ 

	public function update_profile()
	{
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('phone','Phone','required');
		
		if($this->form_validation->run()==true) {
			    # get picture data
              if (@$_FILES['picture']['name']) {
                $config['upload_path']   = './assets/uploads/doctor/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['overwrite']     = false;
                $config['max_size']      = 1024;
                $config['remove_spaces'] = true;
                $config['max_filename']   = 10;
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('picture'))
                {
                   $this->session->set_flashdata('execption',display('image_upload_msg'));
                   redirect('profile');
                } else {
                
                 $data = $this->upload->data();
                 $image = base_url($config['upload_path'].$data['file_name']);
                  #------------resize image------------#
                  $this->load->library('image_lib');
                  $config['image_library'] = 'gd2';
                  $config['source_image'] = $config['upload_path'].$data['file_name'];
                  $config['create_thumb'] = FALSE;
                  $config['maintain_ratio'] = FALSE;
                  $config['width']     = 250;
                  $config['height']   = 200;

                  $this->image_lib->clear();
                  $this->image_lib->initialize($config);
                  $this->image_lib->resize();
                  #-------------resize image----------#
                }

                } else {
                    $image = $this->input->post('image',TRUE);
                } 

                $savedata =  array(
                    'doctor_name' => $this->input->post('name',TRUE),
                    'department' => $this->input->post('department',TRUE),
                    'designation' => $this->input->post('designation',TRUE),
                    'degrees' => $this->input->post('degree',TRUE), 
                    'specialist' => $this->input->post('specialist',TRUE),
                    'doctor_exp' => $this->input->post('doctor_exp',TRUE),
                    'birth_date' => $this->input->post('birth_date',TRUE),
                    'sex' => $this->input->post('gender',TRUE),
                    'blood_group' => $this->input->post('blood_group',TRUE),
                    'doctor_phone' => $this->input->post('phone',TRUE),
                    'address' => $this->input->post('address',TRUE),
                    'about_me' => $this->input->post('about_me',TRUE),
                    'service_place' => $this->input->post('service_place',TRUE),
                    'picture' => $image
                );
               $doctor_id = $this->input->post('doctor_id');


              $this->doctor_model->save_edit_dcotor_profile($savedata, $doctor_id);
              $this->session->set_flashdata('message','<div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>'.display('update_msg').'</strong> .
              </div>');
              redirect('profile'); 

			} else {
				$data['doctor_info'] = $this->doctor_model->get_doctor_info();
				$this->load->view('admin/_header',$data);
				$this->load->view('admin/_left_sideber');
				$this->load->view('admin/profile_setup');
				$this->load->view('admin/_footer');
			}
	}


}