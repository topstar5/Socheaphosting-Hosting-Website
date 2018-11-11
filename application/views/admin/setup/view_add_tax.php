<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <div class="header-icon">

            <i class="pe-7s-world"></i>

        </div>

        <div class="header-title">

            <h1><?php echo display('add_tax');?></h1>

            <small><?php echo display('add_tax');?></small>

            <ol class="breadcrumb">

                            <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>

                            <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>

                        </ol>

        </div>

    </section>



    <!-- Main content -->

    <section class="content">

            <div class="row">

        <div class="col-md-12 ">

            <div  class="panel panel-default panel-form">

                <div class="panel-body">

                    <div class="portlet-body form">

                        <?php

                              $msg = $this->session->flashdata('msg');

                                if($msg){

                                    echo "<div class='alert alert-success msg'>".$msg."</div><br>";

                                }

                            $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');

                            echo form_open_multipart('admin/Tax_controller/save_tax', $attributes);                

                        ?>

                        

                            <div class="form-body">

                                 <div class="form-group">

                                    <label class="col-md-3 control-label"><?php echo display('tax_name');?> :</label>

                                    <div class="col-md-8">

                                        <input type="text" name="tax_name" class="form-control" required placeholder="<?php echo display('tax_name');?>">

                                    </div>

                                </div>

                              
                                 <div class="form-group">

                                    <label class="col-md-3 control-label"><?php echo display('tax_rate');?> :</label>

                                    <div class="col-md-8">

                                        <input type="text" name="tax_rate" class="form-control" required placeholder="<?php echo display('tax_rate');?>">

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

    </div>            

    </section>

</div>







