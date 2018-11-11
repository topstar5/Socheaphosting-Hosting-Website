<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_controller extends CI_Controller {

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
        $this->load->model('admin/Tax_model','tax_model');
	 }

	/*
	|------------------------------------
	|add tax view form
	|------------------------------------
	*/	 
	public function add_tax()
	{
		$data['title'] = "Add New Tax";
		$this->load->view('admin/_header');
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/setup/view_add_tax');
		$this->load->view('admin/_footer');
	}
	
	/*
	|--------------------------------------
	|save tax Name 
	|--------------------------------------
	*/	 
	public function save_tax(){
		$tesAdd = array(
			'tax_name' => $this->input->post('tax_name'),
			'tax_rate' => $this->input->post('tax_rate')
			 );
		$tax_name = $this->input->post('tax_name');
		
		$query = $this->db->select('*')
 	 			->from('tax_tbl')
 	 			->where('tax_name',$tax_name)
 	 			->get()
 	 			->row();
		if(!empty($query)) {
			$this->session->set_flashdata('msg','<div class="alert alert-danger msg">This Tax allrady Inserted</div><br>');
			redirect('admin/Tax_controller/add_tax');
		} else {
		$this->tax_model->insert_tax($tesAdd);
		$this->session->set_flashdata('msg', display('tax_add_msg'));
		redirect('admin/Tax_controller/add_tax');
		}
	}

	/*
	|----------------------------------------
	|tax list 
	|----------------------------------------
	*/	 
	public function tax_list()
	{
		$data['t_info']=$this->tax_model->get_taxs();

		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/setup/view_tax_list');
		$this->load->view('admin/_footer');
	}

	/*
	|---------------------------------------
	|edit tax Name 
	|---------------------------------------
	*/	 
	public function edit_tax($id=NULL)
	{
		
		$result = $this->db->select('*')
		->from('tax_tbl')
		->where('tax_id',$id)
		->get()
		->row();

		 if($result){
			echo ''.form_open('admin/Tax_controller/save_edit_tax',array('class'=>'form-horizental')).'
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
	|Edit tax Name 
	|-------------------------------------
	*/
	public function save_edit_tax()
	{
		$tesAdd = array(
		'treatment_name' => $this->input->post('treatment_name'),
		'treatment_description' => $this->input->post('treatment_description')
		 );

		$id = $this->input->post('id'); 
		$this->db->where('treatment_id',$id);
		$this->db->update('treatment_tbl',$tesAdd);

		$this->session->set_flashdata('del_msg', display('update_msg'));
		redirect('admin/Tax_controller/tax_list');
	}

	/*
	|--------------------------------------
	|save tax Name 
	|--------------------------------------
	*/	 
	public function delete_tax($id)
	{
		$this->db->where('tax_id',$id);
		$this->db->delete('tax_tbl');
		$this->session->set_flashdata('del_msg', display('delete_msg'));
		redirect('admin/Tax_controller/tax_list');
	}

}