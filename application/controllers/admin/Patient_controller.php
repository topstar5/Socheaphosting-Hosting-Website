<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_controller extends CI_Controller {
/*
|--------------------------------------
|   Constructor function
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
	  $this->load->model('admin/Patient_model','patient_model');
    $this->load->model('admin/Venue_model','venue_model');
	  $this->load->model('admin/Overview_model','overview_model');
    $this->load->model('admin/email/Email_model','email_model');
        $this->load->library('Smsgateway');
    
  }
/*
|--------------------------------------
|     view all patient list
|--------------------------------------
*/
	public function patient_list()
	{
    $data['title'] = "Patient List";
		$data['patient_info'] = $this->patient_model->get_all_patient();
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_patient_list');
		$this->load->view('admin/_footer');
	}
/*
|--------------------------------------
|     Today patient list
|--------------------------------------
*/
  public function today_patient_list()
  {
    $data['title'] = "Today Patient List";
    $data['patient_info'] = $this->overview_model->today_patient();
    
    $this->load->view('admin/_header',$data);
    $this->load->view('admin/_left_sideber');
    $this->load->view('admin/view_today_patient_list');
    $this->load->view('admin/_footer');
  }  
/*
|--------------------------------------
|   Create a new patient view
|--------------------------------------
*/
	public function create_new_patient()
	{

    $data['patient_id_prefix']= $this->db->select('*')->from('web_pages_tbl')->where('name','patient_id_prefix')->get()->row()->details;
    $data['patient_id_auto_generate']= $this->db->select('*')->from('web_pages_tbl')->where('name','patient_id_auto_generate')->get()->row()->details;

    $data['venue'] = $this->venue_model->get_venue_list();

    $data['title'] = "Create New Patient";
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_create_patient');
		$this->load->view('admin/_footer');
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

/*
|--------------------------------------
| save patient to patient_tbl
|--------------------------------------
*/
	public function save_patient()
	{

    $data['patient_id_prefix']= $this->db->select('*')->from('web_pages_tbl')->where('name','patient_id_prefix')->get()->row()->details;
    $data['patient_id_auto_generate']= $this->db->select('*')->from('web_pages_tbl')->where('name','patient_id_auto_generate')->get()->row()->details;


      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('venue_id', 'Venue ID', 'required');
      $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[6]|max_length[15]');
      if($data['patient_id_auto_generate'] == 'off')
      $this->form_validation->set_rules('patient_id', 'Patient Id', 'trim|required|is_unique[patient_tbl.patient_id]');
      $this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[log_info.email]');         
   
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
                  $this->session->set_flashdata('exception',"<div class='alert alert-danger msg'>".display('image_upload_msg')."</div>");
        			redirect('create_new_patient');
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
 
              $venue_id = $this->input->post('venue_id',TRUE);

            $create_date = date('Y-m-d h:i:s');
            $birth_date = date('Y-m-d',strtotime($this->input->post('birth_date',TRUE)));

            if($data['patient_id_auto_generate'] == 'off')
              $patient_id = $this->input->post('patient_id',TRUE);
            else {
              $patients_count = $this->db->select('*')->from('patient_tbl')->get()->num_rows();
              $patients_count = str_pad($patients_count+1, 5, "0", STR_PAD_LEFT);
              $patient_id = $data['patient_id_prefix'].$patients_count;
            }

             $savedata =  array(
            'patient_id'    => $patient_id,
            'venue_id'    => $venue_id,
            'patient_name' => $this->input->post('name',TRUE),
            'patient_email' => $this->input->post('email',true),
            'patient_phone' => $this->input->post('phone',TRUE), 
            'birth_date' => $birth_date,
            'sex' => $this->input->post('gender',TRUE),
            'blood_group' => $this->input->post('blood_group',TRUE),
            'address' => $this->input->post('address',TRUE),
            'picture' => $image,
            'create_date'=>$create_date
            );
            $savedata = $this->security->xss_clean($savedata); 
            $this->patient_model->save_patient($savedata);

            #------------------------------- 
            // SMS Notification

            $sms_gateway_info = $this->db->select("*")->from('sms_gateway')->where('default_status',1)->get()->row();
            // messate teamplates
            $teamplate_info = $this->db->select("*")->from('sms_teamplate')->where('teamplate_name', 'Patient_Registration')->get()->row();

            $venue = $this->db->select("*")->from('venue_tbl')->where('venue_id', $venue_id)->get()->row();

             $template = $this->smsgateway->template([
                 'patient_name'     => $this->input->post('name',TRUE),
                 'patient_id'       => $patient_id,
                 'clinic_branch_name'=> $venue->venue_name, 
                 'clinic_branch_phone'=> $venue->venue_contact, 
                 'clinic_branch_address'=> $venue->venue_address, 
                 'message'          => $teamplate_info->teamplate

             ]); 
             $this->smsgateway->send([
                 'apiProvider' => $sms_gateway_info->provider_name,
                 'username'    => $sms_gateway_info->user,
                 'password'    => $sms_gateway_info->password,
                 'from'        => $sms_gateway_info->authentication,
                 'to'          => $this->input->post('phone',TRUE),
                 'message'     => $template
             ]);
             #------------------------------
              // save patient sms delivary data
              $save_coustom = array(
                'gateway'     => $sms_gateway_info->provider_name,
                'reciver'     => $this->input->post('phone',TRUE),
                'message'     => $template       
              );
             $this->db->insert('custom_sms_info',$save_coustom);
              

            $email_config1 = $this->email_model->email_config();
            #-------------------------------
              if($email_config1->at_registration==1){
              // gate email template
              $email_temp_info = $this->db->select("*")->from('email_template')->where('default_status',1)->where('template_type',1)->get()->row();
             
            
              if(!empty($email_temp_info)) {     
              
                      $message = $this->template([
                         'patient_name'     => $this->input->post('name',TRUE),
                         'patient_id'       => $this->input->post('patient_id',TRUE), 
                         'date' => date("Y-m-d h:i:s"),
                         'message'          => $email_temp_info->email_template
                     ]); 

                #----------------------------
                    $config['protocol'] = $email_config1->protocol;
                    $config['mailpath'] = $email_config1->mailpath;
                    $config['charset'] = 'utf-8';
                    $config['wordwrap'] = TRUE;
                    $config['mailtype'] = $email_config1->mailtype;
                    $this->email->initialize($config);

                     $this->email->from($email_config1->sender, "Doctor");
                     $this->email->to($this->input->post('email'));
                     $this->email->subject("Registration");
                     $this->email->message($message);
                     $this->email->send();
                #-----------------------------
                     
                // save email delivary data
                $save_email = array(
                  'delivery_date_time '=> date("Y-m-d h:i:s"),
                  'reciver_email '=> $this->input->post('email'),
                  'message'     => $message       
                );
                
                $this->db->insert('email_delivery',$save_email);
              } 
              }

            $da['info'] = $savedata;
            $da['venue_info'] = $this->venue_model->get_venue_list();
            $this->load->view('admin/_header',$da);
            $this->load->view('admin/_left_sideber');
            $this->load->view('admin/view_create_patient_appointment');
            $this->load->view('admin/_footer');
        } else {
          $this->load->view('admin/_header');
      		$this->load->view('admin/_left_sideber');
      		$this->load->view('admin/view_create_patient', $data);
      		$this->load->view('admin/_footer');
      	}
	}

 function template($config = null){
        $newStr = $config['message'];
        foreach ($config as $key => $value) {
            $newStr = str_replace("%$key%", $value, $newStr);
        } 
        
        return $newStr; 
  }

/*
|--------------------------------------
|   delete patient to patient_tbl
|--------------------------------------
*/ 
  public function delete_patient($patient_id)
  {
      $this->db->where('patient_id',$patient_id);
      $this->db->delete('patient_tbl');
      $this->session->set_flashdata('message',"<div class='alert alert-success msg'>".display('delete_msg')."</div>");
      redirect('patient_list');
  }
  
/*
|--------------------------------------
|    patient edit form view 
|--------------------------------------
*/ 
  public function patient_edit($patient_id)
  {
    $data['title'] = "Patient Edit";
    $data['patient_info'] = $this->patient_model->get_patient_inde_info($patient_id);
    $this->load->view('admin/_header',$data);
    $this->load->view('admin/_left_sideber');
    $this->load->view('admin/view_edit_patient');
    $this->load->view('admin/_footer');
  }

/*
|--------------------------------------
|    patient edit save to patient_tbl
|--------------------------------------
*/    
  public function edit_save_patient() {
        $patient_id = $this->input->post('patient_id',TRUE);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[9]|max_length[15]');        
      if ($this->form_validation->run()==TRUE) {
          // get picture data
              if (@$_FILES['picture']['name']) {
                $ext = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));
                $config['upload_path']          = './assets/uploads/patient/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['overwrite']     = false;
                $config['max_size']      = 1024;
                $config['remove_spaces'] = true;
                $config['max_filename']   = 5;
                $config['file_ext_tolower'] = true;
                
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('picture')) {
                     $sdata = array('errorMsg' => 'Image Dos not upload.');
                     $this->session->set_userdata($sdata);
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
                $birth_date = date('Y-m-d',strtotime($this->input->post('birth_date',TRUE)));

              $savedata =  array(
              'patient_name' => $this->input->post('name',TRUE),
              'birth_date' =>$birth_date,
              'sex' => $this->input->post('gender',TRUE),
              'blood_group' => $this->input->post('blood_group',TRUE),
              'patient_phone' => $this->input->post('phone',TRUE),
              'address' => $this->input->post('address',TRUE),
              'picture' => $image
              
              );
              $this->patient_model->save_edit_patient($savedata,$patient_id);
              $this->session->set_flashdata('message',"<div class='alert alert-success msg'>".display('update_msg')."</div>");
              redirect('patient_list');
            } else {
                $data['patient_info'] = $this->patient_model->get_patient_inde_info($patient_id);
                $this->load->view('admin/_header',$data);
                $this->load->view('admin/_left_sideber');
                $this->load->view('admin/view_edit_patient');
                $this->load->view('admin/_footer');
            }
  }


}	