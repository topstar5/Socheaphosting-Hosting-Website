
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1>Change password</h1>
            <small>Change password</small>
            <ol class="breadcrumb">
                            <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>
                            <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>
                        </ol>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
        <div class="col-md-12">
                <?php
                     $mag = $this->session->flashdata('message');
                     $errormessage = $this->session->flashdata('errormessage');
                        if($mag!='') {
                            echo '<div class="alert alert-success alert-dismissable ">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>WOW!</strong>'.$mag.'
                                </div>';
                             $this->session->unset_userdata('message');
                        }
                        if($errormessage!='') {
                            echo '<div class="alert alert-block alert-danger fade in">
                            <button type="button" class="close" data-dismiss="alert"></button>
                            <p>'.$errormessage.'</p>
                            </div>';
                             $this->session->unset_userdata('errormessage');
                        }
                  ?>
            <div  class="panel panel-default panel-form">
                <div class="panel-body">
                    <div class="portlet-body form">

                        <?php 
                         $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');
                        echo form_open('admin/Setting_controller/change_password_save', $attributes);  
                        ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Old Password</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-lg" placeholder="Enter Your Old Password" name="old_password" required > 
                                     <span class="error-msg"><?php echo form_error('old_password'); ?> </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">New Password</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-lg" placeholder="Enter Your New Password" name="new_password" required > 
                                   <span class="error-msg"><?php echo form_error('new_password'); ?> </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Confirm Password</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-lg" placeholder="Enter Your Confirm New Password" name="confirm_password" required > 
                                    <span class="error-msg"><?php echo form_error('confirm_password'); ?> </span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-actions text-right">
                                <button type="submit" class="text-right btn btn-success">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>            
    </section>
</div>



