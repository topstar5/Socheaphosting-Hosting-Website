<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Venue_model extends CI_model {

/*
|--------------------------------------------------------------
|       Schedule data save
|--------------------------------------------------------------
*/

 	 public function save_venue($savedata)
     {
	 	$this->db->insert('venue_tbl', $savedata);
 	 }

/*
|--------------------------------------------------------------
|       Get all Schedule data 
|--------------------------------------------------------------
*/
 	public function get_venue_list()
    {
            $query = $this->db->select('*')
                ->from('venue_tbl')
                ->get();
                 if($query->num_rows()>0){
                        return $query->result();
                 }else{
                        return false;
                 }
 	}
/*
|--------------------------------------------------------------
|       Get all Schedule data 
|--------------------------------------------------------------
*/
 	public function get_inde_venue($id)
    {
        $query = $this->db->select('*')
        ->from('venue_tbl')
        ->where('venue_id',$id)
        ->get();
         if($query->num_rows()>0){
                return $query->row();
         }else{
                return false;
        }
 	}



/*
|--------------------------------------------------------------
|       Save edit Schedule data 
|--------------------------------------------------------------
*/
 	 public function save_edit_venue($savedata,$s_id)
     {
 	 	$this->db->where('venue_id',$s_id);
        $this->db->update('venue_tbl',$savedata);
 	 }

}