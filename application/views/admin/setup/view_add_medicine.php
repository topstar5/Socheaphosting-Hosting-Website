<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_medicine');?></h1>
            <small><?php echo display('add_medicine');?></small>
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
                          $msg = $this->session->flashdata('message');
                           if($msg){
                               echo $msg;
                           }
                            $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');
                            echo form_open_multipart('admin/Setup_controller/save_medicine', $attributes);                
                         ?>
                        
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo display('medicine_name');?> :</label>
                                <div class="col-md-6">
                                    <input type="text" data-toggle="tooltip" title="Medicine Name!" name="medicine_name" autocomplete="off" class="form-control test" value="<?php  echo set_value('medicine_name'); ?>" placeholder="<?php echo display('medicine_name');?>" required > 
                                    <?php echo form_error('medicine_name', '<div class=" text-danger">', '</div>'); ?>
                                </div>
                            </div>

                           
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo display('company_name');?> :</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" autocomplete="off" id="search-box" placeholder="<?php echo display('company_name');?>" data-toggle="tooltip" title="Company Name" name="company_name" required />
                                    <input type="hidden" autocomplete="off"  name="company_id" id="search-company_id" value="" />
                                    <div id="suggesstion-box"></div>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo display('group_name');?> :</label>
                                <div class="col-md-6">
                                   <input type="text" name="group_name" autocomplete="off" id="search-group" class="form-control" data-toggle="tooltip" title="Group Name " placeholder="<?php echo display('group_name');?>" required />
                                   <input type="hidden" autocomplete="off" name="group_id" id="search-group_id" value="" />
                                   <div id="suggesstion-group"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo display('medicine_description');?> :</label>
                                <div class="col-md-6">
                                     <textarea name="description" class="form-control" rows="6"></textarea>
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


<!-- For Company sajetion -->
<script>
    $(document).ready(function(){
        $("#search-box").keyup(function(){
            $.ajax({
            type: "GET",
            url: '<?php echo base_url();?>' + 'admin/Ajax_controller/Company_sajetion/',
            data:'keyword='+$(this).val(),
            beforeSend: function(){
                $("#search-box").css("background","#FFF url(<?php echo base_url();?>image/LoaderIcon.gif) no-repeat 165px");
            },
                success: function(data){
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background","#FFF");
                }
            });
        });
    });


    $(document).ready(function(){
        $('body').on('click','#country-list > li',function(){
            $("#search-box").val($(this).html());
            $("#search-company_id").val($(this).val());
            $("#country-list").slideUp(300);
        });
    });

    //<!-- Group Sajetion -->

    $(document).ready(function(){
        $("#search-group").keyup(function(){
            $.ajax({
            type: "GET",
            url: '<?php echo base_url();?>' + 'admin/Ajax_controller/group_sajetion/',
            data:'keyword='+$(this).val(),
            beforeSend: function(){
                $("#search-group").css("background","#FFF url(<?php echo base_url();?>image/LoaderIcon.gif) no-repeat 165px");
            },
                success: function(data){
                    $("#suggesstion-group").show();
                    $("#suggesstion-group").html(data);
                    $("#search-group").css("background","#FFF");
                }
            });
        });
    });


    $(document).ready(function(){
        $('body').on('click','#group-list >',function(){
            $("#search-group").val($(this).html());
            $("#search-group_id").val($(this).val());
            $("#group-list").slideUp(300);
        });
    });

</script>            