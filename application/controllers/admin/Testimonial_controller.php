<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_controller extends CI_Controller {

/*
|--------------------------------------
|   constructor funcion
|--------------------------------------
*/ 
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');
		$session_id = $this->session->userdata('session_id'); 
     
	    if($session_id == NULL ){
	     redirect('logout');
	    }

	    $this->load->model('admin/Testimonial_model','testimonial_model');

	}

#------------------------------------------------
#       view create new post form
#------------------------------------------------
	public function index()
	{
    $data['title'] = "Add New Post";
		$this->load->view('admin/_header',$data);
		$this->load->view('admin/_left_sideber');
		$this->load->view('admin/websetting/view_create_new_testimonial');
		$this->load->view('admin/_footer');
	}

#-------------------------------------------------
#  post list
#------------------------------------------------- 
	public function testimonial_list($search=NULL)
	{
    $data['title'] = "Post List";
    $data['post_info'] = $this->blog_model->get_all_post();
   	$this->load->view('admin/_header',$data);
    $this->load->view('admin/_left_sideber');
    $this->load->view('admin/websetting/view_testimonial_list');
    $this->load->view('admin/_footer');
	}

#-------------------------------------------------
#  save_testimonial
#------------------------------------------------- 
  public function save_testimonial()
  {
      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('details', 'Details', 'trim|required');      
      if ($this->form_validation->run()==true) {
          // get picture data
          if (@$_FILES['picture']['name']){

              $config['upload_path']   = './assets/uploads/blog/';
              $config['allowed_types'] = 'gif|jpg|jpeg|png';
              $config['overwrite']     = false;
              $config['max_size']      = 1024;
              $config['remove_spaces'] = true;
              $config['max_filename']   = 10;
              $config['file_ext_tolower'] = true;
              
              $this->load->library('upload', $config);
              if (!$this->upload->do_upload('picture')){
                  $this->session->set_flashdata('exception',"<div class='alert alert-danger msg'>".display('image_upload_msg')."</div>");
              redirect('admin/Blog_controller');
              } else {
                $data = $this->upload->data();
                $image = base_url($config['upload_path'].$data['file_name']);
              }
            } else {
              $image = "NULL";
            }

            if(!empty($this->session->userdata('doctor_id'))){
              $post_by = $this->session->userdata('doctor_id');
            } else {
              $post_by = $this->session->userdata('user_id');
            }

            $create_date = date('Y-m-d');

            $savedata =  array(
            'title' => $this->input->post('title',TRUE),
            'details' => $this->input->post('details',true),
            'picture' => $image,
            'post_by' => $post_by,
            'post_date'=>$create_date
            );

            $savedata = $this->security->xss_clean($savedata); 
            $this->blog_model->save_new_post($savedata);
             $this->session->set_flashdata('message','<div class="alert alert-success">'.display('post_add_msg').'</div>');
            redirect('admin/Blog_controller');
        } else {
          $data['title'] = "Add New Post";
          $this->load->view('admin/_header',$data);
          $this->load->view('admin/_left_sideber');
          $this->load->view('admin/websetting/view_create_new_post');
          $this->load->view('admin/_footer');
        }
  }

#-------------------------------------------------
#  save_edit_post
#------------------------------------------------- 
  public function edit_post($id=NULL)
  {
    $data['title'] = "Edit Post";
    $data['post_info'] = $this->blog_model->get_post_by_id($id);
    $this->load->view('admin/_header',$data);
    $this->load->view('admin/_left_sideber');
    $this->load->view('admin/websetting/view_edit_post');
    $this->load->view('admin/_footer');
  }
#-------------------------------------------------
#  post list
#------------------------------------------------- 
  public function save_edit_post()
  {
      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('details', 'Details', 'trim|required');      
      if ($this->form_validation->run()==true) {
          // get picture data
          if (@$_FILES['picture']['name']){

              $config['upload_path']   = './assets/uploads/blog/';
              $config['allowed_types'] = 'gif|jpg|jpeg|png';
              $config['overwrite']     = false;
              $config['max_size']      = 1024;
              $config['remove_spaces'] = true;
              $config['max_filename']   = 10;
              $config['file_ext_tolower'] = true;
              
              $this->load->library('upload', $config);
              if (!$this->upload->do_upload('picture')){
                  $this->session->set_flashdata('exception',"<div class='alert alert-danger msg'>".display('image_upload_msg')."</div>");
              redirect('admin/Blog_controller/post_list');
              } else {
                $data = $this->upload->data();
                $image = base_url($config['upload_path'].$data['file_name']);
              }
            } else {
              $image = $this->input->post('pic',TRUE);
            }

            if(!empty($this->session->userdata('doctor_id'))){
              $post_by = $this->session->userdata('doctor_id');
            } else {
              $post_by = $this->session->userdata('user_id');
            }
            
            $savedata =  array(
            'title' => $this->input->post('title',TRUE),
            'details' => $this->input->post('details',TRUE),
            'picture' => $image
            );
            $id = $this->input->post('id');
            $savedata = $this->security->xss_clean($savedata); 
            $this->blog_model->save_update_post($savedata,$id);
            $this->session->set_flashdata('message','<div class="alert alert-success">'.display('update_msg').'</div>');
            redirect('admin/Blog_controller/post_list');
        } else {
         redirect('admin/Blog_controller/post_list');
        }
  }
#-------------------------------------------------
#  delete_post
#------------------------------------------------- 
    public function delete_post($id=NULL)
    {
        $this->db->where('id',$id)->delete('blog_tbl');
         $this->session->set_flashdata('message','<div class="alert alert-success">'.display('dilete_msg').'</div>');
        redirect('admin/Blog_controller/post_list');
    }






}