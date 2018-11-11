<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_model {

/*
|------------------------------------------------
|   get_doctor_info form doctor_tbl
|------------------------------------------------
*/
    public function get_doctor_info()
    {
        $query = $this->db->select('*')
        ->from('doctor_tbl')
        ->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

/*
|------------------------------------------------
|    save_edit_dcotor_profile to doctor_tbl
|------------------------------------------------
*/
    public function save_edit_dcotor_profile($savedata,$doctor_id)
    {
        $this->db->where('doctor_id',$doctor_id)
        ->update('doctor_tbl',$savedata);
    }

}       