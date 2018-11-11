           
<script type="text/javascript">
    $(document).ready(function () {

        var segment_1 = '<?php echo $this->uri->segment(1); ?>';
        var segment_2 = '<?php echo $this->uri->segment(2); ?>';
        var segment_3 = '<?php echo $this->uri->segment(3); ?>';

        if (segment_3 === 'prescription_list' || segment_3 === 'create_new_generic'|| segment_3 === 'create_new_prescription') {
            $('.pres').addClass('active');
        }
       
        else if (segment_3 === 'estimates_list' || segment_3 === 'create_estimate') {
            $('.estimates').addClass('active');
        }
        
        else if (segment_3 === 'Payment' || segment_3 === 'Payment_manage') {
            $('.payment').addClass('active');
        }
        else if (segment_2 === 'Appointment_controller' || segment_3 === 'appointment_list') {
            $('.appointment').addClass('active');
        }

        else if (segment_1 === 'create_new_patient' || segment_1 === 'patient_list') {
            $('.patient').addClass('active');
        }
        else if (segment_3 === 'add_schedule' || segment_3 === 'schedule_list' || segment_3 ==='schedul_edit') {
            $('.schedule').addClass('active');
        }
        else if (segment_2 === 'Emergency_stop_controller') {
            $('.emergency_stop').addClass('active');
        }
        else if (segment_2 === 'Venue_controller') {
            $('.venue').addClass('active');
        }
        else if (segment_2 === 'Disease_test_controller' || segment_2 === 'Setup_controller' || segment_2 === 'Treatment_controller' || segment_2 === 'Tax_controller') {
            $('.setup_data').addClass('active');
        }
        else if (segment_2 === 'Users_controller' || segment_2 === 'Users_controller') {
            $('.users').addClass('active');
        }
        else if (segment_2 === 'Web_setup_controller' || segment_1 === 'profile') {
            $('.web_setting').addClass('active');
        }
        else if (segment_2 === 'Blog_controller' || segment_2 === 'Blog_controller') {
            $('.blog').addClass('active');
        }
        else if (segment_2 === 'Sms_setup_controller' || segment_2 === 'Sms_report_controller') {
            $('.sms_setup').addClass('active');
        }

        else if (segment_3 === 'Email') {
            $('.email').addClass('active');
        }
        else if (segment_3 === 'Print_pattern_controller') {
            $('.print_pattern').addClass('active');
        } 
    });

</script>


            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel -->

                    <?php if($this->session->userdata('user_type')==1) { ?>

                    <div class="user-panel text-center">
                        <div class="image">
                            <img src="<?php echo $this->session->userdata('doctor_picture');?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <p><?php echo $this->session->userdata('doctor_name'); ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                   
                    

                    <!-- sidebar menu -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo base_url();?>admin/Dashboard"><i class="ti-home"></i> <span><?php echo display('deashbord');?></span>
                            </a>
                        </li>

                        <li class="treeview pres">
                            <a href="#">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i><span><?php echo display('prescription')?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>admin/Prescription_controller/create_new_prescription"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('create_trade')?> </a></li>
                                <li class=""><a href="<?php echo base_url();?>admin/Generic_controller/create_new_generic"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('create_generic')?></a></li>
                                <li><a href="<?php echo base_url();?>admin/Prescription_controller/prescription_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('prescription_list')?></a></li>
                            </ul>
                        </li>

                        <li class="treeview estimates">
                            <a href="#">
                                <i class="fa fa-calculator" aria-hidden="true"></i><span><?php echo display('estimates')?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>admin/Prescription_controller/create_estimate"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('create_estimate')?> </a></li>
                                <li><a href="<?php echo base_url();?>admin/Prescription_controller/estimates_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('estimates_list')?></a></li>
                            </ul>
                        </li>

                        <li class="treeview payment">
                            <a href="#">
                                <i class="ti-paint-bucket"></i><span><?php echo display('payment');?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>admin/payment_method/Payment"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('Payment_Setup');?> </a></li>
                                <li><a href="<?php echo base_url();?>admin/payment_method/Payment_manage"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('payment_list');?></a></li>
                            </ul>
                        </li>

                        <li class="treeview appointment">
                            <a href="#">
                                <i class="fa fa-codepen" aria-hidden="true"></i><span><?php echo display('appointment')?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url()?>admin/Appointment_controller"> <i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('create_appointment')?></a></li>
                                <li><a href="<?php echo base_url()?>admin/Appointment_controller/appointment_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('appointment_list')?></a></li>
                        
                            </ul>
                        </li>

                        <li class="treeview patient">
                            <a href="#">
                                <i class="fa fa-child" aria-hidden="true"></i><span><?php echo display('patient')?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url()?>create_new_patient"> <i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('add_new_patient')?></a></li>
                                <li><a href="<?php echo base_url();?>patient_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('patient_list')?></a></li>
                            </ul>
                        </li>
                        <li class="treeview schedule">
                            <a href="#">
                               <i class="fa fa-weixin" aria-hidden="true"></i><span><?php echo display('schedule')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>admin/Schedule_controller/add_schedule"> <i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('add_schedule')?></a></li>
                                <li><a href="<?php echo base_url();?>admin/Schedule_controller/schedule_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('schedule_list')?></a></li>
                            </ul>
                        </li>

                        <li class="treeview emergency_stop">
                            <a href="#">
                               <i class="fa fa-hand-paper-o" aria-hidden="true"></i><span><?php echo display('emergency_stop')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>admin/Emergency_stop_controller"> <i class="fa fa-stop-circle" aria-hidden="true"></i> <?php echo display('emergency_stop_setup')?></a></li>
                                <li><a href="<?php echo base_url();?>admin/Emergency_stop_controller/emergency_stop_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('emergency_stop_list')?></a></li>
                            </ul>
                        </li>

                        <li class="treeview venue">
                            <a href="#">
                                <i class="fa fa-paw" aria-hidden="true"></i> <span> <?php echo display('venue')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="<?php echo base_url();?>admin/Venue_controller/create_new_venue"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('create_venue')?></a></li>
                            <li><a href="<?php echo base_url();?>admin/Venue_controller/venue_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('venue_list')?></a></li>
                            </ul>
                        </li>

                        <li class="treeview setup_data">
                            <a href="#">
                                <i class="fa fa-bar-chart-o fa-fw"></i><span> <?php echo display('setup_data')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>admin/Setup_controller/add_medicine" class="nav-link"> <?php echo display('add_medicine')?></a></li>
                                <li><a href="<?php echo base_url();?>admin/Setup_controller/medicine_List" class="nav-link"> <?php echo display('medicine_List')?></a></li>
                                <li> <a href="<?php echo base_url();?>admin/Setup_controller/add_medicine_company" class="nav-link"> <?php echo display('add_company')?></a></li>
                                <li> <a href="<?php echo base_url();?>admin/Setup_controller/add_medicine_group" class="nav-link"></i> <?php echo display('add_group')?></a></li>
                                <li> <a href="<?php echo base_url();?>admin/Setup_controller/advice" class="nav-link"> <?php echo display('add_advice')?></a></li>
                                <li> <a href="<?php echo base_url();?>admin/Disease_test_controller/add_new_test" class="nav-link"> <?php echo display('add_test_name')?></a></li>
                                <li>  <a href="<?php echo base_url();?>admin/Disease_test_controller/test_list" class="nav-link"> <?php echo display('test_list')?></a></li>
                                <li> <a href="<?php echo base_url();?>admin/Treatment_controller/add_treatment" class="nav-link"> <?php echo display('add_treatment')?></a></li>
                                <li>  <a href="<?php echo base_url();?>admin/Treatment_controller/treatment_list" class="nav-link"> <?php echo display('treatment_list')?></a></li>
                                <li> <a href="<?php echo base_url();?>admin/Tax_controller/add_tax" class="nav-link"> <?php echo display('add_tax')?></a></li>
                                <li>  <a href="<?php echo base_url();?>admin/Tax_controller/tax_list" class="nav-link"> <?php echo display('tax_list')?></a></li>
                            </ul>
                        </li>

                        <li class="treeview users">
                            <a href="#">
                               <i class="fa fa-users" aria-hidden="true"></i><span> <?php echo display('users')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url()?>admin/Users_controller/create_new_user"> <i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('add_new_user')?></a></li>
                                <li><a href="<?php echo base_url()?>admin/Users_controller/user_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('user_list')?></a></li>
                            </ul>
                        </li>

                         <li class="treeview web_setting">
                            <a href="#">
                                <i class="fa fa-cogs" aria-hidden="true"></i><span> <?php echo display('web_setting')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>admin/Web_setup_controller/header_setting" class="nav-link"><?php echo display('header_setup')?></a></li>
                                <li> <a href="<?php echo base_url();?>profile"> <?php echo display('profile')?></a></li>
                                <li><a href="<?php echo base_url();?>admin/Web_setup_controller/slider_list" class="nav-link"> <?php echo display('slider')?> </a></li>
                                <li><a href="<?php echo base_url();?>admin/Web_setup_controller/website_on_off"> <?php echo display('web_site')?> </a></li>
                                
                            </ul>
                        </li>
                        <li class="treeview blog">
                            <a href="#">
                               <i class="fa fa-barcode" aria-hidden="true"></i><span> <?php echo display('blog')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                              <li><a href="<?php echo base_url();?>admin/Blog_controller" class="nav-link"><?php echo display('add_new_post')?></a></li>
                                <li><a href="<?php echo base_url();?>admin/Blog_controller/post_list" class="nav-link"> <?php echo display('post_list')?> </a></li>
                            </ul>
                        </li>

                        <li class="treeview sms_setup">
                            <a href="#">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo display('sms_setup')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                              <li><a href="<?php echo base_url();?>admin/Sms_setup_controller/sms_gateway" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('gateway')?></a></li>
                            <li><a href="<?php echo base_url();?>admin/Sms_setup_controller/sms_template" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('sms_template')?> </a></li>
                            <li><a href="<?php echo base_url();?>admin/Sms_setup_controller/sms_scheduler" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('sms_schedule')?> </a></li>
                            <li><a href="<?php echo base_url();?>admin/Sms_setup_controller/custom_sms" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('send_custom_sms')?> </a></li>
                             <li><a href="<?php echo base_url();?>admin/Sms_report_controller/custom_sms_list" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('custom_sms_report')?> </a></li>
                            <li><a href="<?php echo base_url();?>admin/Sms_report_controller/auto_sms_list" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('auto_sms_report')?> </a></li>
                            </ul>
                        </li>

                        <li class="treeview email">
                            <a href="#">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo display('email_setup')?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                               <li><a href="<?php echo base_url();?>admin/email/Email/email_schedule_setup" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('email_schedule_setup')?>  </a></li>
                            <li><a href="<?php echo base_url();?>admin/email/Email/email_list" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('email_list')?> </a></li>
                            <li><a href="<?php echo base_url();?>admin/email/Email/custom_email" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('send_custom_email')?> </a></li>
                            <li><a href="<?php echo base_url();?>admin/email/Email/email_template_setup" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('email_template')?> </a></li>
                            <li><a href="<?php echo base_url();?>admin/email/Email/template_list" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('email_template_list')?>  </a></li>
                            <li><a href="<?php echo base_url();?>admin/email/Email/email_config_setup" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('email_configaretion')?></a></li>
                            </ul>
                        </li>

                        <li class="treeview print_pattern">
                            <a href="#">
                                <i class="fa fa-print" aria-hidden="true"></i> <?php echo display('print_pattern')?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                               <li><a href="<?php echo base_url();?>admin/print_pattern/Print_pattern_controller/view_setup" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('setup_pattern')?> </a></li>
                            <li><a href="<?php echo base_url();?>admin/print_pattern/Print_pattern_controller/view_setup_list" class="nav-link"> <i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo display('pattern_list')?></a></li>
                            </ul>
                        </li>

                    <li class="Language">
                        <a href="<?php echo base_url();?>Language"><i class="fa fa-language" aria-hidden="true"></i> <?php echo display('language_setting')?> </a>
                    </li>

                   </ul>

                 <?php } else { ?>

                <div class="user-panel text-center">
                    <div class="image">
                        <img src="<?php echo $this->session->userdata('user_picture');?>" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <p><?php echo $this->session->userdata('user_name'); ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>


                <ul class="sidebar-menu">

                    <li class="active">
                        <a href="<?php echo base_url();?>admin/Dashboard"><i class="ti-home"></i> <span><?php echo display('deashbord');?></span>
                        </a>
                    </li>

                    <!-- <li class="treeview pres">
                        <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo display('prescription')?>
                            <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>

                       <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>admin/Prescription_controller/prescription_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('prescription_list')?></a></li>
                        </ul>
                    </li>  -->

                    <li class="treeview appointment">
                        <a href="#"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo display('appointment')?>
                             <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                        </a>
                         <ul class="treeview-menu">
                            <li><a href="<?php echo base_url()?>admin/Appointment_controller"> <i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('create_appointment')?></a></li>
                            <li><a href="<?php echo base_url()?>admin/Appointment_controller/appointment_list"> <i class="fa fa-list" aria-hidden="true"></i> <?php echo display('appointment_list')?></a></li>
                        </ul>
                    </li>

                    <li class="treeview patient">
                        <a href="#"><i class="fa fa-child" aria-hidden="true"></i> <?php echo display('patient')?>
                             <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url()?>create_new_patient"> <i class="fa fa-plus" aria-hidden="true"></i> </i> <?php echo display('add_new_patient')?></a></li>
                            <li><a href="<?php echo base_url();?>patient_list"> <i class="fa fa-list" aria-hidden="true"></i> </i> <?php echo display('patient_list')?></a></li>
                        </ul>
                    </li>



                     <li class="treeview emergency_stop">
                        <a href="#"><i class="fa fa-paw" aria-hidden="true"></i> <?php echo display('emergency_stop')?>
                             <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                        </a>
                         <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>admin/Emergency_stop_controller"> <i class="fa fa-stop-circle" aria-hidden="true"></i> <?php echo display('emergency_stop_setup')?></a></li>
                            <li><a href="<?php echo base_url();?>admin/Emergency_stop_controller/emergency_stop_list"> <i class="fa fa-list" aria-hidden="true"></i><?php echo display('emergency_stop_list')?></a></li>
                        </ul>
                    </li>

                     <li class="treeview setup_data">
                        <a href="#">
                           <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo display('setup_data')?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                        </a>
                     <ul class="treeview-menu">
                        <li><a href="<?php echo base_url();?>admin/Setup_controller/add_medicine" class="nav-link"> <?php echo display('add_medicine')?></a></li>
                        <li><a href="<?php echo base_url();?>admin/Setup_controller/medicine_List" class="nav-link"> <?php echo display('medicine_List')?></a></li>
                        <li> <a href="<?php echo base_url();?>admin/Setup_controller/add_medicine_company" class="nav-link"> <?php echo display('add_company')?></a></li>
                        <li> <a href="<?php echo base_url();?>admin/Setup_controller/add_medicine_group" class="nav-link"></i> <?php echo display('add_group')?></a></li>
                        <li> <a href="<?php echo base_url();?>admin/Setup_controller/advice" class="nav-link"> <?php echo display('add_advice')?></a></li>
                        <li> <a href="<?php echo base_url();?>admin/Disease_test_controller/add_new_test" class="nav-link"> <?php echo display('add_test_name')?></a></li>
                        <li>  <a href="<?php echo base_url();?>admin/Disease_test_controller/test_list" class="nav-link"> <?php echo display('test_list')?></a></li>
                        </ul>
                    </li>


                     <li class="treeview web_setting">
                        <a href="#">
                            <i class="fa fa-cogs" aria-hidden="true"></i> <?php echo display('web_setting')?> 
                             <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>admin/Web_setup_controller/header_setting" class="nav-link"></i> <?php echo display('header_setup')?></a></li>
                            <li><a href="<?php echo base_url();?>admin/Web_setup_controller/slider_list" class="nav-link"> </i> <?php echo display('slider')?> </a></li>
                       </ul>
                    </li>
                    
                    <li class="treeview blog">
                        <a href="#"><i class="fa fa-barcode" aria-hidden="true"></i> <?php echo display('blog')?> 
                             <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>admin/Blog_controller" class="nav-link"></i> <?php echo display('add_new_post')?></a></li>
                            <li><a href="<?php echo base_url();?>admin/Blog_controller/post_list" class="nav-link"> </i> <?php echo display('post_list')?> </a></li>
                       </ul>
                    </li>
                </ul>
                <?php }  ?>

                </div> <!-- /.sidebar -->
            </aside>