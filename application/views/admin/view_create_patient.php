
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_new_patient'); ?></h1>
            <small><?php echo display('add_new_patient'); ?></small>
            <ol class="breadcrumb">
                            <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>
                            <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>
                        </ol>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
    <!--  form area -->
        <div class="col-sm-12">
            <div  class="panel panel-default panel-form">
                <div class="panel-body">
                    <div class="portlet-body form">
                        <?php 
                            $msg = $this->session->flashdata('message');
                              if($msg !=''){
                                  echo $msg;
                              }
                              if($this->session->flashdata('exception')!=""){
                                 echo $this->session->flashdata('exception');
                            }
                            $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');
                            echo form_open_multipart('admin/Patient_controller/save_patient', $attributes);                
                         ?>
                        

                            <div class="form-body">
                            
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('venue'); ?> </label>
                                    <div class="col-md-6">
                                    <select class="form-control" name="venue_id" required>
                                        <option value="">--Select Venue--</option>
                                        <?php foreach($venue as $v_enue){
                                        echo '<option value="'. $v_enue->venue_id.'">'.$v_enue->venue_name.'</option>';
                                         } ?>
                                    </select> 
                                        <span class="error-msg"><?php echo form_error('venue_id'); ?> </span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('name'); ?> </label>
                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>" required placeholder="<?php echo display('name'); ?>" > 
                                        <span class="error-msg"><?php echo form_error('name'); ?> </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('patient_id'); ?> </label>
                                    <div class="col-md-6">
                                        <input type="text" onkeyup="load_patient_id()" id="patient_id" autocomplete="off" name="patient_id" class="form-control" required value="<?php echo set_value('patient_id'); ?>" placeholder="<?php echo ($patient_id_auto_generate == 'on') ? $patient_id_prefix.'XXXXX (Auto Generate)' : display('patient_id'); ?>" <?php if($patient_id_auto_generate == 'on') echo 'readonly="readonly"'; ?>> 
                                        <span class="error-msg"><?php echo form_error('patient_id'); ?> </span>
                                        <span class="p_id"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('email'); ?></label>
                                    <div class="col-md-6">
                                        <input type="text" name="email" value="<?php echo set_value('email'); ?>" class="form-control" required placeholder="<?php echo display('email'); ?>"> 
                                        <span class="error-msg"><?php echo form_error('email'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('birth_date'); ?></label>
                                    <div class="col-md-4 ">
                                       <input type="text" name="birth_date" value="" class="form-control datepicker1 birth_date"  placeholder="<?php echo display('date_placeholder'); ?>">
                                    </div>
                                    <div class="col-md-2 ">
                                       <input type="text" name="old" id="old" class="form-control" placeholder="<?php echo display('age'); ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('phone_number'); ?></label>
                                    <div class="col-md-6">
                                        <input type="text"  name="phone" value="<?php echo set_value('phone'); ?>" class="form-control" required placeholder="<?php echo display('phone_number'); ?>"> 
                                        <span class="error-msg"><?php echo form_error('phone'); ?></span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('sex'); ?></label>
                                    <div class="col-md-6">
                                        <input type="radio" id="checkbox2_5" name="gender" required value="Male">
                                        <label for="checkbox2_5"> <?php echo display('male'); ?></label>
                                        <input type="radio" id="checkbox2_10" name="gender" required value="Female">
                                        <label for="checkbox2_10"> <?php echo display('female'); ?></label>

                                        <input type="radio" id="checkbox2_0" name="gender" required value="other">
                                        <label for="checkbox2_0"> <?php echo display('others'); ?></label>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('blood_group'); ?> </label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="blood_group">
                                            <option value=''>--Select Blood Group--</option>
                                            <option value='A+'>A+</option>
                                            <option value='A-'>A-</option>
                                            <option value='B+'>B+</option>
                                            <option value='B-'>B-</option>
                                            <option value='O+'>O+</option>
                                            <option value='O-'>O-</option>
                                            <option value='AB+'>AB+</option>
                                            <option value='AB-'>AB-</option>
                                            <option value='Unknown'>Unknown</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo display('address'); ?></label>
                                    <div class="col-md-6">
                                         <textarea name="address" id="editor1" value="<?php echo display('address'); ?>" class="form-control" rows="6"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('picture'); ?></label>
                                    <div class="col-md-6">
                                        <input type="file" name="picture">       
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="reset" class="btn btn-danger"><?php echo display('reset')?></button>
                                    <button type="submit" class="btn btn-success"><?php echo display('submit')?></button>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>            
    </section>
</div>




<script type="text/javascript">
    $(document).ready(function(){
        $("#old").on('keyup',function(){
               var age = (this.value);
               if(age !==''){
              $.ajax({
                    'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/age_to_birthdate/'+age.trim(),
                    'type': 'GET', 
                    'data': {'age': age },
                    'success': function(data) { 
                        var container = $(".birth_date");
                        if(data==0){
                            container.val("0000-00-00");
                        }else{ 
                            container.val(data); 
                        }
                    }
                });
            }
        });
    })
</script>



<script>
    // load patient name
    function load_patient_id(){          
        var patient_id = document.getElementById('patient_id').value;
        if (patient_id!='') {
            
            $.ajax({ 
                'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/get_patinet_id/'+patient_id.trim(),
                'type': 'GET', //the way you want to send data to your URL
                'data': {'patient_id': patient_id },
                'success': function(data) { 
                    var container = $(".p_id");
                    if(data==0){
                        container.html("<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span><?php echo display('patient_id_msg')?></div>");
                        $('button[type=submit]').prop('disabled', false);
                    }else{ 
                        container.html(data);
                        $('button[type=submit]').prop('disabled', true);
                    }
                }
            });
        };
    }
</script>