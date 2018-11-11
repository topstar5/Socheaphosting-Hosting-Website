<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
/*
|--------------------------------------
|   constructor funcion
|--------------------------------------
*/ 
	public function __construct() 
	{
		parent::__construct();
		
    $this->load->model('Api_model','api_model');
	  $this->load->model('admin/Venue_model','venue_model');
	   
	}
  

/*
|--------------------------------------
|   View home page in the website
|--------------------------------------
*/
	public function index($patient_id=NULL)
	{
		//get venue list
		$data['venue'] = $this->venue_model->get_venue_list();
	   $this->load->view('view_api',$data);
	}

/*
|--------------------------------------
|   patient id genaretor
|--------------------------------------
*/
  function randstrGen($mode=null,$len=null)
  {
        $result = "";
        if($mode == 1):
              $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
          elseif($mode == 2):
              $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
          elseif($mode == 3):
              $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
          elseif($mode == 4):
              $chars = "0123456789";
          endif;
          $charArray = str_split($chars);
          for($i = 0; $i < $len; $i++) {
                  $randItem = array_rand($charArray);
                  $result .="".$charArray[$randItem];
          }
          return $result;
  }


#-----------------------------------------------
#    random coad genaretor of appointmaent id
#----------------------------------------------  
  function randstrGenapp($len) 
  {
    $result = "";
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .="".$charArray[$randItem];
    }
    return $result;
  }

#-----------------------------------------------
#    save appointmaent 
#----------------------------------------------  

  public function appointment()
  {
    $this->form_validation->set_rules('date', 'Date', 'required');
    $this->form_validation->set_rules('patient_id', 'Patient Id', 'required');
    $this->form_validation->set_rules('venue_id', 'venue', 'required'); 
    $this->form_validation->set_rules('sequence', 'sequence', 'trim|required');

      if($this->form_validation->run()==true){
          
          date_default_timezone_set("Europe/Rome");
          $h = date('h')-1;

          	$appointment_id = "A".date('y').strtoupper($this->randstrGenapp(5));
          	$saveData = array(
            'date' => $this->input->post('date'),
            'patient_id' => $this->input->post('patient_id'),
            'appointment_id' =>$appointment_id,
            'schedul_id' => $this->input->post('schedul_id'),
            'sequence' => $this->input->post('sequence'),
            'venue_id' => $this->input->post('venue_id'),
            'doctor_id' => 1,
            'problem' => $this->input->post('problem'),
            'get_date_time' => date("Y-m-d h:i:s"),
            'get_by' => 'own'
            );

          //print_r($saveData); exit;
           $check = $this->api_model->Check_appointment($this->input->post('date'),$this->input->post('patient_id'));

           if(!empty($check)){
            $this->session->set_flashdata('exception',"<div class='alert alert-danger msg'>Sorry You already get apointment in this date.</div>");
              redirect('Api');
           }else{
               $this->api_model->SaveAppoin($saveData);
           }
           
            $sdata = array();
            $sdata['patient_id'] = $this->input->post('p_id');
            $sdata['date'] = $this->input->post('date');
            $sdata['appointment_id'] = $appointment_id;
            $this->session->set_userdata($sdata);
            $this->session->set_flashdata('message','<div class="alert alert-success msg">You Got this appointment Successful..</div>');
            redirect('Api/print_appointment_info');

         }else{
        	//get venue list
          $data['venue'] = $this->venue_model->get_venue_list();
          $this->load->view('view_api',$data);
         }
    }     

/*
|--------------------------------------
|     view  print_appointment_info
|--------------------------------------
*/ 
    public function print_appointment_info()
    {
        $appointment_id = $this->session->userdata('appointment_id'); 
        $data['print'] = $this->api_model->get_appointment_print_result($appointment_id);
    		
    		if($data){
             	 $this->load->view('public/patient_appointment_info',$data); 
            }else{
                redirect('Api');
            } 
    }
/*
|--------------------------------------
|     patient registration save
|--------------------------------------
*/   
    public function registration()
    {
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[9]|max_length[15]');

      if ($this->form_validation->run()==true) {
          // get picture data
          if (@$_FILES['picture']['name']){

              $config['upload_path']   = './assets/uploads/patient/';
              $config['allowed_types'] = 'gif|jpg|jpeg|png';
              $config['overwrite']     = false;
              $config['max_size']      = 1024;
              $config['remove_spaces'] = true;
              $config['max_filename']   = 10;
              $config['file_ext_tolower'] = true;
              
              $this->load->library('upload', $config);
              if (!$this->upload->do_upload('picture')){
                  $this->session->set_flashdata('exception',"<div class='alert alert-danger msg'>Image dosn't upload!</div>");
              redirect('Api');
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
              $image = "";
            }
        #------------------------------------------------#
          $exists_user = $this->api_model->exists_user(
              $this->input->post('phone',true),
              date('Y-m-d',strtotime($this->input->post('birth_date',true)))
          ); 
          if($exists_user == true){
              $this->session->set_flashdata('exception','<div class="alert alert-danger">Patient already exists!</div>');  
              redirect('Api');
          }

            $patient_id = "P".date('y').strtoupper($this->randstrGen(2,4)); 
            $create_date = date('Y-m-d h:i:s');
            $birth_date = date('Y-m-d',strtotime($this->input->post('birth_date',TRUE)));

             $savedata =  array(
            'patient_id'    => $patient_id,
            'patient_name' => $this->input->post('name',TRUE),
            'patient_email' => $this->input->post('email',true),
            'patient_phone' => $this->input->post('phone',TRUE), 
            'birth_date' =>$birth_date,
            'sex' => $this->input->post('gender',TRUE),
            'blood_group' => $this->input->post('blood_group',TRUE),
            'address' => $this->input->post('address',TRUE),
            'picture' => $image,
            'create_date'=>$create_date
            );

            $savedata = $this->security->xss_clean($savedata); 
            $this->api_model->save_patient($savedata);
            $this->session->set_flashdata('patient_id',$patient_id);
            $this->session->set_flashdata('exception',"<div class='alert alert-success'>Registration Successful, <strong>Patient Id : ".$patient_id."</strong></div>");
            redirect('Api');
        } else {
          //get venue list
          $data['venue'] = $this->venue_model->get_venue_list();
          $this->load->view('view_api',$data);
        }
}




}
