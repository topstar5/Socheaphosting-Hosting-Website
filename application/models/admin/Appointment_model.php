<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_model {


    public function Check_appointment($date=NULL,$patient=NULL){
      
       return $result = $this->db->select('*')
        ->from('appointment_tbl')
        ->where('date',$date)
        ->where('patient_id',$patient)
        ->get()
        ->result();
    }
/*
|------------------------------------------------
|    save appointment data to appointment_tbl
|------------------------------------------------
*/
    public function SaveAppoin($savedata)
    {
        $this->db->insert('appointment_tbl',$savedata);
    }

    public function Save_sms_info($save_sms_info){
      $this->db->insert('sms_info',$save_sms_info);
    }

    // save email information in email_info table
    public function Save_email_info($save_email_info){
      $this->db->insert('email_info',$save_email_info);
    }

/*
|------------------------------------------------
|    get all appointment data form appointment_tbl
|------------------------------------------------
*/
    public function get_appointment_list()
    {
         $result = $this->db->select("action_serial.*,doctor_tbl.*,
                  patient_tbl.*,
                  venue_tbl.*,")

                  ->from('action_serial')

                  ->join('patient_tbl', 'patient_tbl.patient_id = action_serial.patient_id')
                  
                  ->join('doctor_tbl', 'doctor_tbl.doctor_id = action_serial.doctor_id')
                  
                  ->join('venue_tbl', ' venue_tbl.venue_id = action_serial.venue_id')
                  ->get()
                  ->result(); 
          return $result;    
    }

}    