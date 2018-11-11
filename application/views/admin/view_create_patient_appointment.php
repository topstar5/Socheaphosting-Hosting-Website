<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('create_appointment');?></h1>
            <small><?php echo display('create_appointment');?></small>
            <ol class="breadcrumb">
                <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>
                <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>
            </ol>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
        <div class="col-sm-8 col-md-offset-2">
            <div id="print">             
               <a href="" onclick="printContent('printid')">
                    <img src="<?php echo base_url();?>assets/images/print.png" height="30" width="40">
               </a>                
            </div>

           <div id="printid" class="printpage">
                 <h2><?php echo display('register_information');?></h2>

                <?php if(!empty($info['picture'])) { ?>
                  <img width="200" class="ap_img" src="<?php echo @$info['picture'];?>">
                  <?php }else{ ?>
                <img width="200" class="ap_img" src="<?php echo base_url();?>assets/images/male.png">
                <?php } ?>
                    <table class="">
                        <tr>
                            <td><?php echo display('patient_name');?> : </td>
                            <td> <?php echo @$info['patient_name'];?> </td>
                        </tr>

                        <tr>
                            <td><?php echo display('phone_number');?> : </td>
                            <td> <?php echo @$info['patient_phone'];?> </td>
                        </tr>

                        <tr>
                            <td><?php echo display('address');?> : </td>
                            <td> <?php echo @$info['address'];?> </td>
                        </tr>

                        <tr>
                          <td><?php echo display('birth_date');?> : </td>
                            <td> 
                              <?php 
                               @$date1 = date_create($info['birth_date']);
                                echo date_format($date1,"d-M-Y")
                              ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo display('sex');?> : </td>
                            <td> <?php echo @$info['sex'];?> </td>
                        </tr>

                        <tr>
                            <td><?php echo display('blood_group');?> : </td>
                            <td> <?php echo @$info['blood_group'];?> </td>
                        </tr>

                        <tr>
                            <td><?php echo display('patient_id');?>: </td>
                            <td id="font_style"> <?php echo @$info['patient_id'];?> </td>
                        </tr>
                        <tr>
                            <td><?php echo display('date');?> : </td>
                            <td> <?php echo @$info['create_date'];?></td>
                        </tr>
                    </table>
                </div>
        </div>    
    </div>
</section>
    

 <section class="content">

    <div class="row">
        <!--  form area -->
        <div class="col-sm-12">
                <div class="breadcrumbs ng-scope">
                    <h2><?php echo display('create_appointment');?></h2>
                </div>
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
                        $attributes = array('class' => 'form-horizontal','target'=>'_blank','method'=>'post','name'=>'p_info','role'=>'form');
                        echo form_open('admin/Appointment_controller/save_appointment', $attributes);                
                    ?>
                        <div class="form-body">

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('date');?></label>
                                    <div class="col-md-5">
                                       <input type="text" id="date" value="<?php echo set_value('date'); ?>" name="date" class="form-control datepicker1"  placeholder="yyyy-mm-dd" required>
                                        <span class="error-msg"><?php echo form_error('date'); ?> </span>
                                     </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><span class="required"> * </span> <?php echo display('patient_id');?></label>
                                    <div class="col-md-5">
                                        <input type="text" value="<?php echo @$info['patient_id'];?>" name="p_id" id="patient_id" onkeyup="loadName(this.value);" class="form-control" placeholder="<?php echo display('patient_id');?>" value="<?php echo isset($a[0]['p_id']) ? $a[0]['p_id'] : set_value('p_id'); ?>" required> 
                                        <span class="error-msg"><?php echo form_error('p_id'); ?> </span>
                                        <span class='p_name' class="error-msg"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label "><span class="required"> * </span> <?php echo display('venue');?> </label>
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
                                    <label class="col-md-3 control-label"><?php echo display('choose_serial');?></label>
                                    <div class="col-md-5 schedul">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo display('patient_cc');?></label>
                                    <div class="col-md-5">
                                         <textarea name="problem" class="form-control" rows="3">
                                         </textarea>
                                          <span class="error-msg"><?php echo form_error('problem'); ?> </span>
                                    </div>
                                </div>


                          <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                     <button type="reset" class="btn btn-danger"><?php echo display('reset')?></button>
                                    <button type="submit" class="btn btn-success"><?php echo display('submit')?></button>
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





<script>

    // patient information print
    function printContent(el){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }

    // load patient name
    function loadName(){          
        var patient_id = document.getElementById('patient_id').value;

        if (patient_id!='') {
            $('input[type=submit]').prop('disabled', true);
            $.ajax({ 
                'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/get_patinet_name/'+patient_id.trem(),
                'type': 'GET', //the way you want to send data to your URL
                'data': {'patient_id': patient_id },
                'success': function(data) { 
                    var container = $(".p_name");
                    if(data==0){
                        container.html("<?php echo display('patient_name_load_msg')?>");
                    }else{ 
                        container.html(data);
                        $('input[type=submit]').prop('disabled', false);
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
        
// sequence 
    function myBooking(data){
       var id = $("#t_" + data).text();
       document.getElementById("msg_c").innerHTML = "<div style=' color:green; font-size:20px;'><?php echo display('book_sequence')?> " +id +"</div>";
       document.getElementById('serial_no').value = id;        
    }     

</script>