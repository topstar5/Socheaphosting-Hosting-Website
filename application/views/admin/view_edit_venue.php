<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('edot_venue');?></h1>
            <small><?php echo display('edot_venue');?></small>
            <ol class="breadcrumb">
                            <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>
                            <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>
                        </ol>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
        <!--  form area-->
        <div class="col-sm-12">
            <div  class="panel panel-default panel-form">
                <div class="panel-body">
                    <div class="portlet-body form">
                        <?php
                            $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');
                            echo form_open_multipart('admin/Venue_controller/save_edit_venue', $attributes);                
                         ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('venue_name');?> :</label>
                                    <div class="col-md-7">
                                        <input type="text" name="name" class="form-control" value="<?php echo $venue_info->venue_name; ?>" placeholder="<?php echo display('venue_name');?>"> 
                                    <?php echo form_error('name', '<div class=" text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo display('venue_contact');?> :</label>
                                    <div class="col-md-7">
                                        <input type="text" name="phone" value="<?php echo $venue_info->venue_contact;?>" class="form-control" placeholder="<?php echo display('venue_contact');?>"> 
                                    <?php echo form_error('phone', '<div class=" text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('venue_address');?> :</label>
                                    <div class="col-md-7">
                                         <textarea name="address"  value="<?php echo $venue_info->venue_address;?>" class=" form-control" rows="6">
                                          <?php echo $venue_info->venue_address;?>
                                         </textarea>
                                        <?php echo form_error('address', '<div class=" text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('venue_map');?> :</label>
                                    <div class="col-md-7">
                                         <textarea name="venue_map" rows="6" class=" form-control">
                                            <?php echo $venue_info->venue_map;?>
                                         </textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="<?php echo $venue_info->venue_id;?>">
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


