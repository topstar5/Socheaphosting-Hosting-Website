

            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="header-icon">
                        <i class="pe-7s-world"></i>
                    </div>
                    <div class="header-title">
                        <h1><?php echo display('doctoress_dashboard');?></h1>
                        <small><?php echo display('doctoress_dashboard');?></small>
                        <ol class="breadcrumb">
                            <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>
                            <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>
                        </ol>
                    </div>
                </section>

                
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                    

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">

                            <a href="<?php echo base_url();?>patient_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo @$total_patient;?></span> </h2>
                                            <div class="small"> <?php echo display('total_patient')?> </div>
                                        <div class="sparkline1 text-center"></div>
                                    </div>
                                    <div class="icon"><i class="ti-user"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Patient_controller/today_patient_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo count($today_patient);?></span> </h2>
                                        <div class="small"><?php echo display('today_patient')?></div>
                                        <div class="sparkline2 text-center"></div>
                                    </div>
                                    <div class="icon"><i class="ti-user"></i></div>
                                </div>
                            </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Appointment_controller/today_appointment_list">
                                <div class="panel-body">
                                   <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo count($to_day_appointment);?></span></h2>
                                        <div class="small"><?php echo display('today_appointment')?></div>
                                    </div>
                                       <div class="icon"><i class="ti-notepad"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Appointment_controller/today_gate_appointment_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo count(@$to_day_get_appointment);?></span></h2>
                                        <div class="small"><?php echo display('new_appointment')?></div>
                                    </div>
                                    <div class="icon"><i class="ti-notepad"></i></div>
                                </div>
                            </a>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Appointment_controller/appointment_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo @$total_appointment;?></span></h2>
                                        <div class="small"><?php echo display('total_appointment')?></div>
                                    </div>
                                    <div class="icon"><i class="ti-notepad"></i></div>
                                </div>
                            </a>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Prescription_controller/today_prescription_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo count(@$today_prescription); ?></span></h2>
                                        <div class="small"></i> <?php echo display('today_prescription')?></div>
                                        
                                    </div>
                                     <div class="icon"><i class="ti-notepad"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                             <a href="<?php echo base_url();?>admin/Prescription_controller/prescription_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo @$total_prescription ?></span></h2>
                                        <div class="small"><?php echo display('total_prescription')?></div>
                                        
                                    </div>
                                     <div class="icon"><i class="ti-notepad"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                             <a href="<?php echo base_url();?>admin/Sms_report_controller/sms_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo $total_sms ?></span></h2>
                                        <div class="small"><?php echo display('total_sms')?></div>
                                    </div>
                                     <div class="icon"><i class="ti-email"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Sms_report_controller/today_sms_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo $today_sms ;?></span></h2>
                                        <div class="small"><?php echo display('today_sms')?></div>
                                    </div>
                                     <div class="icon"><i class="ti-email"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>

                         <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Sms_report_controller/custom_sms_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo count($coustom_sms);?></span></h2>
                                        <div class="small"></i> <?php echo display('custom_sms')?></div>
                                    </div>
                                     <div class="icon"><i class="ti-email"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/Sms_report_controller/auto_sms_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo count($auto_sms); ?></span></h2>
                                        <div class="small"></i> <?php echo display('auto_sms')?></div>
                                    </div>
                                     <div class="icon"><i class="ti-email"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                            <a href="<?php echo base_url();?>admin/email/Email/email_list">
                                <div class="panel-body">
                                    <div class="statistic-box">
                                        <h2><span class="count-number"><?php echo count($total_email); ?></span></h2>
                                        <div class="small"><?php echo display('send_total_email')?></div>
                                    </div>
                                     <div class="icon"><i class="ti-email"></i></div>
                                </div>
                            </a>    
                            </div>
                        </div>

                    </div>

                    <div class="row">
                    
                         <!-- Bar Chart -->
                        <div class="col-sm-12 col-md-6">
                            <div class="panel panel-bd lobidisable">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4><?php echo display('appointment_chart')?></h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <canvas id="barChart" height="140"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Line Chart -->
                        <div class="col-sm-12 col-md-6">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4><?php echo display('patient_chart')?></h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <canvas id="lineChart" height="140"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->