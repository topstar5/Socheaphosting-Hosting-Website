

<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('edit_patient'); ?></h1>
            <small><?php echo display('edit_patient'); ?></small>
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
                         $mag = $this->session->flashdata('message');
                          if($mag !=''){
                              echo "<div class='alert alert-success msg'>".$mag."</div><br>";
                          }
                        $attributes = array('class' => 'form-horizontal','method'=>'post','name'=>'p_info','role'=>'form');
                        echo form_open_multipart('admin/Patient_controller/edit_save_patient', $attributes);                
                        ?>
                        
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><span class="required"> </span> <?php echo display('name');?> </label>
                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" value="<?php echo $patient_info->patient_name; ?>" placeholder="<?php echo display('name');?>"> 
                                        <span class="error-msg"><?php echo form_error('name'); ?> </span>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('birth_date');?></label>
                                    <div class="col-md-6">
                                       <input type="text" value="<?php echo $patient_info->birth_date;?>" autocomplete="off" name="birth_date" class="form-control datepicker1" placeholder="<?php echo display('date_placeholder');?>">
                                     </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><span class="required"> </span><?php echo display('phone_number');?></label>
                                    <div class="col-md-6">
                                        <input type="number" value="<?php echo $patient_info->patient_phone;?>"  name="phone" class="form-control" placeholder="<?php echo display('phone_number');?>"> 
                                        <span class="error-msg"><?php echo form_error('phone'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('sex');?></label>
                                    <div class="col-md-6">
                                        <input type="radio" id="checkbox2_5" name="gender" <?php echo ($patient_info->sex=='Male')?'checked':'' ?> required value="Male">
                                        <label for="checkbox2_5"> <?php echo display('male');?></label>
                                        <input type="radio" id="checkbox2_10" name="gender" required <?php echo ($patient_info->sex=='Female')?'checked':'' ?> value="Female">
                                        <label for="checkbox2_10"> <?php echo display('female');?></label>

                                        <input type="radio" id="checkbox2_0" name="gender" required <?php echo ($patient_info->sex=='other')?'checked':'' ?> value="other">
                                        <label for="checkbox2_0"> <?php echo display('others');?></label>
                                    </div>
                                </div>

       
                               
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('blood_group');?> </label>
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
                                    <label class="col-md-3 control-label"><?php echo display('address');?></label>
                                    <div class="col-md-6">
                                         <textarea name="address" value="<?php echo $patient_info->address;?>" class="ckeditor form-control" rows="6">
                                            <?php echo $patient_info->address;?>
                                         </textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('picture');?></label>
                                    <div class="col-md-6">
                                        <img src="<?php echo $patient_info->picture;?>" > 
                                        <input type="file" name="picture">
                                    </div>
                                </div>
                                <input type='hidden' name="patient_id" value="<?php echo $patient_info->patient_id; ?>">
                                <input type='hidden' name="image" value="<?php echo $patient_info->picture; ?>">

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                        <button type="submit" class="btn btn-success"><?php echo display('update');?></button>
                                  
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
document.forms['p_info'].elements['blood_group'].value="<?php echo $patient_info->blood_group;?>";
</script>