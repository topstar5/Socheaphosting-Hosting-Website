<?php
class Represcription extends CI_model {

    public function re_data($prescription_id){

          return $query = $this->db->select("prescription.*,
             patient_tbl.patient_id,
             patient_tbl.patient_name,
             patient_tbl.patient_phone,
             patient_tbl.sex,
             patient_tbl.birth_date,
             patient_tbl.picture,
             doctor_tbl.doctor_id,
             doctor_tbl.doctor_name,
             doctor_tbl.doctor_phone,
             doctor_tbl.address,
             doctor_tbl.degrees,
             doctor_tbl.designation,
             doctor_tbl.specialist,
             doctor_tbl.service_place,
             doctor_tbl.log_id,
             medicine_prescription.*,
             medecine_info.*,
            
             log_info.email,log_info.log_id")
            ->from("prescription")
            ->join('medicine_prescription', 'medicine_prescription.prescription_id = prescription.prescription_id') 
            ->join('medecine_info', 'medecine_info.medicine_id = medicine_prescription.medicine_id') 
            ->join('patient_tbl', 'prescription.patient_id = patient_tbl.patient_id') 
            ->join('doctor_tbl', 'prescription.doctor_id = doctor_tbl.doctor_id') 
            ->join('log_info', 'log_info.log_id = doctor_tbl.log_id')
            ->where('prescription.prescription_id',$prescription_id)
            ->get()
            ->row(); 
    }

    

    public function re_medicine($prescription_id){
          return $query = $this->db->select("
             medicine_prescription.*,
             medecine_info.*")
            ->from("medicine_prescription")
            ->join('medecine_info', 'medecine_info.medicine_id = medicine_prescription.medicine_id') 
            ->where('medicine_prescription.prescription_id',$prescription_id)
            ->get()
            ->result(); 
    }


    public function re_test_data($prescription_id){
	     // test query
         return $data = $this->db->select('*')
         ->from('test_assign_for_patine')
         ->join('test_name_tbl', 'test_name_tbl.test_id = test_assign_for_patine.test_id')
         ->where('test_assign_for_patine.prescription_id',$prescription_id)
         ->get()
         ->result();
    }
    public function re_advice_data($prescription_id){     
	        // advice query
	          return $data = $this->db->select('advice_prescriptiion.*,doctor_advice.*')
	         ->from('advice_prescriptiion')
	         ->join('doctor_advice', 'doctor_advice.advice_id = advice_prescriptiion.advice_id')
	         ->where('advice_prescriptiion.prescription_id',$prescription_id)
	         ->get()
	         ->result();

	}

	public function patient_info($patient_id){
		return $data = $this->db->select('*')
				->from('patient_tbl')
				->where('patient_id',$patient_id)
				->get()
				->row();
	}


#-------------------------------------------
#
#------------------------------------------   

        public function re_generic_prescription($prescription_id){

        return $result = $this->db->select("prescription.*,
             patient_tbl.patient_id,
             patient_tbl.patient_name,
             patient_tbl.patient_phone,
             patient_tbl.sex,
             patient_tbl.birth_date,
             patient_tbl.picture,
             doctor_tbl.doctor_id,
             doctor_tbl.doctor_name,
             doctor_tbl.log_id,
             generic_tbl.*,
             medicine_group_tbl.*,
            
             log_info.email,log_info.log_id")
            ->from("prescription")
            ->join('generic_tbl', 'generic_tbl.prescription_id = prescription.prescription_id') 
            ->join('medicine_group_tbl', 'medicine_group_tbl.med_group_id = generic_tbl.group_id') 
            ->join('patient_tbl', 'prescription.patient_id = patient_tbl.patient_id') 
            ->join('doctor_tbl', 'prescription.doctor_id = doctor_tbl.doctor_id') 
            ->join('log_info', 'log_info.log_id = doctor_tbl.log_id')
            ->where('prescription.prescription_id',$prescription_id)
            ->get()
            ->row(); 
    }

        public function re_generic($prescription_id){
          return $query = $this->db->select("
             generic_tbl.*,
             medicine_group_tbl.*")
            ->from("generic_tbl")
            ->join('medicine_group_tbl', 'medicine_group_tbl.med_group_id = generic_tbl.group_id') 
            ->where('generic_tbl.prescription_id',$prescription_id)
            ->get()
            ->result(); 
    }

}