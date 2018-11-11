<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">



    <!-- Content Header (Page header) -->

    <section class="content-header">

        <div class="header-icon">

            <i class="pe-7s-world"></i>

        </div>

        <div class="header-title">

            <h1><?php echo display('treatment_list');?></h1>

            <small><?php echo display('treatment_list');?></small>

            <ol class="breadcrumb">

                <li><a target="_blank" href="<?php echo base_url();?>"><i class="pe-7s-home"></i> <?php echo display('site_view')?></a></li>

                <li class="active"><a href="<?php echo base_url();?>admin/Dashboard"><?php echo display('deashbord');?></a></li>

            </ol>

        </div>

    </section>



    <!-- Main content -->

    <section class="content">





            <div class="row">

                <div class="col-md-12 ">

                    <?php

                        $d_msg = $this->session->flashdata('del_msg');

                        $msg = $this->session->flashdata('msg');

                            if($msg){

                                echo "<div class='alert alert-success msg'>".$msg."</div><br>";

                            }

                            if($d_msg){

                                echo "<div class='alert alert-success msg'>".$d_msg."</div><br>";

                            }

                      ?>

                              

                        <div class="panel panel-default form-panel">

                            <div class="panel-body">

                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">

                                    <thead>

                                        <tr class="center">

                                            <th class="all"><?php echo display('treatment_name');?></th>

                                            <th class="min-phone-l"><?php echo display('description');?></th>

                                            <th class="min-phone-l"><?php echo display('price');?></th>

                                             <th class="one">Action</th>

                                        </tr>

                                    </thead>



                                <tbody>

                                    <?php 

                                        foreach ($t_info as $value) {

                                    ?>

                                    <tr>

                                        <td><?php echo @$value->treatment_name;?></td>

                                        <td><?php echo @$value->treatment_description;?></td>

                                        <td><?php echo @$value->treatment_price;?></td>



                                        <td>

                                            <a class="btn btn-xs btn-info" onclick="modal('<?php echo $value->treatment_id;?>');"><i class="fa fa-edit"></i> </a>

                                            <a href="<?php echo base_url();?>admin/Treatment_controller/delete_treatment/<?php echo $value->treatment_id;?>" onclick="return confirm('Are you want to delelte?');" class="btn  btn-xs btn-danger">

                                            <i class="fa fa-trash"></i>  </a>

                                        </td>



                                    </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>            

    </section>

</div>









<script type="text/javascript">

    function modal(id){

        $.ajax({ 

            'url': '<?php echo base_url();?>' + 'admin/Treatment_controller/edit_treatment/'+id,

            'type': 'GET', //the way you want to send data to your URL

            'data': {'treatment_id': id },

            'success': function(data) {

                var container = $(".viewEditModal");

                container.html(data);

            }

        });    

    }

</script>

