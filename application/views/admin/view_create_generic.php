<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('create_generic')?></h1>
            <small><?php echo display('create_generic')?></small>
            <ol class="breadcrumb">
                <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>
                <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>
            </ol>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
                 <div class="row">

             <?php 
                $attributes = array( 'class' => 'form-horizontal','method'=>'post','name'=>'n_p');
                echo form_open_multipart('admin/Generic_controller/save_generic', $attributes);
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
                                            <div class="portlet-title">
                                                 <div class="form-group ">
                                                 

                                                    <div class="col-md-12">
                                                        <select class="form-control" name="venue_id" required>
                                                            <option value="">--Select Venue--</option>
                                                            <?php foreach($venue as $v_enue){
                                                            echo '<option value="'. $v_enue->venue_id.'">'.$v_enue->venue_name.'</option>';
                                                             } ?>
                                                        </select>  
                                                        
                                                    </div><br><hr/>
                                                    
                                                    <div class="col-md-12 ">
                                                        <div id="ab"></div>
                                                    </div>
                                                    <div class="col-md-2 pid" >
                                                        <input type="text" name="p_id" id="p_id" onkeyup="loadName(this.value);" class="form-control" placeholder="<?php echo display('patient_id')?>"> 
                                                    </div>

                                                    <div class="had">
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control"  placeholder="<?php echo display('patient_name')?>" name="name" required>
                                                        </div>
                                                        <input type="hidden" name="patient_id" required>
                                                       
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control"  placeholder="<?php echo display('phone_number')?>" name="phone" required>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" name="birth_date"  class="form-control datepicker1 birth_date"  placeholder="<?php echo display('birth_date')?>" required>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text" name="age" id="age" class="form-control" placeholder="<?php echo display('age')?>">
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="md-radio">
                                                                <input type="radio" id="lb1"  name="gender"  value="Male">
                                                                <label for="lb1"> <?php echo display('male')?></label>
                                                            
                                                                <input type="radio" id="lb2"  name="gender" value="Female">
                                                                 
                                                                <label for="lb2"> <?php echo display('female')?></label>
                                                            
                                                                <input type="radio" id="lb3" name="gender" value="Others">
                                                                 
                                                                <?php echo display('other')?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div> <hr/>

                                    <div class="portlet-title">
                                         <div class="form-group ">
                                            <div class="col-md-6"><input type="text" class="form-control"  placeholder="<?php echo display('patient_cc')?>" name="Problem" /><samp></div>
                                            <div class="col-md-2"><input type="text" class="form-control"  placeholder="<?php echo display('patient_weight')?>" name="Weight" value=""/></div> 
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

            <!-- END PATIENT AREA -->

                            <div class="portlet-title">
                                <div class="row">
                                    <!--  -->
                                       <!-- Madicine area -->
                                    <!-- -->
                                            <div class="col-sm-12 col-xs-12">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr> 
                                                            <td colspan="6" class="m_add_btn"><?php echo display('medicine')?> <a href="javascript:void(0);"  class="btn btn-primary add_button pull-right" title="Add field"> <span class="glyphicon glyphicon-plus"></span><?php echo display('add')?></a></td>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="field_wrapper">
                                                                    <div class="form-group ">
                                                                         <div class="col-md-1 col-xs-12">
                                                                            <input type="text"  class="form-control" name="type[]"  placeholder="<?php echo display('type')?>" />
                                                                            
                                                                        </div>
                                                                         <div class="col-md-3">
                                                                            <input type="hidden" class="mdcn_value" name="group_id[]" value="" id="search-group_id" />
                                                                            <input type="text"  class="group_name form-control"  name="group_name[]" id="search-group" autocomplete="off" placeholder="Generic Name" />
                                                                            <div id="suggesstion-box"></div>
                                                                            
                                                                         </div>

                                                                         <div class="col-md-2" ><input type="text"  class="form-control"  placeholder="<?php echo display('mgml')?>" name="mg[]" /></div> 
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
                                <!-- start Test area  -->
                                <!-- -->
                                            <div class="col-sm-6 col-xs-12">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr> 
                                                             <td colspan="6" class="t_add_btn"><?php echo display('test')?> 
                                                                <a href="javascript:void(0);"  class="btn btn-primary add_button1 pull-right" title="Add field"><span class="glyphicon glyphicon-plus"></span><?php echo display('add')?></a>
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
                                                                                <input placeholder="<?php echo display('description')?>" name="test_description[]" class="form-control" >
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

                                    <!--  -->
                                    <!-- Advice area  -->
                                    <!--  -->
                                            
                                            <div class="col-sm-6 col-xs-12">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr> 
                                                             <td colspan="6" class="a_btn"><?php echo display('advice')?> 
                                                                <a href="javascript:void(0);"  class="btn btn-primary add_advice pull-right" title="Add field"><span class="glyphicon glyphicon-plus"></span><?php echo display('add')?></a>
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
                                                                                <input type="hidden" class="advice_value" name="advice[]" value=""/>
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
    </section>

</div>    





<script type="text/javascript">

document.forms['n_p'].elements['venue_id'].value="<?php echo $this->session->userdata('v_id');?>";       
    // load patient name
    function loadName(){          
        var patient_id = document.getElementById('p_id').value;
        if (patient_id!='') {
            $.ajax({ 

                'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/load_patient_info/'+patient_id.trim(),
                'type': 'GET',
                'dataType': 'JSON',
                'success': function(data){ 
                $('[name="name"]').val(data.patient_name);
                $('[name="phone"]').val(data.patient_phone);
                $('[name="birth_date"]').val(data.birth_date);
                $('[name="patient_id"]').val(data.patient_id);

                var container = $("#ab");
                   // alert(data.patient_id);
                    if(data==0){
                        container.html("<div class='alert alert-success'><span class='glyphicon glyphicon-ok'><strong><?php echo display('patient_id_msg')?></strong></div>");
                         
                    }else{ 
                        //$(".had").hide();
                        container.html(data);
                    }
                }
            });
        }else{
            $(".had").show();
            $(".p_name").hide();
        };
    }

// =========================================== -->
     // medicine info -->
// ===========================================-->
        $(document).ready(function(){
            var maxField = 50; 
            var addButton = $('.add_button'); 
            var wrapper = $('.field_wrapper');
            var x = 1; 
            var counter = 2;
            $(addButton).click(function(){ 
                if(x < maxField){ 
                    var fieldHTML = '<div id="count_'+(counter++)+'">'+
                    '<div class="form-group mdcn">'+
                    '<div class="col-md-1">'+
                    '<input type="text"  class="form-control" name="type[]"  placeholder="<?php echo display('type')?>"  />'+
                    '</div>'+ 
                     '<div class="col-md-3">'+
                     '<input type="hidden" class="mdcn_value" name="group_id[]" value="" />'+
                     '<input type="text"  class="group_name form-control" name="group_name[]"  placeholder="<?php echo display('generic_name')?>" autocomplete="off" required />'+
                     '<div id="suggesstion-box"></div>'+
                     '</div>'+

                     
                     '<div class="col-md-2"><input type="text"  class="form-control "  placeholder="<?php echo display('mgml')?>" name="mg[]" value=""/></div>'+ 
                     '<div class="col-md-1"><input type="text"  class="form-control"  placeholder="<?php echo display('dose')?>" name="dose[]" /></div>'+
                     '<div class="col-md-1"><input type="text"  class="form-control"  placeholder="<?php echo display('day')?>" name="day[]" /></div>'+
                     '<div class="col-md-3"><input type="text"  class="form-control"  placeholder="<?php echo display('medicine_comment')?>" name="comments[]" /></div>'+ 
                   
                    '<a href="javascript:void(0);" class=" btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a></div>'+
                    '</div>';  

                    x++; 
                    $(wrapper).append(fieldHTML); 
                }
            });


        $('table').on('keyup',".group_name",function(){  
            var output = $(this).next(); 
            $.ajax({
            'type': 'GET',
            url: '<?php echo base_url();?>' + 'admin/Ajax_controller/group_sajetion/',
            data:'keyword='+$(this).val(),
                success: function(data){ 
                    $(output).html(data); 
                }
            });
        });

 

        $('body').on('click','#group-list > li',function(){
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

// ============================================= -->
                // test info -->
// ============================================= -->
  
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
                
               '<a href="javascript:void(0);" class=" btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a></div>'+
                '</div>';
                  $(wrapper).append(fieldHTML);
                }

            });

            $('table').on('keyup',".test_name",function(){  
                var output = $(this).next(); 
                $.ajax({
                   'type': 'GET',
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
                
            var target_val = $(this).parent().parent().prev().prev(); 
            var target_text = $(this).parent().parent().prev(); 

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
  

// ========================================= -->
        //  advice info -->
// ========================================= -->
   
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
                
               '<a href="javascript:void(0);" class=" btn btn-danger remove_button" title="Remove field"><span class="glyphicon glyphicon-trash"></span></a></div>'+
                '</div>';

                  $(wrapper).append(fieldHTML);
                }
            });

            $('table').on('keyup',".advice_name",function(){  
                var output = $(this).next(); 
                $.ajax({
                    'type': 'GET',
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
  
  // age to birth date convert
    $(document).ready(function(){
        $("#age").keyup(function(){
           var age = (this.value);
           if(age !==''){
              $.ajax({
                    'url': '<?php echo base_url();?>' + 'admin/Ajax_controller/age_to_birthdate/'+age.trim(),
                    'type': 'GET', 
                    'data': {'age': age },
                    'success': function(data) { 
                        var container = $(".birth_date");
                        if(data==0){
                            container.val("0000-00-00");
                        }else{ 
                            container.val(data); 
                        }
                    }
                });
            }

        });
    })

</script>
