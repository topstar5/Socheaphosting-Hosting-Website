<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_company');?></h1>
            <small><?php echo display('add_company');?></small>
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
                            $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');
                            echo form_open_multipart('admin/Setup_controller/save_medicine_company', $attributes);                
                         ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('company_name');?> :</label>
                                    <div class="col-md-5">
                                        <input type="text" name="company_name" class="form-control" placeholder="<?php echo display('company_name');?>" required> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                        <button type="reset" class="btn btn-danger"><?php echo display('reset');?></button>
                                        <button type="submit" class="btn btn-success"><?php echo display('submit');?></button>
                                   
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>

            <div class="col-md-12">
                <?php
                    $msg = $this->session->flashdata('message');
                    $error = $this->session->flashdata('exception');
                    if($msg){
                        echo $msg;
                    }
                    if($error){
                        echo $error;
                    }
                ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr class="center">
                                    <th class="all"><?php echo display('company_name');?></th>
                                    <th class="all"><?php echo display('action');?> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach ($mdc_info as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value->company_name;?></td>
                                    <td class="text-right">
                                        <a href="<?php echo base_url();?>admin/Setup_controller/delete_medicine_company/<?php echo $value->company_id;?>" onclick="return confirm('Are you want to delelte?');" class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>            
    </section>
</div>


