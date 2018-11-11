<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Generic_controller extends CI_Controller {

#-----------------------------------------------
#    prescription_list
#----------------------------------------------

	public function __construct() 
	{
		parent::__construct();
	    $this->load->library('session');
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
#    Edit generic
#---------------------------------------------- 

	public function edit_generic()
	{


		$prescription_id = $this->uri->segment('4');
	 	$data['pres'] = $this->represcription->re_generic_prescription($prescription_id);
	 	$data['t_info'] = $this->represcription->re_test_data($prescription_id);
	 	$data['a_info'] = $this->represcription->re_advice_data($prescription_id);
	 	$data['m_info'] = $this->represcription->re_generic($prescription_id);

 	
	 	#---------------------------------
	 	// doctor venue info
	 	$doctor_id = $this->session->userdata('doctor_id');
	 	@$data['venue'] = $this->db->select('venue_id,venue_name,create_id')->from('venue_tbl')->where('create_id',$doctor_id)->get()->result();

	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_edit_generic');
		$this->load->view('admin/_footer');	 

	}

#-----------------------------------------------
#    Edit generic
#---------------------------------------------- 
	public function update_generic(){



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
			 	$pdata['pres_comments'] = $this->input->post('prescription_comment');
			 	$pdata['prescription_type'] = 2;
			 	$pdata['create_date_time'] = date("Y-m-d h:i:s");

			 	//print_r($pdata); exit;

			 	$prescription_id = $this->input->post('prescription_id');
			 	$this->db->where('prescription_id',$prescription_id)->delete('prescription');

			 	$this->db->insert('prescription',$pdata);

	            # get last insert id
	            $p = $this->db->insert_id();
	            
	            $mdata['med_type'] = $this->input->post('type');
			 	$mdata['group_id'] = $this->input->post('group_id');
			 	$mdata['mg'] = ($this->input->post('mg'));
			 	$mdata['dose'] = ($this->input->post('dose'));
			 	$mdata['day'] = ($this->input->post('day'));
			 	$mdata['comments'] = ($this->input->post('comments'));
			 	$mdata['appointment_id'] = $pdata['appointment_id'];
			 	$mdata['prescription_id'] = $p;

			$n = count($mdata['group_id']);
			for($i=0; $i<$n; $i++) {
			 
			 	if(empty($mdata['group_id'][$i])) {
			 		$md_name['group_name'] = $this->input->post('group_name');
				 	$create_by = $this->session->userdata('doctor_id');
				 	$med_description = 'doctor';
				 	# chack the medicine name in the medicine_info table 
				 	$query = $this->db->select('*')
	 	 			->from('medicine_group_tbl')
	 	 			->where('group_name',$md_name['group_name'][$i])
	 	 			->get()
	 	 			->row();	 	 		

	 	 			if( ! empty($query)) {
						$mdata['group_id'] = $query->med_group_id;
					} else {
						$medicine_group = array(
						'group_name' => $md_name['group_name']
					);

					# insert medicine_group id in medicine_group_info table
					$this->db->insert('medicine_group_tbl',$medicine_group);
					# medicine_group id
					$mdata['group_id'] = $this->db->insert_id();
					}
			 	} else {
			 		$mdata['group_id'] = $mdata['group_id'][$i];
			 	}

	            $gen_data = array(
	                'prescription_id'=> $mdata['prescription_id'],
	                'appointment_id'=> $mdata['appointment_id'],
	                'group_id'=> $mdata['group_id'],
	                'mg'=>$mdata['mg'][$i],
	                'dose'=>$mdata['dose'][$i],
	                'day'=>$mdata['day'][$i],
	                'medicine_type' => $mdata['med_type'][$i],
	                'medicine_com'=>$mdata['comments'][$i]
	            );
	            //print_r($gen_data); exit;

	            $this->db->where('prescription_id',$prescription_id)->delete('generic_tbl');
	            //print_r($data); exit;
	            $this->db->insert('generic_tbl', $gen_data);

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

		            $this->db->where('prescription_id',$prescription_id)->delete('test_assign_for_patine');

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

	            $this->db->where('prescription_id',$prescription_id)->delete('advice_prescriptiion');
	            	
	            $this->db->insert('advice_prescriptiion',$advice_data);
			}
		}
			 	$d['appointment_id'] = $pdata['appointment_id'];
			 	$d['prescription_id'] = $p;
	        	$this->session->set_userdata($d);
			 	redirect("admin/Generic_controller/prescription");
	}


#-----------------------------------------------
#    create generic
#---------------------------------------------- 

	public function create_new_generic()
	{
		$data['venue'] = $this->venue_model->get_venue_list();
	 	$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/view_create_generic');
		$this->load->view('admin/_footer');	 
	}

#----------------------------------------------
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

	public function save_generic()
	{
		if(empty($this->input->post('patient_id'))) {
		 	$patient_id =  $this->input->post('p_id');
		    $p_data['patient_id']=   $patient_id;
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
			 	$pdata['pres_comments'] = $this->input->post('prescription_comment');
			 	$pdata['prescription_type'] = 2;
			 	$pdata['create_date_time'] = date("Y-m-d h:i:s");

			 	$this->db->insert('prescription',$pdata);
	            
	            $this->session->unset_userdata('v_id');
	            $session_venu = array('v_id' => $this->input->post('venue_id'));
		 		$this->session->set_userdata($session_venu);
	            # get last insert id
	            $p = $this->db->insert_id();
	            
	            $mdata['med_type'] = $this->input->post('type');
			 	$mdata['group_id'] = $this->input->post('group_id');
			 	$mdata['mg'] = ($this->input->post('mg'));
			 	$mdata['dose'] = ($this->input->post('dose'));
			 	$mdata['day'] = ($this->input->post('day'));
			 	$mdata['comments'] = ($this->input->post('comments'));
			 	$mdata['appointment_id'] = $pdata['appointment_id'];
			 	$mdata['prescription_id'] = $p;

			 	
			 $n = count($mdata['group_id']);
			for($i=0; $i<$n; $i++) {


			 	if(empty($mdata['group_id'][$i])) {
			 		$md_name['group_name'] = $this->input->post('group_name');
				 	$create_by = $this->session->userdata('doctor_id');
				 	$med_description = 'doctor';
				 	# chack the medicine name in the medicine_info table 
				 	$query = $this->db->select('*')
	 	 			->from('medicine_group_tbl')
	 	 			->where('group_name',$md_name['group_name'][$i])
	 	 			->get()
	 	 			->row();	 	 		

	 	 			if( ! empty($query)) {
						$mdata['group_id'] = $query->med_group_id;
					} else {
						$medicine_group = array(
						'group_name' => $md_name['group_name']
					);

					# insert medicine_group id in medicine_group_info table
					$this->db->insert('medicine_group_tbl',$medicine_group);
					# medicine_group id
					$mdata['group_id'] = $this->db->insert_id();
					}
			 	} else {
			 		$mdata['group_id'] = $mdata['group_id'][$i];
			 	}

	            $data = array(
	                'prescription_id'=> $mdata['prescription_id'],
	                'appointment_id'=> $mdata['appointment_id'],
	                'group_id'=> $mdata['group_id'],
	                'mg'=>$mdata['mg'][$i],
	                'dose'=>$mdata['dose'][$i],
	                'day'=>$mdata['day'][$i],
	                'medicine_type' => $mdata['med_type'][$i],
	                'medicine_com'=>$mdata['comments'][$i]
	            );
	            //print_r($data); exit;
	            $this->db->insert('generic_tbl', $data);
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
			 	redirect("admin/Generic_controller/prescription");
	}


#-------------------------------------------
#		view prescription
#-------------------------------------------		 

	public function prescription()
	{
		$appointment_id = $this->session->userdata('appointment_id');
		$prescription_id = $this->session->userdata('prescription_id');
		@$venue_id = $this->db->select('prescription_id,venue_id')->from('prescription')->where('prescription_id',$prescription_id)->get()->row();
		$data['patient_info'] = $this->prescription_model->gereric_by_id($prescription_id);	    
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

				$data['others'] = $this->load->view('generic_pattern/'.$data['pattern']->pattern_no.'',$data,true);

			}

			$data['default'] = $this->load->view('generic_pattern/default',$data,true); 

			$this->load->view('generic_pattern/generic',$data);

	    //$this->load->view('public/view_generic',$data);	    

	}





#-------------------------------------------
#		view Generic
#-------------------------------------------		 

	public function generic($prescription_id=NULL)
	{
	 	// patient info
		$data['patient_info'] = $this->prescription_model->gereric_by_id($prescription_id);	    
	   
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

	 	@$venue_id = $this->db->select('prescription_id,venue_id')->from('prescription')->where('prescription_id',$prescription_id)->get()->row();
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
				$data['others'] = $this->load->view('generic_pattern/'.$data['pattern']->pattern_no.'',$data,true);
			}
			$data['default'] = $this->load->view('generic_pattern/default',$data,true); 
			$this->load->view('generic_pattern/generic',$data);
	    //$this->load->view('public/view_generic',$data);	    

	}



}

