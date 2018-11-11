
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>

    </section>

    <!-- Main content -->
    <section class="content">
            <div class="row">
        <div class="col-md-12 ">
                <?php 
                    $msg = $this->session->flashdata('message');
                      if($msg !=''){
                          echo $msg;
                    }
                ?>

                <div class="portlet box default">
                    <div class="portlet-body form">
                    <?php
                        $attributes = array('class' => 'form-horizontal','method'=>'post','target'=>'_blanck','role'=>'form');
                         echo form_open('Backend/doctor/Instruction/search_prescription/search',$attributes);
                    ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Enter Appointment Id</label>
                                <div class="col-md-9">
                                <input type="text" class="form-control input-lg" placeholder="Enter Appointment Id" name="appointment_id" required > </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="submit" class="text-right btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>           
    </section>
</div>


