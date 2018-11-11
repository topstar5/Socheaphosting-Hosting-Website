
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('create_appointment')?></h1>
            <small><?php echo display('create_appointment')?></small>
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
                      $mag = $this->session->flashdata('exception');
                      if($mag !=''){
                            echo '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                 <strong>'.$mag.'</strong>
                            </div>';
                        }
                        $attributes = array('class' => 'form-horizontal','target'=>'_blank','method'=>'post','name'=>'p_info');
                        echo form_open('admin/Appointment_controller/save_appointment', $attributes);                
                    ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo display('date')?> :</label>
                                <div class="col-md-5">
                                   <input type="text" id="date" value="<?php echo set_value('date'); ?>" name="date" class="form-control datepicker3"  placeholder="<?php echo display('date_placeholder')?>" required>
                                    <span class="error-msg"><?php echo form_error('date'); ?> </span>
                                 </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo display('patient_id')?> :</label>
                                <div class="col-md-5">
                                    <input type="text" name="p_id" id="patient_id" onkeyup="loadName(this.value);" class="form-control" placeholder="<?php echo display('patient_id')?>" value="<?php echo isset($a[0]['p_id']) ? $a[0]['p_id'] : set_value('p_id'); ?>" required> 
                                    <span class="error-msg"><?php echo form_error('p_id'); ?> </span>
                                    <span class='p_name' class="error-msg"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label "><?php echo display('venue')?> :</label>
                                <div class="col-md-5">
                                    <select class="form-control v_name" id="venue" onchange="loadSchedul(this.value);" name="venue" value="<?php echo set_value('venue')?>" required>
                                        <option value="">--Select Venue--</option>
                                        <?php foreach ($venue_info as $value) {
                                            echo '<option value="'.$value->venue_id.'">'.$value->venue_name.'</option>';
                                        }?>
                                    </select>
                                    <span class="error-msg"><?php echo form_error('venue'); ?> </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo display('choose_serial')?> :</label>
                                    <div class="col-md-5 schedul">
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo display('patient_cc')?>:</label>
                                <div class="col-md-5">
                                     <textarea name="problem" class="form-control" rows="3">
                                     </textarea>
                                      <span class="error-msg"><?php echo form_error('problem'); ?> </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                        <button type="reset" class="btn btn-danger"><?php echo display('reset')?></button>
                                        <button type="submit" disabled class="btn btn-success"><?php echo display('appointment')?></button>
                                </div>
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

<style type="text/css">
    .p_name{
        color:red;
    }
</style>


<script>
    // load patient name
    function loadName(){          
        var patient_id = document.getElementById('patient_id').value;

        if (patient_id!='') {
            $('button[type=submit]').prop('disabled', true);
            $.ajax({ 
                'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/get_patinet_name/'+patient_id.trim(),
                'type': 'GET', //the way you want to send data to your URL
                'data': {'patient_id': patient_id },
                'success': function(data) { 
                    var container = $(".p_name");
                    if(data==0){
                        container.html("<?php echo display('patient_name_load_msg')?>");
                    }else{ 
                        container.html(data);
                        $('button[type=submit]').prop('disabled', false);
                    }
                }
            });
        };
    }

// load load schedul
    function loadSchedul(){
        var venue_id = $('#venue').val();
        var date     = $('#date').val();
        
        if (venue_id!='') {
            $.ajax({ 
                // 'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/get_schedul/'+venue_id.trim(),
                'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/get_schedul/'+venue_id+'/'+date,
                'type': 'GET', //the way you want to send data to your URL
                'data': {'patient_id': venue_id },
                'success': function(data) {
                    var container = $(".schedul");
                    container.html(data);
                }
                });
            };
        }

// sequence uncion
    function myBooking(data){
        var id = $("#t_" + data).text();
       document.getElementById("msg_c").innerHTML = "<div style=' color:green; font-size:20px;'><?php echo display('book_sequence')?> " +id +"</div>";
       document.getElementById('serial_no').value = id;        
    }     

</script>