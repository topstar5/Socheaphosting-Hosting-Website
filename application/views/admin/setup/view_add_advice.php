<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_advice');?></h1>
            <small><?php echo display('add_advice');?></small>
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
                        $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');
                            echo form_open_multipart('admin/Setup_controller/save_advices', $attributes);  
                    ?>
                        
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><?php echo display('advice');?> :</label>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control " placeholder="<?php echo display('advice');?>" name="advice" required > </div>
                                </div>
                            </div>
                           <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">

                                    <button type="reset" class=" btn btn-danger"><?php echo display('reset');?></button>
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
                if($msg){
                    echo $msg;
                }
               
            ?>
            <div class="panel panel-default form-panel">
              
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr class="center">
                                <th class="all"><?php echo display('advice');?></th>
                                <th class="all"><?php echo display('action');?> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($advice as $value) {
                            ?>
                            <tr>
                                <td><?php echo $value->advice;?></td>
                                <td class="text-right">
                                    <a href="<?php echo base_url();?>admin/Setup_controller/delete_advice/<?php echo $value->advice_id;?>" onclick="return confirm('Are you want to delelte?');" class="btn btn-xs btn-danger">
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



