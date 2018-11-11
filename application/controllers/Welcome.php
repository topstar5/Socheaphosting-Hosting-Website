<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
/*
|--------------------------------------
|   constructor funcion
|--------------------------------------
*/ 
	public function __construct() 
	{
		parent::__construct();
		$info= $this->db->select('*')->from('web_pages_tbl')->where('name','website_on_off')->get()->row();
    
        if($info->details=='off'){
          redirect('login');
        }
        //Load Home_view_model
        $this->load->model('web/Home_view_model','home_view_model');
        //Load Overview model
        $this->load->model('admin/Overview_model','overview_model');
        //Load venue model
        $this->load->model('admin/Venue_model','venue_model');
        //load appointment model
        $this->load->model('admin/Appointment_model','appointment_model');
        //Load Basic model
        $this->load->model('admin/basic_model','basic_model');
        //Load Schedule model
        $this->load->model('admin/Schedule_model','schedule_model');
        //Load Patient model
        $this->load->model('admin/Patient_model','patient_model');
        // Load sms setup model
        $this->load->model('admin/Sms_setup_model','sms_setup_model');
        //
        $this->load->library('Smsgateway');
        //
        $this->load->model('admin/email/Email_model','email_model');
        $this->load->library('email');
  }

/*
|--------------------------------------
|   View home page in the website
|--------------------------------------
*/
	public function index($patient_id=NULL)
	{
        //get_schedule_list
        $data['schedule'] = $this->schedule_model->get_schedule_list();
        //setup information
        $data['info'] = $this->home_view_model->Home_satup();
        //get doctor_info
        $data['doctor_info'] = $this->home_view_model->doctor_info();
        //load slider
        $data['slider'] = $this->home_view_model->Slider(); 
        //total_appointment
        $data['total_appointment'] = $this->overview_model->total_appointment();
        //total_patient
        $data['total_patient'] = $this->overview_model->total_patient();
        //to_day_appointment
        $data['to_day_appointment'] = $this->overview_model->to_day_appointment();
        //to_day_get_appointment
        $data['to_day_get_appointment'] = $this->overview_model->to_day_get_appointment();
        // testimonial
        $data['testimonial'] = $this->home_view_model->get_all_testimonial();
        // Post
        $data['post'] = $this->home_view_model->get_all_post();
        //get venue list
        $data['venue'] = $this->venue_model->get_venue_list();
        #------view page----------
        $this->load->view('home',$data);
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
            $get_by = $this->session->userdata('log_id');

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
            'get_by' => 'Won'
            );

           $check = $this->appointment_model->Check_appointment($this->input->post('date'),$this->input->post('patient_id'));
           if(!empty($check)){
              $this->session->set_flashdata('exception',"<div class='alert alert-danger msg'>".display('appointment_error_msg')."</div>");
              redirect('Welcome');
           }else{

            $this->appointment_model->SaveAppoin($saveData);               
        
            #-------------------------------
            // sms information save
            $info = $this->basic_model->get_appointment_print_result($appointment_id);
            $start = $info->start_time;
            $appointment_date = $info->date.' '.date('h:i:s', strtotime($start));
            $save_sms_info_details = array(
                'patient_id'        =>  $info->patient_id,
                'doctor_id'         =>  $info->doctor_id,
                'phone_no'          =>  $info->patient_phone,
                'appointment_date'  =>  $appointment_date,
                'appointment_id'    =>  $appointment_id
                ); 
            $this->appointment_model->Save_sms_info($save_sms_info_details);
            #------------------------------- 
              

            #-------------------------------
            $sms_gateway_info = $this->db->select("*")->from('sms_gateway')->where('default_status',1)->get()->row();
            // messate teamplate
            $teamplate_info = $this->db->select("*")->from('sms_teamplate')->where('default_status',1)->get()->row();
            // doctor
            $dData = $this->db->get_where('doctor_tbl', ['doctor_id =' => 1])->row();
            #---------------------------
            // sms_setting    
                if(!empty($teamplate_info) && !empty($sms_gateway_info)) {

                    $template = $this->smsgateway->template([
                         'doctor_name'      => $dData->doctor_name,
                         'appointment_id'   => $appointment_id,
                         'patient_name'     => $info->patient_name,
                         'patient_id'       => $info->patient_id,
                         'sequence'         => $info->sequence, 
                         'appointment_date' => date('d F Y',strtotime($info->date)),
                         'message'          => $teamplate_info->teamplate

                    ]); 
                      
                    $this->smsgateway->send([
                         'apiProvider' => $sms_gateway_info->provider_name,
                         'username'    => $sms_gateway_info->user,
                         'password'    => $sms_gateway_info->password,
                         'from'        => $sms_gateway_info->authentication,
                         'to'          => $info->patient_phone,
                         'message'     => $template
                    ]);

                    #------------------------------
                    // save delivary data
                    $save_coustom = array(
                        'gateway'     => $sms_gateway_info->provider_name,
                        'reciver'     => $info->patient_phone,
                        'message'     => $template       
                    );
                    $this->db->insert('custom_sms_info',$save_coustom);
                }
                #------------------------------ 


                #-----------------------------------------
                  # email sending option
                #-----------------------------------------
                $email_config = $this->email_model->email_config();
                // Email information save in email_info table
                $start = $info->start_time;
                $appointment_date = $info->date.' '.date('h:i:s', strtotime($start));
              
                $save_email_info = array(
                'patient_id'                => $info->patient_id,
                'doctor_id'                 => $info->doctor_id,
                'patient_phone'             => $info->patient_phone,
                'patient_email'             => $info->patient_email,
                'appointment_date'          => $appointment_date,
                'appointment_id'            => $appointment_id
                ); 
                $this->appointment_model->Save_email_info($save_email_info);
                #-------------------------------
                if($email_config->at_appointment==1){
                 // gate email template
                $email_temp_info = $this->db->select("*")->from('email_template')->where('default_status',1)->get()->row();
              
                if(!empty($email_temp_info) && !empty($info->patient_email)) {     
              
                    $message = $this->template([
                         'doctor_name'      => $dData->doctor_name,
                         'appointment_id'   => $appointment_id,
                         'patient_name'     => $info->patient_name,
                         'patient_id'       => $info->patient_id,
                         'sequence'         => $info->sequence, 
                         'appointment_date' => date('d F Y',strtotime($info->date)),
                         'message'          => $email_temp_info->email_template
                    ]); 

                #----------------------------
                    $config['protocol'] = $email_config->protocol;
                    $config['mailpath'] = $email_config->mailpath;
                    $config['charset'] = 'utf-8';
                    $config['wordwrap'] = TRUE;
                    $config['mailtype'] = $email_config->mailtype;
                    $this->email->initialize($config);

                    $this->email->from($email_config->sender, "Habitusana");
                    $this->email->to($info->patient_email);
                    $this->email->subject("Informazioni appuntamento");
                    $this->email->message($message);
                    $this->email->send();
                #-----------------------------
                    // save email delivary data
                    $save_email = array(
                      'delivery_date_time '=> date("Y-m-d h:i:s"),
                      'reciver_email '=> $info->patient_email,
                      'message'     => $message       
                    );
                    $this->db->insert('email_delivery',$save_email);
                    }

                }   
            #------------------------------
            # End Email Sending option
            #-------------------------------  
            }
           
            $sdata = array();
            $sdata['patient_id'] = $this->input->post('p_id');
            $sdata['date'] = $this->input->post('date');
            $sdata['appointment_id'] = $appointment_id;
            $this->session->set_userdata($sdata);
            $this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('get_appointment_msg').'</div>');
            redirect('Welcome/print_appointment_info');

         }else{
        	   redirect('Welcome');
         }
    }     

/*
|--------------------------------------
|     view  print_appointment_info
|--------------------------------------
*/ 
    public function print_appointment_info()
    {
      $data['info'] = $this->home_view_model->Home_satup();
        $appointment_id = $this->session->userdata('appointment_id'); 
        $data['print'] = $this->basic_model->get_appointment_print_result($appointment_id);

    		
        
    		if($data){
             	 $this->load->view('public/patient_appointment_info',$data); 
            }else{
                redirect('Welcome');
            } 
    }
/*
|--------------------------------------
|     print registration save
|--------------------------------------
*/   

public function registration()
{
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('pat_id', 'Patient Id', 'trim|required|is_unique[patient_tbl.patient_id]');
      $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[6]|max_length[15]');

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
                  redirect('Welcome');
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
          $exists_user = $this->patient_model->exists_user(
              $this->input->post('phone',true),
              date('Y-m-d',strtotime($this->input->post('birth_date',true)))
          ); 
          if($exists_user == true){
              $this->session->set_flashdata('exception','<div class="alert alert-danger">'.display('exist_error_msg').'</div>');  
              redirect('Welcome');
          }

            $patient_id = $this->input->post('pat_id',TRUE); 
            $create_date = date('Y-m-d h:i:s');
            $birth_date = date('Y-m-d',strtotime($this->input->post('birth_date',TRUE)));

            $savedata =  array(
            'patient_id'    => $this->input->post('pat_id',TRUE),
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
        #--------------------------------------
        # send email
        #-------------------------------------- 
          $email_config1 = $this->email_model->email_config();
            #-------------------------------
            if($email_config1->at_registration==1){
              // gate email template
              $email_temp_info = $this->db->select("*")->from('email_template')->where('default_status',1)->where('template_type',1)->get()->row();
               if(!empty($email_temp_info)) {     
              
                      $message = $this->template([
                         'patient_name'     => $this->input->post('name',TRUE),
                         'patient_id'       => $this->input->post('pat_id',TRUE), 
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
#--------------------------------------            
#--------------------------------------            



            $savedata = $this->security->xss_clean($savedata); 
            $this->patient_model->save_patient($savedata);
            $this->session->set_flashdata('patient_id',$patient_id);
            $this->session->set_flashdata('exception',"<div class='alert alert-success'>".display('register_msg')." <strong>Patient Id : ".$patient_id."</strong></div>");
            redirect('Welcome');
        } else {
          $this->session->set_flashdata('exception',"<div class='alert alert-danger'>Some fild are messiong, Please Try again.</div>");
          redirect('Welcome');
        }
}


 function template($config1 = null){
        $newStr = $config1['message'];
        foreach ($config1 as $key => $value) {
            $newStr = str_replace("%$key%", $value, $newStr);
        } 
        return $newStr; 
    }
/*
|---------------------------------
| GET POST BY ID
|---------------------------------
*/
	public function post_by_id($id)
	{
		$result = $this->db->select('*')
        ->from('blog_tbl')
        ->where('id',$id)
        ->get()
        ->row();
       // print_r($result); exit;
		echo json_encode($result);
	}
/*
|---------------------------------
| GET SLIDER BY ID
|---------------------------------
*/
	public function slider_by_id($id)
	{
		$result = $this->db->select('*')
        ->from('slider')
        ->where('id',$id)
        ->get()
        ->row();
		echo json_encode($result);
	}

}
