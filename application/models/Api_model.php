<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_model {


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



/*
|------------------------------------------------
|    get all appointment data form appointment_tbl
|------------------------------------------------
*/
    public function get_appointment_list()
    {
         $result = $this->db->select('
              appointment_tbl.*,
              patient_tbl.*,venue_tbl.*')

              ->from('appointment_tbl')
              ->join('patient_tbl','patient_tbl.patient_id = appointment_tbl.patient_id')
              ->join('venue_tbl','venue_tbl.venue_id = appointment_tbl.venue_id')
              ->get()
              ->result(); 
          return $result;    
    }



/*
|------------------------------------------------
|   chack user exist or not
|------------------------------------------------
*/
public function exists_user($patient_phone,$birth_date)
{
    return $this->db->where('patient_phone',$patient_phone)
    ->where('birth_date',$birth_date)
    ->get('patient_tbl')
    ->num_rows();
}   


/*
|------------------------------------------------
|  save patient to patient_tbl
|------------------------------------------------
*/
public function save_patient($savedata)
{
      $this->db->insert('patient_tbl', $savedata);
}

/*
|------------------------------------------------
|  get_all_patient form patient_tbl
|------------------------------------------------
*/
 public function get_all_patient()
 {
      $query = $this->db->select('*')
      ->from("patient_tbl")
      ->get();
      $result = $query->result();
      return $result;
 }

/*
|------------------------------------------------
|  get_patient_indevidual_info form patient_tbl
|------------------------------------------------
*/
public function get_patient_inde_info($patient_id)
{
  
        $query = $this->db->select("*")
       ->from("patient_tbl")
       ->where("patient_id",$patient_id)
       ->get();
       $result = $query->row();
        return $result;
 }

/*
|------------------------------------------------
|  save_edit_patient to patient_tbl
|------------------------------------------------
*/
 public function save_edit_patient($savedata,$patient_id)
 {
      $this->db->where('patient_id',$patient_id);
      $this->db->update('patient_tbl',$savedata);
 }


 #----------------------------------------
#       patient appointment print info
#----------------------------------------
    public function get_appointment_print_result($appointment_id)
    {
        
       $query_result = $this->db->select("action_serial.*,
            patient_tbl.*,
            venue_tbl.*,")
              ->from('action_serial')
              ->join('patient_tbl', 'patient_tbl.patient_id = action_serial.patient_id')
              ->join('doctor_tbl', 'doctor_tbl.doctor_id = action_serial.doctor_id')
              ->join('venue_tbl', ' venue_tbl.venue_id = action_serial.venue_id')
              ->where('action_serial.appointment_id',$appointment_id)
              ->get();
        
        return $query_result->row();
         
    }

}    