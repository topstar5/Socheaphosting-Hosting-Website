<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('create_trade')?></h1>
            <small><?php echo display('create_trade')?></small>
            <ol class="breadcrumb">
                <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>
                <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>
            </ol>
        </div>
    </section>

    


    <!-- Main content -->
    <section class="content">
                        <?php 
                if(!empty($patient_info)){
            ?>
               
            <div class="row">
                    <?php 
                        $attributes = array('class' =>'form-horizontal','method'=>'post','role'=>'form');
                        echo form_open('admin/Prescription_controller/save_prescription', $attributes);
                    ?>
                    <div class="col-md-12">
                        <div  class="panel panel-default panel-form">
                            <div class="panel-body">
                                <div class="portlet-body form">
                                <!--  -->
                                    <!-- patinet info -->
                                <!--  -->
                                <div class="portlet-title">
                                    <div class="row">
                                         <div class="col-xs-12">
                                            <div class="caption">
                                                <span class=""><b><?php echo display('patient_name')?> : </b></span><?php echo @$patient_info->patient_name;?>,&nbsp&nbsp&nbsp
                                                <span class=""><b><?php echo display('age')?> : </b></span>
                                                <?php
                                                    $date1=date_create(@$patient_info->birth_date);
                                                    $date2= date_create( date('y-m-d'));
                                                    $diff=date_diff($date1,$date2);
                                                    echo @$diff->format("%Y-Y:%m-M:%d-D");
                                                  ?>,&nbsp&nbsp&nbsp 
                                                <span class=""><b><?php echo display('sex')?> : </b></span><?php echo @$patient_info->sex;?>,&nbsp&nbsp&nbsp
                                                <span class=""><b><?php echo display('patient_id')?> : </b></span><?php echo @$patient_info->patient_id;?>,&nbsp&nbsp&nbsp
                                                <span class=""><b><?php echo display('appointment_id')?> : </b></span><?php echo @$patient_info->appointment_id;?>,&nbsp&nbsp&nbsp
                                            </div>
                                           
                                        </div>
                                    </div> <hr/>

                                     <input type="hidden" name="patient_id" value="<?php echo @$patient_info->patient_id;?>"> 
                                     <input type="hidden" name="appointment_id" value="<?php echo @$patient_info->appointment_id;?>"> 
                                     <input type="hidden" name="venue_id" value="<?php echo @$patient_info->venue_id;?>"> 
                                    <div class="portlet-title">
                                         <div class="form-group ">
                                            <div class="col-md-6"><input type="text" class="form-control"  placeholder="<?php echo display('patient_cc')?>" name="Problem"  value=" <?php echo @$patient_info->problem;?>"/></div>
                                            <div class="col-md-2"><input type="text" class="form-control "  placeholder="<?php echo display('patient_weight')?>" name="Weight" value=""/></div> 
                                            <div class="col-md-2"><input type="text" class="form-control"  placeholder="<?php echo display('patient_bp')?>" name="Pressure"  value=""/></div>
                                            <div class="col-md-2"><input type="text" class="form-control"  placeholder="<?php echo display('temperature')?>" name="temperature"  value=""/></div>
                                        </div>
                                    </div><hr/>
                                    <div class="portlet-title">
                                         <div class="form-group ">
                                            <div class="col-md-4"><input type="text" class="form-control"  placeholder="<?php echo display('history')?>" name="history" /></div>
                                            <div class="col-md-4"><input type="text" class="form-control"  placeholder="<?php echo display('oex')?>" name="oex" /></div>
                                            <div class="col-md-4"><input type="text" class="form-control"  placeholder="<?php echo display('pd')?>" name="pd" value=""/></div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="portlet-title">
                                    <div class="row">
                                        <!-- -->
                                            <!-- Madicine area -->
                                        <!--  -->
                                    <div class="col-sm-12 col-xs-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr> 
                                                    <td colspan="6" class="m_add_btn"><?php echo display('medicine')?> <a href="javascript:void(0);"  class="btn btn-primary add_button pull-right" title="Add field"><span class="glyphicon glyphicon-plus"></span><?php echo display('add')?></a></td>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="field_wrapper">
                                                            <div class="form-group ">
                                                                <div class="col-md-1">
                                                                     <input type="text"  class="form-control" name="type[]"  placeholder="Type" />
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="hidden" class="mdcn_value" name="medicine_id[]" value="" />
                                                                    <input type="text"  class="mdcn_name form-control" name="md_name[]" autocomplete="off" placeholder="<?php echo display('medicine_name')?>" />
                                                                    <div id="suggesstion-box"></div>
                                                                </div>

                                                                 <div class="col-md-2" ><input type="text"  class="form-control"  placeholder="<?php echo display('mgml')?>L" name="mg[]"  /></div> 
                                                                 <div class="col-md-1" ><input type="text"  class="form-control"  placeholder="<?php echo display('dose')?>" name="dose[]"  /></div>
                                                                 <div class="col-md-1"><input type="text"  class="form-control"  placeholder="<?php echo display('day')?>" name="day[]"  /></div>
                                                                 <div class="col-md-3"><input type="text"  class="form-control"  placeholder="<?php echo display('medicine_comment')?>" name="comments[]"  /></div> 
                                                                <a href="javascript:void(0);" class=" btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a>
                                                            </div> 
                                             
                                                        </div>    
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="form-group col-md-12">
                                                             <textarea placeholder="<?php echo display('overal_comment')?>" name="prescription_comment" class="form-control" rows="2"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- -->
                                        <!-- Test area  -->
                                    <!-- -->
                                    <div class="col-sm-6 col-xs-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr> 
                                                     <td colspan="6" class="t_add_btn"><?php echo display('test')?> 
                                                        <a href="javascript:void(0);"  class="btn btn-primary add_button1 pull-right" title="Add field"><span class="glyphicon glyphicon-plus"></span><?php echo display('add')?> </a>
                                                     </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td> 
                                                            <div class="field_wrapper1">
                                                                <div id="count_test1">
                                                                <div class="form-group ">
                                                                    <div class="col-md-5">
                                                                        <input type="hidden" class="test_value" name="test_name[]" value="" />
                                                                        <input placeholder="<?php echo display('test_name')?>"   class="test_name form-control" name="te_name[]" autocomplete="off" >
                                                                        <div id="test-box"></div>
                                                                    </div>
                                                                    <div class="col-md-5"> 
                                                                        <input placeholder="<?php echo display('description')?>" name="test_description[]" class="form-control"> 
                                                                    </div>
                                                                        <a href="javascript:void(0);" class=" btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a>
                                                                </div>
                                                            </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
<!-- ================================================ -->
                                <!-- Advice area  -->
<!-- ================================================ -->
                                            
                                        <div class="col-sm-6 col-xs-12">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr> 
                                                         <td colspan="6" class="a_btn"><?php echo display('advice')?>
                                                            <a href="javascript:void(0);"  class="btn btn-primary add_advice pull-right" title="Add field"> <span class="glyphicon glyphicon-plus"></span><?php echo display('add')?></a>
                                                         </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                 <div class="field_wrapper2">
                                                                    <div id="count_advice1">
                                                                        <div class="form-group ">
                                                                            <div class="col-md-10">
                                                                                <input type="hidden" class="advice_value" name="advice_name[]" value=""/>
                                                                                <input placeholder="<?php echo display('advice')?>" class="advice_name form-control" name="adv[]" autocomplete="off" >
                                                                                <div  id="advice-box"></div>
                                                                            </div><a href="javascript:void(0);" class=" btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    

                                    <div class="form-group row">
                                        <div class="col-sm-offset-9 col-sm-6">
                                            <button type="reset" class="btn btn-danger"><?php echo display('reset')?></button>
                                            <button type="submit" class="btn btn-success"><?php echo display('submit')?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php } else { 
                 echo "<div class='alert alert-danger msg'> <strong>Sorry!</strong> The Appointment id Wrong.</div><br>";
                }
    ?>

    </section>

</div>





<!-- =========================================== -->
            <!--  medicine info -->
<!-- ===========================================-->
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 50; 
            var addButton = $('.add_button'); 
            var wrapper = $('.field_wrapper');
           
            var x = 1; 
            var counter = 2;
            $(addButton).on('click',function(){ 
                if(x < maxField){ 
                    var fieldHTML = '<div id="count_'+(counter++)+'">'+
                    '<div class="form-group mdcn">'+
                    '<div class="col-md-1" >'+
                    '<input type="text"  class="form-control" name="type[]"  placeholder="<?php echo display('type')?>"  />'+
                    '</div>'+ 
                     '<div class="col-md-3">'+
                     '<input type="hidden" class="mdcn_value" name="medicine_id[]" value="" />'+
                     '<input type="text"  class="mdcn_name form-control" name="md_name[]"  placeholder="<?php echo display('medicine_name')?>" autocomplete="off" required />'+
                     '<div  id="suggesstion-box"></div>'+
                     '</div>'+
                     '<div class="col-md-2"><input type="text"  class="form-control "  placeholder="<?php echo display('mgml')?>" name="mg[]" value=""/></div>'+ 
                     '<div class="col-md-1"><input type="text"  class="form-control"  placeholder="<?php echo display('dose')?>" name="dose[]" /></div>'+
                     '<div class="col-md-1"><input type="text"  class="form-control"  placeholder="<?php echo display('day')?>" name="day[]" /></div>'+
                     '<div class="col-md-3"><input type="text"  class="form-control"  placeholder="<?php echo display('medicine_comment')?>" name="comments[]" /></div>'+ 
                   
                    '<a href="javascript:void(0);" class="btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a></div>'+
                    '</div>';  

                    x++; 
                    $(wrapper).append(fieldHTML); 
                }
            });


        $('table').on('keyup',".mdcn_name",function(){  
            
            var output = $(this).next(); 
            $.ajax({
            type: "GET",
            url: '<?php echo base_url();?>' + 'admin/Ajax_controller/medicine_sajetion/',
            data:'keyword='+$(this).val(), 
                success: function(data){ 
                    $(output).html(data); 
                }
            });
        });

 

        $('body').on('click','#country-list > li',function(){
            var mdcn_name_val = $(this).val();
            var mdcn_name_txt = $(this).text();

            var target_val = $(this).parent().parent().prev().prev(); 
            var target_text = $(this).parent().parent().prev(); 

            $(target_val).val(mdcn_name_val); //value passing
            $(target_text).val(mdcn_name_txt); //value passing

            $(this).parent().slideUp(300); 
        });

        $(wrapper).on('click', '.remove_button', function(e){ 
            e.preventDefault();
            $(this).parent('div').remove(); 
            x--; 
        });


        });


//<!-- ============================================= -->
                //<!-- test info -->
//<!-- ============================================= -->
   
        $(document).ready(function(){

            var maxField = 50; 
            var testButton = $('.add_button1'); 
            var wrapper = $('.field_wrapper1'); 
            var counter = 2;
            var x = 1; 

            $(testButton).click(function(){ 
                if(x < maxField){
                  var fieldHTML = '<div id="count_test'+(counter++)+'">'+
                '<div class="form-group ">'+
                 '<div class="col-md-5">'+
                 '<input type="hidden" class="test_value" name="test_name[]" value="" />'+
                 ' <input placeholder="<?php echo display('test_name')?>" class="test_name form-control" name="te_name[]" autocomplete="off"  >'+
                 ' <div id="test-box"></div>'+
                 '</div>'+
                 '<div class="col-md-5"> <input placeholder="<?php echo display('description')?>" name="test_description[]" class="form-control"  rows="2"></div>'+
                
               '<a href="javascript:void(0);" class="btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a></div>'+
                '</div>';

                  $(wrapper).append(fieldHTML);
                }

            });

            $('table').on('keyup',".test_name",function(){  
                var output = $(this).next(); 
                $.ajax({
                    type: "GET",
                    url: '<?php echo base_url();?>' + 'admin/Ajax_controller/test_sajetion/',
                    data:'keyword='+$(this).val(),
                    success: function(data){ 
                        $(output).html(data); 
                    } 
                });
            });
        
            $('body').on('click','#country-list > li',function(){
                var test_name_val = $(this).val();
                var test_name_txt = $(this).text();

                var target_val = $(this).parent(); 
                var target_text = $(this).parent(); 

                $(target_val).val(test_name_val); //value passing
                $(target_text).val(test_name_txt); //value passing
                $(this).parent().slideUp(300); 
            });


            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                x--; 
            });
        });


//<!-- ========================================= -->
        //<!--  advice info -->
//<!-- ========================================= -->

        $(document).ready(function(){

            var maxField = 50; 
            var add_advice = $('.add_advice'); 
            var wrapper = $('.field_wrapper2'); 
            var counter = 2;
            var x = 1; 

            $(add_advice).click(function(){ 
                if(x < maxField){
                  var fieldHTML = '<div id="count_add'+(counter++)+'">'+
                '<div class="form-group ">'+
                 '<div class="col-md-10">'+
                 '<input type="hidden" class="advice_value" name="advice[]" value="" />'+
                 ' <input placeholder="<?php echo display('advice')?>" class="advice_name form-control" name="adv[]" autocomplete="off">'+
                 ' <div style="position:absolute;z-index:9999;" id="advice-box"></div>'+
                 '</div>'+
                
               '<a href="javascript:void(0);" class="btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a></div>'+
                '</div>';

                  $(wrapper).append(fieldHTML);
                }

            });

            $('table').on('keyup',".advice_name",function(){  
                var output = $(this).next(); 
                $.ajax({
                    type: "GET",
                    url: '<?php echo base_url();?>' + 'admin/Ajax_controller/advice_sajetion/',
                    data:'keyword='+$(this).val(),
                    success: function(data){ 
                        $(output).html(data); 
                    } 
                });
            });
        
            $('body').on('click','#country-list > li',function(){
                var advice_name_val = $(this).val();
                var advice_name_txt = $(this).text();

                var target_val = $(this).parent(); 
                var target_text = $(this).parent(); 

                $(target_val).val(advice_name_val); //value passing
                $(target_text).val(advice_name_txt); //value passing
                $(this).parent().slideUp(300); 
            });


            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                x--; 
            });
        });
    </script>
