<?php
    date_default_timezone_set(@$info->timezone->details);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo (!empty($info->website_title->details)?$info->website_title->details:null); ?></title>
        <link rel="icon" href="<?php echo (!empty($info->fabicon->picture)?$info->fabicon->picture:null); ?>" sizes="16x16">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
          <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet">
        <!-- flaticon -->
        <link href="<?php echo base_url(); ?>public/public_css/css/flaticon.css" rel="stylesheet">
        <!-- font-awesome -->
        <link href="<?php echo base_url(); ?>public/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
        <!-- style -->
        <link href="<?php echo base_url(); ?>assets/public_css/style2.css" rel="stylesheet">
    
      <script type="text/javascript">
        function printContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
      </script>

  <style type="text/css" rel="print">
    @media print {
        .header {
            background:  #fff !important; 
        }
        
  }

</style>

</head>  

<body>

    <?php
      if($this->session->userdata('appointment_id')){
       $appointment_id = $this->session->userdata('appointment_id');
	    }else{
	     $appointment_id = $this->uri->segment(3);
	    }
     
      if(!empty($print)){

          $start = $print->start_time;
          $end =  $print->end_time;

          $pp_time = $print->per_patient_time;
          $sq = $print->sequence;
          $m_time = $sq - 1;

          $time = ($m_time * $pp_time);
          $patient_time = date('h:i A', strtotime("+$time minutes", strtotime($start)));
          $patient_time = date('h:i A', strtotime($start));
          $end_time = date('h:i A', strtotime($end));

     ?>
    
  <div class="container" >
      <div class="row top1-bar">
          <div class="social-icons pull-right">
              <ul>
                  <li><a href="" onclick="printContent('div1')" title="Print"><i class="fa fa-print"></i></a></li>
              </ul>
          </div> 
      </div>
  </div>
        

 <div id="div1">

      <div class="container" >
          <div class="row top-bar">
              <div class="left-text pull-left">
                  <p><b><?php echo display('date')?> : <?php echo @$print->get_date_time;?></p>
              </div>  
          </div>
      </div>
		

	
      <div class="container header" >
              <img src="<?php echo (!empty($info->logo->picture)?$info->logo->picture:null); ?>" class="img-responsive" style="height:120px; max-height:120px; alt="">
      </div>

		
				<div class="container" >
					<div class="row ccc" >
						<div class="sec-title colored text-center">
							<p class="h2"><?php echo display('appointment_information_page')?></p>
						</div>

						<div class="information">
							<div class="information-details"  >
								<ul>
									<li><?php echo display('appointment_id')?>: <span class="pull-right"> <?php echo $print->appointment_id ;?></span></li>
									<li><?php echo display('name')?> : <span class="pull-right"><?php echo @$print->patient_name ;?></span></li>
									<li><?php echo display('patient_id')?> : <span class="pull-right"><?php echo @$print->patient_id ;?></span></li>
									<li><?php echo display('Sequence')?> : <span class="pull-right"><?php echo @$print->sequence ;?></span></li>
									<li><?php echo display('date')?> : <span class="pull-right"><?php echo date('d M, Y' , strtotime(@$print->date)) ;?> </span></li>
									<li><?php echo display('doctor')?> : <span class="pull-right"><?php echo @$print->doctor_name ;?></span></li>
									<li><?php echo display('department')?> : <span class="pull-right"> <?php echo @$print->department;?></span></li>
								</ul>
							</div>
						</div>

						<div class="mape" >

						 <div class="google-map"><?php echo @$print->venue_map;?></div>              
							<!--<p><?php echo base_url();?>myappintment/<?php echo $print->appointment_id ;?></p>-->
						</div>
					</div>
				</div>
		

			<div class="container inners">
				<div class="row ccc">
					<div class="address_footer" >
						 <b> <?php echo display('address')?> : </b><span class="address_footer_text"> <?php echo @$print->venue_address;?></span>
						 <b> <?php echo display('phone_number')?> :</b> <span class="address_footer_text"> <?php echo @$print->venue_contact;?></span>
					</div>

				</div> 

         <div style="float: right; margin-top: 20px ">
         Pay with paypal
              <a target="_blank" href="<?php echo base_url();?>admin/payment_method/Payment/pay_with_doctor/<?php echo $print->appointment_id;?>">
              <img style="height:50px; max-height:100px; " src="<?php echo base_url()?>assets/images/paypal.png" class="img-responsive" style="text-align:top;" alt=""></a>
        </div>

			</div> 

			<div class="container">
				<div class="row footer">
					<span class="address_footer_recepition"><?php echo display('Kindly_Report_30_minutes')?>  </span>
				</div>
			</div>
		</div>
		<?php 
			}else{
		?>
		<div class="container">
            <div class="alert alert-block alert-danger fade in">
                 <strong><?php echo display('Please_Click_to_back_home')?></strong>
                <a href="<?php echo base_url();?>" class="btn btn-large btn-primary"><?php echo display('back_home')?></a>
            </div>
        </div>
		<?php } ?>

	</body>
</html>