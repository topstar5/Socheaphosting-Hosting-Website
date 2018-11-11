<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Prescription_controller extends CI_Controller {

#-----------------------------------------------
#    prescription_list
#----------------------------------------------
	public function __construct() 
	{
		parent::__construct();
	    $this->load->library('session');
		$log_id = $this->session->userdata('log_id');	
		$session_id = $this->session->userdata('session_id');	
	    
	   	if($session_id == NULL ) {
	     redirect('logout');
	    }

        $this->load->helper('form');
		$this->load->library('form_validation');
        $this->load->model('admin/Prescription_model','prescription_model');
	 	$this->load->model('admin/Venue_model','venue_model');
	 	$this->load->model('admin/Overview_model','overview_model');
	 	$this->load->model('admin/Represcription','represcription');
	 	
	 	$result = $this->db->select('*')->from('web_pages_tbl')->where('name','timezone')->get()->row();
		
		date_default_timezone_set(@$result->details);
	}


#-----------------------------------------------
#    prescription_list
#---------------------------------------------- 
	public function prescription_list()
	{
	 	$data['Prescription'] = $this->prescription_model->prescription_list();
	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_prescription_list');
		$this->load->view('admin/_footer');
	 
	}


#-----------------------------------------------
#    prescription_list
#---------------------------------------------- 
	public function today_prescription_list()
	{
		$data['title'] = "Today Prescription List";
	 	$data['Prescription'] = $this->overview_model->today_prescription();
	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_today_prescription_list');
		$this->load->view('admin/_footer');	 
	}

#-----------------------------------------
#			create new prescription 
#-----------------------------------------
	public function create_prescription($appointmaent_id = NULL)
	{
		$data['title'] = "Create Prescription";
		$data['patient_info'] = $this->prescription_model->patient_info($appointmaent_id);
	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/create_prescription');
		$this->load->view('admin/_footer'); 	
	}

#-----------------------------------------
#       Save Prescription
#-----------------------------------------	
	public function save_prescription()
	{
	 	$this->session->unset_userdata('appointment_id');
	 	$this->session->unset_userdata('prescription_id'); 	

	 	$pdata['patient_id'] = $this->input->post('patient_id');
	 	$pdata['appointment_id'] = $this->input->post('appointment_id');
	 	$pdata['doctor_id'] = $this->session->userdata('doctor_id');
	 	$pdata['Pressure'] = $this->input->post('Pressure');
	 	$pdata['Weight'] = $this->input->post('Weight');
	 	$pdata['problem'] = $this->input->post('Problem');
	 	$pdata['venue_id'] = $this->input->post('venue_id');
	 	$pdata['oex'] = $this->input->post('oex');
		$pdata['pd'] = $this->input->post('pd');
		$pdata['history'] = $this->input->post('history');
		$pdata['temperature'] = $this->input->post('temperature');
		$pdata['prescription_type'] = 1;
	 	$pdata['pres_comments'] = $this->input->post('prescription_comment');
	 	$pdata['create_date_time'] = date("Y-m-d h:i:s");

	 	$this->db->insert('prescription',$pdata);
	    // get last insert id
	    $prescription_id = $this->db->insert_id();
	#----------------------------------------------------#
			 	# medicine assign for patient 
	#----------------------------------------------------#    
	    $mdata['med_type'] = $this->input->post('type');
	 	$mdata['medicine_id'] = ($this->input->post('medicine_id'));
	 	$mdata['mg'] = ($this->input->post('mg'));
	 	$mdata['dose'] = ($this->input->post('dose'));
	 	$mdata['day'] = ($this->input->post('day'));
	 	$mdata['comments'] = ($this->input->post('comments'));
	 	$mdata['appointment_id'] = $this->input->post('appointment_id');
	 	$mdata['prescription_id'] = $prescription_id;


			for($i=0; $i<count($mdata['medicine_id']); $i++) {

			 	if(empty($mdata['medicine_id'][$i])) {

			 		$md_name['medicine_name'] = $this->input->post('md_name');
				 	$create_by = $this->session->userdata('doctor_id');
				 	$med_description = 'doctor description';

				 	# chack the medicine name in the medicine_info table 
				 	$query = $this->db->select('*')
	 	 			->from('medecine_info')
	 	 			->where('medicine_name',$md_name['medicine_name'][$i])
	 	 			->get()
	 	 			->row();

	 	 			if(!empty($query)) {
						$mdata['med_id'] = $query->medicine_id;
					} else {
						$medicine = array(
						'medicine_name' => $md_name['medicine_name'][$i],
						'med_company_id' => '01',
						'med_group_id' => '01',
						'med_description' => $med_description
					);
					# insert medicine id in medicine_info table
					$this->db->insert('medecine_info',$medicine);
					# medicine id
					$mdata['med_id'] = $this->db->insert_id();
					}
			 	} else {
			 		$mdata['med_id'] = $mdata['medicine_id'][$i];
			 	}

	            $data = array(
	                    'prescription_id'=> $mdata['prescription_id'],
	                    'appointment_id'=> $mdata['appointment_id'],
	                    'medicine_id'=> $mdata['med_id'],
	                    'mg'=>$mdata['mg'][$i],
	                    'dose'=>$mdata['dose'][$i],
	                    'day'=>$mdata['day'][$i],
	                    'medicine_type' => $mdata['med_type'][$i],
	                    'medicine_com'=>$mdata['comments'][$i]
	            );

	            $this->db->insert('medicine_prescription', $data);
	        }
	#----------------------------------------------------#
			 	# test assign for patient
	#----------------------------------------------------#		 	
		 	$tdata['prescription_id'] = $prescription_id;
		 	$tdata['test_id'] = ($this->input->post('test_name'));
		 	$tdata['test_description'] = ($this->input->post('test_description'));
		 	$tdata['appointment_id'] = $this->input->post('appointment_id');
		$test_name = $this->input->post('test_name');
		$te_name    = $this->input->post('te_name');

		if((sizeof($test_name) > 0 && !empty($test_name[0])) || (sizeof($te_name) > 0 && !empty($te_name[0]))){	 	
		 	
		 	for($i=0; $i<count($tdata['test_id']); $i++) {

	            if(empty($tdata['test_id'][$i])) {
			 		$test_name['test_name'] = $this->input->post('te_name');
				 	$test_description = 'doctor';
				 	# chack the test name in the test_info table 
				 		$query = $this->db->select('*')
				 	 			->from('test_name_tbl')
				 	 			->where('test_name',$test_name['test_name'][$i])
				 	 			->get()
				 	 			->row();
						if(!empty($query)) {
							$tdata['t_id'] = $query->test_id;
						} else {
							$tesAdd = array(
								'test_name' => $test_name['test_name'][$i],
								'test_description' => $test_description
								 );

							$this->db->insert('test_name_tbl', $tesAdd);
							$tdata['t_id'] = $this->db->insert_id();
						}

					
			 	} else {
			 		$tdata['t_id'] = $tdata['test_id'][$i];
			 	}

	            $data = array(
	        		'prescription_id' => $tdata['prescription_id'],
	        		'appointment_id' => $tdata['appointment_id'],
	                'test_id'=> $tdata['t_id'],
	                'test_assign_description'=>$tdata['test_description'][$i]
	            );

	        	$this->db->insert('test_assign_for_patine', $data);
			}
		}


#---------------------------------------------------
#			advice assign for patient
#---------------------------------------------------
			$a_data['appointment_id'] = $this->input->post('appointment_id');
			$a_data['prescription_id'] = $mdata['prescription_id'];
		 	$a_data['advice'] = ($this->input->post('advice'));
	 		$num_advice = $this->input->post('advice');
		 	$num_adv    = $this->input->post('adv');
		 if((sizeof($num_advice) > 0 && !empty($num_advice[0])) || (sizeof($num_adv) > 0 && !empty($num_adv[0]))){
			for($i=0; $i<=count($a_data['advice']); $i++) {
				if(empty($a_data['advice'][$i])) {
			 		$adv_name['advice'] = $this->input->post('adv');
					$adv = array(
						'advice' => $adv_name['advice'][$i],
						'create_by' => $this->session->userdata('doctor_id')
						);
					$this->db->insert('doctor_advice', $adv);
					$ad_data['advice'] = $this->db->insert_id();
			 	} else {
			 		$ad_data['advice'] = $a_data['advice'][$i];
			 	}

				$advice_data = array(
            		'appointment_id' => $a_data['appointment_id'],
            		'prescription_id'=> $a_data['prescription_id'],
            		'advice_id' => $ad_data['advice']
            	);
            	$this->db->insert('advice_prescriptiion',$advice_data);
			}
		}

	 	$d['appointment_id'] = $this->input->post('appointment_id');
    	$this->session->set_userdata($d);
	 	redirect("prescription");
	}		 


#------------------------------------------------
#		create new prescription view form
#------------------------------------------------		 
	public function  create_new_prescription()
	{
		$data['title'] = "Create New Prescription ";
		$data['venue'] = $this->venue_model->get_venue_list();

	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/create_new_Prescription');
		$this->load->view('admin/_footer');
	}


#-----------------------------------------------
#    random coad genaretor of appointmaent id
#----------------------------------------------    

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

#-----------------------------------------
#	add new  prescription without ap id
#----------------------------------------	
	public function new_prescriptions_save()
	{

		if(empty($this->input->post('patient_id'))) {
		 	$patient_id =  $this->input->post('p_id');
		    $p_data['patient_id']=   $patient_id;
		    $p_data['venue_id']=   $this->input->post('venue_id');
		 	$p_data['patient_name']= $this->input->post('name');
		 	$p_data['patient_phone']= $this->input->post('phone');
		 	$p_data['birth_date']=   $this->input->post('birth_date');
		 	$p_data['sex']=          $this->input->post('gender');
		 	$this->db->insert('patient_tbl',$p_data);
		} else {
			 	$patient_id = $this->input->post('patient_id');
			}
			 	if(empty($this->input->post('appointment_id'))) {
			 		$pdata['appointment_id'] = "A".date('y').strtoupper($this->randstrGen(2,4));
			 	} else {
			 		$pdata['appointment_id'] = $this->input->post('appointment_id');
			 	}

			 	$pdata['patient_id'] = $patient_id;
			 	$pdata['appointment_id'] =$pdata['appointment_id'];
			 	$pdata['doctor_id'] = $this->session->userdata('doctor_id');
			 	$pdata['Pressure'] = $this->input->post('Pressure');
			 	$pdata['Weight'] = $this->input->post('Weight');
			 	$pdata['problem'] = $this->input->post('Problem');
			 	$pdata['venue_id'] = $this->input->post('venue_id');
			 	$pdata['oex'] = $this->input->post('oex');
				$pdata['pd'] = $this->input->post('pd');
				$pdata['history'] = $this->input->post('history');
				$pdata['temperature'] = $this->input->post('temperature');
			 	$pdata['prescription_type'] = 1;
			 	$pdata['pres_comments'] = $this->input->post('prescription_comment');
			 	$pdata['create_date_time'] = date("Y-m-d h:i:s");

			 	$this->session->unset_userdata('v_id');
	            $session_venu = array('v_id' => $this->input->post('venue_id'));
		 		$this->session->set_userdata($session_venu);

			 	$this->db->insert('prescription',$pdata);
	            # get last insert id
	            $p = $this->db->insert_id();
	            
	            $mdata['med_type'] = $this->input->post('type');
			 	$mdata['medicine_id'] = ($this->input->post('medicine_id'));
			 	$mdata['mg'] = ($this->input->post('mg'));
			 	$mdata['dose'] = ($this->input->post('dose'));
			 	$mdata['day'] = ($this->input->post('day'));
			 	$mdata['comments'] = ($this->input->post('comments'));
			 	$mdata['appointment_id'] = $pdata['appointment_id'];
			 	$mdata['prescription_id'] = $p;


			for($i=0; $i<count($mdata['medicine_id']); $i++) {
			 	
			 	if(empty($mdata['medicine_id'][$i])) {
			 		$md_name['medicine_name'] = $this->input->post('md_name');
				 	$create_by = $this->session->userdata('doctor_id');
				 	$med_description = 'doctor';

				 	# chack the medicine name in the medicine_info table 
				 	$query = $this->db->select('*')
	 	 			->from('medecine_info')
	 	 			->where('medicine_name',$md_name['medicine_name'][$i])
	 	 			->get()
	 	 			->row();
	 	 			if( ! empty($query)) {
						$mdata['med_id'] = $query->medicine_id;
					} else {
						$medicine = array(
						'medicine_name' => $md_name['medicine_name'][$i],
						'med_company_id' => '01',
						'med_group_id' => '01',
						'med_description' => $med_description
					);
					# insert medicine id in medicine_info table
					$this->db->insert('medecine_info',$medicine);
					# medicine id
					$mdata['med_id'] = $this->db->insert_id();
					}

			 	} else {
			 		$mdata['med_id'] = $mdata['medicine_id'][$i];
			 	}

	            $data = array(
	                'prescription_id'=> $mdata['prescription_id'],
	                'appointment_id'=> $mdata['appointment_id'],
	                'medicine_id'=> $mdata['med_id'],
	                'mg'=>$mdata['mg'][$i],
	                'dose'=>$mdata['dose'][$i],
	                'day'=>$mdata['day'][$i],
	                'medicine_type' => $mdata['med_type'][$i],
	                'medicine_com'=>$mdata['comments'][$i]
	            );

	            $this->db->insert('medicine_prescription', $data);
	            }
	#----------------------------------------------------
	#   test assign for patient
	#-----------------------------------------------------		 	
			 	$tdata['prescription_id'] = $p;
			 	$tdata['test_id'] = ($this->input->post('test_name'));
			 	$tdata['test_description'] = ($this->input->post('test_description'));
			 	$tdata['appointment_id'] = $pdata['appointment_id'];
			 
				$test_name = $this->input->post('test_name');
			 	$te_name    = $this->input->post('te_name');

		if((sizeof($test_name) > 0 && !empty($test_name[0])) || (sizeof($te_name) > 0 && !empty($te_name[0]))){	 	
		 	
			 	for($i=0; $i<count($tdata['test_id']); $i++) {

		            if(empty($tdata['test_id'][$i])) {
				 		$test_name['test_name'] = $this->input->post('te_name');
					 	$test_description = 'doctor';
					 	# chack the test name in the test_info table 
					 		$query = $this->db->select('*')
					 	 			->from('test_name_tbl')
					 	 			->where('test_name',$test_name['test_name'][$i])
					 	 			->get()
					 	 			->row();
							if(!empty($query)) {
								$tdata['t_id'] = $query->test_id;
							} else {
								$tesAdd = array(
									'test_name' => $test_name['test_name'][$i],
									'test_description' => $test_description
									 );

								$this->db->insert('test_name_tbl', $tesAdd);
								$tdata['t_id'] = $this->db->insert_id();
							}

						
				 	} else {
				 		$tdata['t_id'] = $tdata['test_id'][$i];
				 	}

		            $data = array(
		        		'prescription_id' => $tdata['prescription_id'],
		        		'appointment_id' => $tdata['appointment_id'],
		                'test_id'=> $tdata['t_id'],
		                'test_assign_description'=>$tdata['test_description'][$i]
		            );
	            	$this->db->insert('test_assign_for_patine', $data);
				}
			}


	#---------------------------------------------------
	#	advice assign for patient
	#---------------------------------------------------
			$a_data['appointment_id'] = $pdata['appointment_id'];
			$a_data['prescription_id'] = $mdata['prescription_id'];
		 	$a_data['advice'] = ($this->input->post('advice'));
			$num_advice = $this->input->post('advice');
		 	$num_adv    = $this->input->post('adv');
		 if((sizeof($num_advice) > 0 && !empty($num_advice[0])) || (sizeof($num_adv) > 0 && !empty($num_adv[0]))){
			
				for($i=0; $i<count($a_data['advice']); $i++) {

					if(empty($a_data['advice'][$i])) {
						
				 		$adv_name['advice'] = $this->input->post('adv');
						$adv = array(
							'advice' => $adv_name['advice'][$i],
							'create_by' => $this->session->userdata('doctor_id')
							);
						$this->db->insert('doctor_advice', $adv);
						$ad_data['advice'] = $this->db->insert_id();
				 	} else {
				 		$ad_data['advice'] = $a_data['advice'][$i];
				 	}

					$advice_data = array(
	            		'appointment_id' => $a_data['appointment_id'],
	            		'prescription_id'=> $a_data['prescription_id'],
	            		'advice_id' => $ad_data['advice']
	            	);

	            $this->db->insert('advice_prescriptiion',$advice_data);
				}
			}
			 	$d['appointment_id'] = $pdata['appointment_id'];
			 	$d['prescription_id'] = $p;
	        	$this->session->set_userdata($d);
			 	redirect("prescription");
	}

#-----------------------------------------
#		prescription search view
#-----------------------------------------		 
	public function search_prescription($search=NULL)
	{
	 	
	 	if(!empty($search)) {
		 	$appointment_id = $_GET['appointment_id']; 
		 	@$venue_id = $this->db->select('prescription_id,venue_id')->from('prescription')->where('appointment_id',$appointment_id)->get()->row();
	 		$prescription_id = $venue_id->prescription_id;

		 	 $data['patient_info'] = $this->prescription_model->prescription_by_id($prescription_id);
			    // test query
			     $data['t_info'] = $this->db->select('*')
			     ->from('test_assign_for_patine')
			     ->join('test_name_tbl', 'test_name_tbl.test_id = test_assign_for_patine.test_id')
			     ->where('test_assign_for_patine.prescription_id',$prescription_id)
			     ->get()
			     ->result();
			     
			    // advice query
			      $data['a_info'] = $this->db->select('advice_prescriptiion.*,doctor_advice.*')
			     ->from('advice_prescriptiion')
			     ->join('doctor_advice', 'doctor_advice.advice_id = advice_prescriptiion.advice_id')
			     ->where('advice_prescriptiion.prescription_id',$prescription_id)
			     ->get()
			     ->result();

			         //venue info
	          $data['venue_info'] = $this->db->select('prescription.venue_id,venue_tbl.*')
	         ->from('prescription')
	         ->join('venue_tbl', 'venue_tbl.venue_id = prescription.venue_id')
	         ->where('prescription.prescription_id',$prescription_id)
	         ->get()
	         ->row();

	 	@$venue_id = $this->db->select('prescription_id,venue_id')->from('prescription')->where('appointment_id',$appointment_id)->get()->row();
		
	     $data['chember_time'] = $this->db->select('*')
	        ->from('schedul_setup_tbl')
	        ->where('venue_id', $venue_id->venue_id)
	        ->limit(1)
	        ->get()
	        ->row();

	        $data['pattern'] = $this->db->select('*')
			->from('print_pattern')
			->where('doctor_id',$this->session->userdata('doctor_id'))
			->where('venue_id',$venue_id->venue_id)
			->get()
			->row();

	        if($data['pattern']!==NULL){
				$data['others'] = $this->load->view('pattern/'.$data['pattern']->pattern_no.'',$data,true);
			}
			$data['default'] = $this->load->view('pattern/default',$data,true); 
			$this->load->view('pattern/press',$data); 

			    //$this->load->view('public/prescription',$data);
		} else {
			$this->load->view('admin/_header');
			$this->load->view('admin/_left_sideber');
			$this->load->view('admin/view_find_prescription');
			$this->load->view('admin/_footer');
			}
	}


#-------------------------------------------
#		view prescription
#-------------------------------------------		 

	public function prescription()
	{
		$appointment_id = $this->session->userdata('appointment_id');
		@$venue_id = $this->db->select('prescription_id,venue_id')->from('prescription')->where('appointment_id',$appointment_id)->get()->row();
	 	
	 	@$prescription_id = $venue_id->prescription_id;

		$data['patient_info'] = $this->prescription_model->prescription_by_id($prescription_id);
	    
	    // test query
	     $data['t_info'] = $this->db->select('*')
	     ->from('test_assign_for_patine')
	     ->join('test_name_tbl', 'test_name_tbl.test_id = test_assign_for_patine.test_id')
	     ->where('test_assign_for_patine.prescription_id',$prescription_id)
	     ->get()
	     ->result();
	     
	    // advice query
	      $data['a_info'] = $this->db->select('advice_prescriptiion.*,doctor_advice.*')
	     ->from('advice_prescriptiion')
	     ->join('doctor_advice', 'doctor_advice.advice_id = advice_prescriptiion.advice_id')
	     ->where('advice_prescriptiion.prescription_id',$prescription_id)
	     ->get()
	     ->result();

	      //venue info
	          $data['v_info'] = $this->db->select('prescription.venue_id,venue_tbl.*')
	         ->from('prescription')
	         ->join('venue_tbl', 'venue_tbl.venue_id = prescription.venue_id')
	         ->where('prescription.prescription_id',$prescription_id)
	         ->get()
	         ->row();

	 	@$venue_id = $this->db->select('prescription_id,venue_id')->from('prescription')->where('appointment_id',$appointment_id)->get()->row();
		
	     $data['chember_time'] = $this->db->select('*')
	        ->from('schedul_setup_tbl')
	        ->where('venue_id', $venue_id->venue_id)
	        ->limit(1)
	        ->get()
	        ->row();

	        $data['pattern'] = $this->db->select('*')
			->from('print_pattern')
			->where('doctor_id',$this->session->userdata('doctor_id'))
			->where('venue_id',$venue_id->venue_id)
			->get()
			->row();

	        if($data['pattern']!==NULL){
				$data['others'] = $this->load->view('pattern/'.$data['pattern']->pattern_no.'',$data,true);
			}
			$data['default'] = $this->load->view('pattern/default',$data,true); 
			$this->load->view('pattern/press',$data); 
	    //$this->load->view('public/prescription',$data);
	    
	}

#--------------------------------------------
#		veiw my_prescription
#--------------------------------------------
	public function my_prescription($appointment_id=NULL)
	{
		@$venue_id = $this->db->select('prescription_id,venue_id')->from('prescription')->where('appointment_id',$appointment_id)->get()->row();
		@$prescription_id = $venue_id->prescription_id; 

		$data['patient_info'] = $this->prescription_model->prescription_by_id($prescription_id);
	    
	    // test query
	     $data['t_info'] = $this->db->select('*')
	     ->from('test_assign_for_patine')
	     ->join('test_name_tbl', 'test_name_tbl.test_id = test_assign_for_patine.test_id')
	     ->where('test_assign_for_patine.prescription_id',$prescription_id)
	     ->get()
	     ->result();
	     
	    // advice query
	      $data['a_info'] = $this->db->select('advice_prescriptiion.*,doctor_advice.*')
	     ->from('advice_prescriptiion')
	     ->join('doctor_advice', 'doctor_advice.advice_id = advice_prescriptiion.advice_id')
	     ->where('advice_prescriptiion.prescription_id',$prescription_id)
	     ->get()
	     ->result();

	 

	     	   //venue info
	          $data['v_info'] = $this->db->select('prescription.venue_id,venue_tbl.*')
	         ->from('prescription')
	         ->join('venue_tbl', 'venue_tbl.venue_id = prescription.venue_id')
	         ->where('prescription.prescription_id',$prescription_id)
	         ->get()
	         ->row();


 			$data['chember_time'] = $this->db->select('*')
	        ->from('schedul_setup_tbl')
	        ->where('venue_id', @$venue_id->venue_id)
	        ->limit(1)
	        ->get()
	        ->row();

	        $data['pattern'] = $this->db->select('*')
			->from('print_pattern')
			->where('doctor_id',$this->session->userdata('doctor_id'))
			->where('venue_id',@$venue_id->venue_id)
			->get()
			->row();

	        if($data['pattern']!==NULL){
				$data['others'] = $this->load->view('pattern/'.$data['pattern']->pattern_no.'',$data,true);
			}
			$data['default'] = $this->load->view('pattern/default',$data,true); 
			$this->load->view('pattern/press',$data);  

	    //$this->load->view('public/prescription',$data);
	    
	}

	public function edit_prescription(){
		$prescription_id = $this->uri->segment('4');
	 	$data['pres'] = $this->represcription->re_data($prescription_id);
	 	$data['t_info'] = $this->represcription->re_test_data($prescription_id);
	 	$data['a_info'] = $this->represcription->re_advice_data($prescription_id);
	 	$data['m_info'] = $this->represcription->re_medicine($prescription_id);
	 	#---------------------------------
	 	// doctor venue info
	 	$doctor_id = $this->session->userdata('doctor_id');
	 	@$data['venue'] = $this->db->select('venue_id,venue_name,create_id')->from('venue_tbl')->where('create_id',$doctor_id)->get()->result();
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_edit_prescription');
		$this->load->view('admin/_footer');
	}


	public function update_prescription(){

	 	$pdata['patient_id'] = $this->input->post('patient_id');
	 	$pdata['appointment_id'] = $this->input->post('appointment_id');
	 	$pdata['doctor_id'] = $this->session->userdata('doctor_id');
	 	$pdata['Pressure'] = $this->input->post('Pressure');
	 	$pdata['Weight'] = $this->input->post('Weight');
	 	$pdata['problem'] = $this->input->post('Problem');
	 	$pdata['venue_id'] = $this->input->post('venue_id');
	 	$pdata['oex'] = $this->input->post('oex');
		$pdata['pd'] = $this->input->post('pd');
		$pdata['history'] = $this->input->post('history');
		$pdata['temperature'] = $this->input->post('temperature');
		$pdata['prescription_type'] = 1;
	 	$pdata['pres_comments'] = $this->input->post('prescription_comment');
	 	$pdata['create_date_time'] = date("Y-m-d h:i:s");

		$pres_id = $this->input->post('prescription_id');
	 	$this->db->where('prescription_id',$pres_id)->delete('prescription');

	 	$this->db->insert('prescription',$pdata);

	    // get last insert id
	    $prescription_id = $this->db->insert_id();
	#----------------------------------------------------#
			 	# medicine assign for patient 
	#----------------------------------------------------#    
	    $mdata['med_type'] = $this->input->post('type');
	 	$mdata['medicine_id'] = ($this->input->post('medicine_id'));
	 	$mdata['mg'] = ($this->input->post('mg'));
	 	$mdata['dose'] = ($this->input->post('dose'));
	 	$mdata['day'] = ($this->input->post('day'));
	 	$mdata['comments'] = ($this->input->post('comments'));
	 	$mdata['appointment_id'] = $this->input->post('appointment_id');
	 	$mdata['prescription_id'] = $prescription_id;

	 	 $this->db->where('prescription_id',$pres_id)->delete('medicine_prescription');


			for($i=0; $i<count($mdata['medicine_id']); $i++) {

			 	if(empty($mdata['medicine_id'][$i])) {

			 		$md_name['medicine_name'] = $this->input->post('md_name');
				 	$create_by = $this->session->userdata('doctor_id');
				 	$med_description = 'doctor description';

				 	# chack the medicine name in the medicine_info table 
				 	$query = $this->db->select('*')
	 	 			->from('medecine_info')
	 	 			->where('medicine_name',$md_name['medicine_name'][$i])
	 	 			->get()
	 	 			->row();

	 	 			if(!empty($query)) {
						$mdata['med_id'] = $query->medicine_id;
					} else {
						$medicine = array(
						'medicine_name' => $md_name['medicine_name'][$i],
						'med_company_id' => '01',
						'med_group_id' => '01',
						'med_description' => $med_description
					);
					# insert medicine id in medicine_info table
					$this->db->insert('medecine_info',$medicine);
					# medicine id
					$mdata['med_id'] = $this->db->insert_id();
					}
			 	} else {
			 		$mdata['med_id'] = $mdata['medicine_id'][$i];
			 	}

	            $data = array(
	                    'prescription_id'=> $mdata['prescription_id'],
	                    'appointment_id'=> $mdata['appointment_id'],
	                    'medicine_id'=> $mdata['med_id'],
	                    'mg'=>$mdata['mg'][$i],
	                    'dose'=>$mdata['dose'][$i],
	                    'day'=>$mdata['day'][$i],
	                    'medicine_type' => $mdata['med_type'][$i],
	                    'medicine_com'=>$mdata['comments'][$i]
	            );

	           

	            $this->db->insert('medicine_prescription', $data);
	        }
	#----------------------------------------------------#
			 	# test assign for patient
	#----------------------------------------------------#		 	
		 	$tdata['prescription_id'] = $prescription_id;
		 	$tdata['test_id'] = ($this->input->post('test_name'));
		 	$tdata['test_description'] = ($this->input->post('test_description'));
		 	$tdata['appointment_id'] = $this->input->post('appointment_id');
		$test_name = $this->input->post('test_name');
		$te_name    = $this->input->post('te_name');

		$this->db->where('prescription_id',$pres_id)->delete('test_assign_for_patine');


		if((sizeof($test_name) > 0 && !empty($test_name[0])) || (sizeof($te_name) > 0 && !empty($te_name[0]))){	 	
		 	
		 	for($i=0; $i<count($tdata['test_id']); $i++) {

	            if(empty($tdata['test_id'][$i])) {
			 		$test_name['test_name'] = $this->input->post('te_name');
				 	$test_description = 'doctor';
				 	# chack the test name in the test_info table 
				 		$query = $this->db->select('*')
				 	 			->from('test_name_tbl')
				 	 			->where('test_name',$test_name['test_name'][$i])
				 	 			->get()
				 	 			->row();
						if(!empty($query)) {
							$tdata['t_id'] = $query->test_id;
						} else {
							$tesAdd = array(
								'test_name' => $test_name['test_name'][$i],
								'test_description' => $test_description
								 );

							$this->db->insert('test_name_tbl', $tesAdd);
							$tdata['t_id'] = $this->db->insert_id();
						}

					
			 	} else {
			 		$tdata['t_id'] = $tdata['test_id'][$i];
			 	}

	            $data = array(
	        		'prescription_id' => $tdata['prescription_id'],
	        		'appointment_id' => $tdata['appointment_id'],
	                'test_id'=> $tdata['t_id'],
	                'test_assign_description'=>$tdata['test_description'][$i]
	            );



	        	$this->db->insert('test_assign_for_patine', $data);
			}
		}


#---------------------------------------------------
#			advice assign for patient
#---------------------------------------------------
			$a_data['appointment_id'] = $this->input->post('appointment_id');
			$a_data['prescription_id'] = $mdata['prescription_id'];
		 	$a_data['advice'] = ($this->input->post('advice'));
	 		$num_advice = $this->input->post('advice');
		 	$num_adv    = $this->input->post('adv');

		 	$this->db->where('prescription_id',$pres_id)->delete('advice_prescriptiion');

		 if((sizeof($num_advice) > 0 && !empty($num_advice[0])) || (sizeof($num_adv) > 0 && !empty($num_adv[0]))){
			
			for($i=0; $i<=count($a_data['advice']); $i++) {
				if (array_key_exists($i, $a_data['advice'])) {

				if(empty($a_data['advice'][$i])) {

			 		$adv_name['advice'] = $this->input->post('adv');
					@$adv = array(
						'advice' => $adv_name['advice'][$i],
						'create_by' => $this->session->userdata('doctor_id')
						);
					$this->db->insert('doctor_advice', $adv);
					$ad_data['advice'] = $this->db->insert_id();
			 	} else {
			 		$ad_data['advice'] = $a_data['advice'][$i];
			 	}

				$advice_data = array(
            		'appointment_id' => $a_data['appointment_id'],
            		'prescription_id'=> $a_data['prescription_id'],
            		'advice_id' => $ad_data['advice']
            	);
            	$this->db->insert('advice_prescriptiion',$advice_data);
            	}
			}

		}

	 	$d['appointment_id'] = $this->input->post('appointment_id');
    	$this->session->set_userdata($d);
	 	redirect("prescription");
	}




#-----------------------------------------------
#    estimates_list
#---------------------------------------------- 
	public function estimates_list()
	{
	 	$data['Estimates'] = $this->prescription_model->estimates_list();
	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_estimates_list');
		$this->load->view('admin/_footer');
	 
	}


#------------------------------------------------
#		create_estimate view form
#------------------------------------------------		 
	public function  create_estimate()
	{
		$data['title'] = "Create Estimate ";
		$data['venue'] = $this->venue_model->get_venue_list();

		$data['Taxes'] = $this->prescription_model->get_tax_list();


	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/create_estimate');
		$this->load->view('admin/_footer');
	}


#-----------------------------------------
#	add new  estimate without ap id
#----------------------------------------	
	public function new_estimate_save()
	{

		if(empty($this->input->post('patient_id'))) {
		 	$patient_id =  $this->input->post('p_id');
		    $p_data['patient_id']=   $patient_id;
		    $p_data['venue_id']=   $this->input->post('venue_id');
		 	$p_data['patient_name']= $this->input->post('name');
		 	$p_data['patient_phone']= $this->input->post('phone');
		 	$p_data['birth_date']=   $this->input->post('birth_date');
		 	$p_data['sex']=          $this->input->post('gender');
		 	$this->db->insert('patient_tbl',$p_data);
		} else {
			 	$patient_id = $this->input->post('patient_id');
			}
			 	

			 	$pdata['patient_id'] = $patient_id;
			 	$pdata['doctor_id'] = $this->session->userdata('doctor_id');
			 	$pdata['venue_id'] = $this->input->post('venue_id');
			 	$pdata['create_date_time'] = date("Y-m-d h:i:s");

			 	$this->session->unset_userdata('v_id');
	            $session_venu = array('v_id' => $this->input->post('venue_id'));
		 		$this->session->set_userdata($session_venu);

			 	$this->db->insert('estimates',$pdata);
	            # get last insert id
	            $estimate_id = $this->db->insert_id();
	            
	            $treatment_names = $this->input->post('treatment_name');
			 	$treatment_ids = ($this->input->post('treatment_id'));
			 	$descriptions = ($this->input->post('description'));
			 	$prices = ($this->input->post('price'));
			 	$discounts = ($this->input->post('discount'));
			 	$discount_types = ($this->input->post('discount_type'));
			 	$taxes = ($this->input->post('tax'));

            $Taxes = $this->prescription_model->get_tax_list();
            $TaxesArray = array();
            if($Taxes) foreach($Taxes as $T){ 
                $TaxesArray[$T->tax_id] = $T->tax_rate;
            } 


            $overall_amount = 0;
                
			for($i=0; $i<count($treatment_ids); $i++) {
			 	
			 	$treatment_id = 0;
			 	
			 	if(empty($treatment_ids[$i])) {

				 	# chack the treatment name in the treatment_tbl table 
				 	$query = $this->db->select('*')
	 	 			->from('treatment_tbl')
	 	 			->where('treatment_name',$treatment_names[$i])
	 	 			->get()
	 	 			->row();
	 	 			if( ! empty($query)) {
						$treatment_id = $query->treatment_id;
					} else {
						$treatment = array(
						'treatment_name' => $treatment_names[$i],
						'treatment_description' => $descriptions[$i],
						'treatment_price' => $prices[$i]
					);
					# insert treatment id in treatment_tbl table
					$this->db->insert('treatment_tbl',$treatment);
					# treatment id
					$treatment_id = $this->db->insert_id();
					}

			 	} else {
			 		$treatment_id = $treatment_ids[$i];
			 	}
                
                $discount_amount = 0;
                $tax_amount = 0;
                $total_amount = $prices[$i];
                
                
                if($discounts[$i] && $discount_types[$i] == 'P')
                    $discount_amount = $total_amount * ($discounts[$i]/100);
                
                if($discounts[$i] && $discount_types[$i] == 'F')
                    $discount_amount = ($discounts[$i]);
                
                $total_amount -= $discount_amount;
                
                if($taxes[$i])
                    $tax_amount = $total_amount * ($TaxesArray[$taxes[$i]]/100);
                
                $total_amount += $tax_amount;
                
                
	            $data = array(
	                'estimate_id'=> $estimate_id,
	                'treatment_id'=> $treatment_id,
	                'treatment_name'=>$treatment_names[$i],
	                'treatment_description'=>$descriptions[$i],
	                'treatment_price'=>$prices[$i],
	                'treatment_discount'=>$discounts[$i],
	                'treatment_discount_type'=>$discount_types[$i],
	                'treatment_tax_id'=>$taxes[$i],
	                'treatment_discount_amount'=>$discount_amount,
	                'treatment_tax_amount'=>$tax_amount,
	                'treatment_total_amount'=>$total_amount
	            );

	            $this->db->insert('estimate_treatments', $data);
	            
	            $overall_amount += $total_amount;
	            }
	            
	            if($overall_amount > 0){
	                $this->db->update('estimates', array('total_amount' => $overall_amount), array('estimate_id' => $estimate_id));
	            }
	            
			 	//$d['estimate_id'] = $estimate_id;
	        	//$this->session->set_userdata($d);
			 	redirect("admin/Prescription_controller/estimates_list");
	}


}
