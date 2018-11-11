<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Treatment_controller extends CI_Controller {

	/*
	|------------------------------------
	|  construction funcion
	|------------------------------------
	*/	
	public function __construct() 
	{
		parent::__construct();
	    $this->load->library('session');
		$session_id = $this->session->userdata('session_id');	
	    if($session_id == NULL ) {
	     redirect('logout');
	    }
        $this->load->model('admin/Treatment_model','treatment_model');
	 }

	/*
	|------------------------------------
	|add treatment view form
	|------------------------------------
	*/	 
	public function add_treatment()
	{
		$data['title'] = "Add New Treatment";
		$this->load->view('admin/_header');
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/setup/view_add_treatment');
		$this->load->view('admin/_footer');
	}
	
	/*
	|--------------------------------------
	|save treatment Name 
	|--------------------------------------
	*/	 
	public function save_treatment(){
		$tesAdd = array(
			'treatment_name' => $this->input->post('treatment_name'),
			'treatment_description' => $this->input->post('treatment_description'),
			'treatment_price' => $this->input->post('price')
			 );
		$treatment_name = $this->input->post('treatment_name');
		
		$query = $this->db->select('*')
 	 			->from('treatment_tbl')
 	 			->where('treatment_name',$treatment_name)
 	 			->get()
 	 			->row();
		if(!empty($query)) {
			$this->session->set_flashdata('msg','<div class="alert alert-danger msg">This Treatment allrady Inserted</div><br>');
			redirect('admin/Treatment_controller/add_treatment');
		} else {
		$this->treatment_model->insert_treatment($tesAdd);
		$this->session->set_flashdata('msg', display('treatment_add_msg'));
		redirect('admin/Treatment_controller/add_treatment');
		}
	}

	/*
	|----------------------------------------
	|treatment list 
	|----------------------------------------
	*/	 
	public function treatment_list()
	{
		$data['t_info']=$this->treatment_model->get_treatments();

		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/setup/view_treatment_list');
		$this->load->view('admin/_footer');
	}

	/*
	|---------------------------------------
	|edit treatment Name 
	|---------------------------------------
	*/	 
	public function edit_treatment($id=NULL)
	{
		
		$result = $this->db->select('*')
		->from('treatment_tbl')
		->where('treatment_id',$id)
		->get()
		->row();

		 if($result){
			echo ''.form_open('admin/Treatment_controller/save_edit_treatment',array('class'=>'form-horizental')).'
		                   <div class="form-body"> 
		                     <input type="hidden" class="form-control" value="'.$result->treatment_id.'" name="id" />
		                                <div class="form-group">
		                                    <label class="control-label col-md-3"> '.display('treatment_name').' </label>
		                                    <div class="col-md-7">
		                                        <input type="text" value="'.$result->treatment_name.'"class="form-control" name="treatment_name" />
		                                    </div>
		                                </div>

		                                <div class="form-group">
                                            <label class="col-md-3 control-label">'.display('description').' :</label>
                                            <div class="col-md-7">
                                                 <textarea name="treatment_description" class="wysihtml5 form-control" required rows="5">'.$result->treatment_description.'</textarea>
                                            </div>
                                        </div>
		                                <div class="form-group">
		                                    <label class="control-label col-md-3"> '.display('price').' </label>
		                                    <div class="col-md-7">
		                                        <input type="text" value="'.$result->treatment_price.'"class="form-control" name="treatment_price" />
		                                    </div>
		                                </div>
                         <div class="form-group">
                         <label class="col-md-8 control-label"></label>
                            <div class="col-md-3">
				             	<button class="btn btn-primary">'.display('update').'</button>
				           </div>
				           </div>
		              </div>
		         </form>
		      
		    ';
        }
	}


	/*
	|-------------------------------------
	|Edit treatment Name 
	|-------------------------------------
	*/
	public function save_edit_treatment()
	{
		$tesAdd = array(
		'treatment_name' => $this->input->post('treatment_name'),
		'treatment_description' => $this->input->post('treatment_description')
		 );

		$id = $this->input->post('id'); 
		$this->db->where('treatment_id',$id);
		$this->db->update('treatment_tbl',$tesAdd);

		$this->session->set_flashdata('del_msg', display('update_msg'));
		redirect('admin/Treatment_controller/treatment_list');
	}

	/*
	|--------------------------------------
	|save treatment Name 
	|--------------------------------------
	*/	 
	public function delete_treatment($id)
	{
		$this->db->where('treatment_id',$id);
		$this->db->delete('treatment_tbl');
		$this->session->set_flashdata('del_msg', display('delete_msg'));
		redirect('admin/Treatment_controller/treatment_list');
	}

}