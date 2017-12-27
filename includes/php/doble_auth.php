<?php
include('../dependencia/conexion.php');
      // Agregamos archivo....
date_default_timezone_set('America/Bogota');
$fecha_actual= date('Y-m-d');

$fecha_actual2= date('d-m-Y');

?>
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">DOBLE AUTENTICACIÓN</h4> </div>     
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->

                <div class="row">

                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">TAREAS PARA HOY</h3>
                            <ul class="list-inline two-part">
                                <li><i class="icon-folder text-purple"></i></li>
                                <li class="text-right"><span class="counter"><?php echo $tar_hoy ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">TAREAS VENCIDAS </h3>
                            <ul class="list-inline two-part">
                                <li><i class="icon-people text-info"></i></li>
                                <li class="text-right"><span class="counter"><?php echo $tar_vencidas ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">TAREAS PENDIENTES</h3>
                            <ul class="list-inline two-part">
                                <li><i class="icon-folder text-purple"></i></li>
                                <li class="text-right"><span class="counter"><?php echo $tar_pendientes ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">PRÓXIMAS A VENCERSE</h3>
                            <ul class="list-inline two-part">
                                <li><i class="icon-folder text-purple"></i></li>
                                <li class="text-right"><span class="counter"><?php echo $tar_prox_vencer ?></span></li>
                            </ul>
                        </div>
                    </div>-->
                   
                    
                </div>

             

            
                
            </div>