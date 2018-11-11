<style type="text/css">
    .google-map iframe{
        width: 200px;
        height: 100px;
    }
</style>
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('venue_list');?></h1>
            <small><?php echo display('venue_list');?></small>
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
                      if($mag !=''){
                        echo $mag ;
                    }
                ?>
              <div  class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive order-table">
                            <table class="table table-bordered table-hover tablesaw tablesaw-stack">
                                <thead>
                                    <tr>
                                        <th >#SL</th>
                                        <th ><?php echo display('venue_name');?></th>
                                        <th ><?php echo display('venue_contact');?></th>
                                        <th ><?php echo display('venue_address');?></th>
                                        <th ><?php echo display('venue_map');?></th>
                                        <th ><?php echo display('action');?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    if(!empty($venue_info)){
                                    foreach ($venue_info as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $value->venue_name;?></td>
                                        <td><?php echo $value->venue_contact;?></td>
                                        <td><?php echo $value->venue_address;?></td>
                                        <td>
                                            <div class="google-map">
                                                 <?php echo @$value->venue_map;?>
                                            </div>
                                        </td>
                                        <td style="width:100px;" class="">
                                            <a href="<?php echo base_url();?>admin/Venue_controller/edit_venue/<?php echo $value->venue_id;?>" class="btn btn-xs btn-info">
                                            <i class="fa fa-edit"></i> </a>
                                            <a href="<?php echo base_url();?>admin/Venue_controller/delet_venue/<?php echo $value->venue_id;?>" class="btn btn-xs btn-danger">
                                            <i class="fa fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                    <?php
                                         }
                                     }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>            
    </section>
</div>



