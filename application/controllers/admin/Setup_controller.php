<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_controller extends CI_Controller {

#--------------------------------
#      __constructor function	
#--------------------------------	
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
		$this->load->model('admin/Setup_model','setup_model');
}

#--------------------------------
#      Insert_Medicine_form	
#--------------------------------	
public function add_medicine()
{
	$data['title'] = "Add New Medicine";
	$data['mdc_info'] = $this->setup_model->getMedicineCompanyInfo();;
	$data['group_info'] = $this->setup_model->getGroupInfo();

    $this->load->view('admin/_header',$data);
    $this->load->view('admin/_left_sideber');
    $this->load->view('admin/setup/view_add_medicine');
    $this->load->view('admin/_footer');
}


#--------------------------------
#      Save_Medicine	
#--------------------------------	
	public function save_medicine()
	{
		// chack previus medicine name insert
		$query = $this->db->select('*')
 	 			->from('medecine_info')
 	 			->where('medicine_name',$this->input->post('medicine_name'))
 	 			->get()
 	 			->row();

		if( ! empty($query)) {
			$this->session->set_flashdata('message','<div class="alert alert-danger msg">'.display('exist_error_msg').'</div><br>');
			redirect('admin/Setup_controller/add_medicine');
		} else {

			//company name insert
			if(empty($this->input->post('company_id'))) {
				$company  = array('company_name' =>$this->input->post('company_name'));
				
				$this->db->insert('medicine_company_info',$company);
							
				$company_id = $this->db->insert_id();
					
			 	} else {
			 		$company_id = $this->input->post('company_id');
			 	}
			 //group name insert	
			if(empty($this->input->post('group_id'))) {
				$group['group_name'] = $this->input->post('group_name');
				$this->db->insert('medicine_group_tbl',$group);
				$group_id = $this->db->insert_id();
					
			 	} else {
			 		$group_id = $this->input->post('group_id');
			 	}

			$medicine = array(
				'medicine_name' => $this->input->post('medicine_name'),
				'med_company_id' => $company_id,
				'med_group_id' => $group_id,
				'med_description' => $this->input->post('description')
			);
		$this->db->insert('medecine_info',$medicine);
		$this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('medicine_add_msg').'</div><br>');
		redirect('admin/Setup_controller/add_medicine');
		}
	}

#--------------------------------
#      insert medicine company	
#--------------------------------
	public function add_medicine_company()
	{
		$data['title'] = "Add Medicine Company";
		$data['mdc_info'] = $this->setup_model->getMedicineCompanyInfo();
        $this->load->view('admin/_header',$data);
        $this->load->view('admin/_left_sideber');
        $this->load->view('admin/setup/view_add_medicine_company');
        $this->load->view('admin/_footer');
	}


#--------------------------------
#      Save_Medicine_company	
#--------------------------------
public function save_medicine_company()
{	
	$c_name = $this->input->post('company_name'); 
	$query = $this->db->select('*')
	 			->from('medicine_company_info')
	 			->where('company_name',$c_name)
	 			->get()
	 			->row();



	if(!empty($query)) {
		$this->session->set_flashdata('message','<div class="alert alert-danger msg">'.display('exist_error_msg').'</div><br>');
		redirect('admin/Setup_controller/add_medicine_company');
	} else {
		$company  = array('company_name' =>$this->input->post('company_name'));
		$this->db->insert('medicine_company_info',$company);
		$this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('company_add_msg').'</div><br>');
		redirect('admin/Setup_controller/add_medicine_company');
	}
}

#--------------------------------
#      delete company	
#--------------------------------
	public function delete_medicine_company($id=NULL)
	{
		$this->db->where('company_id',$id)
		->delete('medicine_company_info');
		$this->session->set_flashdata('exception','<div class="alert alert-danger msg">'.display('delete_msg').'</div><br>');
		redirect('admin/Setup_controller/add_medicine_company');
	}

#--------------------------------
#      View Medicine list	
#--------------------------------
public function medicine_List()
{
	$data['title'] = "Medicine List";
	$data['medicine'] = $this->setup_model->getMedicineList();
    $this->load->view('admin/_header',$data);
    $this->load->view('admin/_left_sideber');
    $this->load->view('admin/setup/view_medicine_list');
    $this->load->view('admin/_footer');
}

#--------------------------------
#      inset advice form	
#--------------------------------	
public function advice()
{
	$data['advice'] = $this->db->select('*')
	->from('doctor_advice')
	->get()
	->result();
	
	$this->load->view('admin/_header',$data);
    $this->load->view('admin/_left_sideber');
    $this->load->view('admin/setup/view_add_advice');
    $this->load->view('admin/_footer');
}

#--------------------------------
#     save advice 
#--------------------------------	
	public function save_advices()
	{
		$advice['create_by'] = 1;
		$advice['advice'] = $this->input->post('advice'); 
		$this->db->insert('doctor_advice',$advice);
		$this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('advice_add_msg').'</div>');
	 	redirect('admin/Setup_controller/advice');
	}

#--------------------------------
#      delete advice 	
#--------------------------------	
	public function delete_advice($id){
		$this->db->where('advice_id',$id
			)->delete('doctor_advice');
		$this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('delete_msg').'</div>');
	 	redirect('admin/Setup_controller/advice');
	}

#--------------------------------
#      Delete_Medicine	
#--------------------------------
	public function delete_medicine($id=NULL)
	{
		$this->db->where('medicine_id',$id)->delete('medecine_info');
		$this->session->set_flashdata('exception','<div class="alert alert-danger msg">'.display('delete_msg').'</div><br>');
		redirect('Medicine_List');
	}

#--------------------------------
#      Edit_Medicine view form	
#--------------------------------
	public function edit_medicine($id=NULL)
	{
		$data['medicine'] = $this->setup_model->getMedicineOne($id);
        $this->load->view('admin/_header',$data);
        $this->load->view('admin/_left_sideber');
        $this->load->view('admin/setup/view_medicine_edit');
        $this->load->view('admin/_footer');
	}

#--------------------------------
#      Save_Edit_Medicine	
#--------------------------------
	public function save_edit_medicine()
	{
		$medicine = array(
			'medicine_name' => $this->input->post('medicine_name'),
			'med_company_id' => $this->input->post('company_id'),
			'med_group_id' => $this->input->post('group_id'),
			'med_description' => $this->input->post('description')
		);
		$id = $this->input->post('id');

		$this->db->where('medicine_id',$id);
		$this->db->update('medecine_info',$medicine);
		$this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('update_msg').'</div><br>');
		redirect('admin/Setup_controller/medicine_List');
	}

#--------------------------------
#      insert medicine group	
#--------------------------------
	public function add_medicine_group()
	{
		$data['group_info'] = $this->setup_model->getGroupInfo();        
        $this->load->view('admin/_header',$data);
        $this->load->view('admin/_left_sideber');
        $this->load->view('admin/setup/view_add_medicine_group');
        $this->load->view('admin/_footer');
	}

#--------------------------------
#      Save_Group	
#--------------------------------
	public function save_medicine_group()
	{

		$g_name = $this->input->post('group_name');
		$query = $this->db->select('*')
 	 			->from('medicine_group_tbl')
 	 			->where('group_name',$g_name)
 	 			->get()
 	 			->row();

		if( ! empty($query)) {
			$this->session->set_flashdata('message','<div class="alert alert-danger msg">'.display('exist_error_msg').'</div><br>');
			redirect('admin/Setup_controller/add_medicine_group');
		} else {
		$group['group_name'] = $this->input->post('group_name');
		$this->db->insert('medicine_group_tbl',$group);
		$this->session->set_flashdata('message','<div class="alert alert-success msg">'.display('group_add_msg').'</div><br>');
		redirect('admin/Setup_controller/add_medicine_group');
		}
	}

#--------------------------------
#      Delete group	
#--------------------------------	
	public function delete_group($id)
	{
		$this->db->where('med_group_id',$id)
		->delete('medicine_group_tbl');

		$this->session->set_flashdata('exception','<div class="alert alert-success msg">'.display('delete_msg').'</div><br>');
		redirect('admin/Setup_controller/add_medicine_group');
	}

}		