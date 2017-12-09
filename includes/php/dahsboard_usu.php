<?php
include('../dependencia/conexion.php');
      // Agregamos archivo....
date_default_timezone_set('America/Bogota');
$fecha_actual= date('Y-m-d');

$fecha_actual2= date('d-m-Y');

function compararFechas($primera, $segunda)
 {
  $valoresPrimera = explode ("-", $primera);   
  $valoresSegunda = explode ("-", $segunda); 
  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 
  $diaSegunda   = $valoresSegunda[0];  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[2];
  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
 @$diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     
  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es válida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es válida";
    return 0;
  }else{
    return  $diasPrimeraJuliano - $diasSegundaJuliano;
  } 
}
    // Consulto las tareas que tengo 

    $sql="select * from asigna_tareas where cod_usu_asignado='".$_SESSION['cod_usuario']."' ";
    $query=pg_query($conexion, $sql);
    $rows=pg_num_rows($query);
        if($rows==0){
            $tar_hoy=0;
            $tar_vencidas=0;
            $tar_pendientes=0;
            $tar_prox_vencer=0;
          
        }else{

            // busco las tareas que se vencen el día de hoy..
            $sql="select tareas.fecha_venci, proyectos_tar.descripcion as proyecto, tareas.descripcion, tareas.nombre as tarea, tareas.prioridad from tareas, asigna_tareas, proyectos_tar where proyectos_tar.cod_proyecto=tareas.cod_proyecto and tareas.id_tarea=asigna_tareas.id_tarea and tareas.fecha_venci='".$fecha_actual."' and asigna_tareas.cod_usu_asignado='".$_SESSION['cod_usuario']."'";
            $query=pg_query($conexion, $sql);
            $rows1=pg_num_rows($query);

                if($rows1){ // encontró tareas por vencerse el día de hoy..
                    $tar_hoy=$rows1;                  
                    $tar_pendientes=0;
                    $tar_prox_vencer=0;
                }else
                $tar_hoy=0;

                // busco las tareas que se me vencieron
            $sql2="select tareas.fecha_venci, proyectos_tar.descripcion as proyecto, tareas.descripcion, tareas.nombre as tarea, tareas.prioridad from tareas, asigna_tareas, proyectos_tar where proyectos_tar.cod_proyecto=tareas.cod_proyecto and tareas.id_tarea=asigna_tareas.id_tarea and tareas.fecha_venci<'".$fecha_actual."' and asigna_tareas.cod_usu_asignado='".$_SESSION['cod_usuario']."'";
            $query2=pg_query($conexion, $sql2);
            $rows12=pg_num_rows($query2);

                if($rows12){ // encontró tareas por vencerse el día de hoy..
                    $tar_vencidas=$rows12;
                    $tar_pendientes=0;
                    $tar_prox_vencer=0;
                }else
                 $tar_vencidas=0;

                                        // Busco los que están pendientes..
            $sql3="select tareas.fecha_venci, proyectos_tar.descripcion as proyecto, tareas.descripcion, tareas.nombre as tarea, tareas.prioridad from tareas, asigna_tareas, proyectos_tar where proyectos_tar.cod_proyecto=tareas.cod_proyecto and tareas.id_tarea=asigna_tareas.id_tarea and tareas.fecha_venci>'".$fecha_actual."' and asigna_tareas.cod_usu_asignado='".$_SESSION['cod_usuario']."'";
            $query3=pg_query($conexion, $sql3);
            $rows13=pg_num_rows($query3);

                if($rows13){ // encontró tareas por vencerse el día de hoy..

                   /*  $datos=pg_fetch_assoc($query3);
                            $fecha_venci=$datos['fecha_venci'];
                            $separar=explode("-",$fecha_venci);
                            
                            $dia_venci=$separar[2];
                            $mes_venci=$separar[1];
                            $ano_venci=$separar[0];

                            $fecha_compac=$mes_venci."-".$dia_venci."-".$ano_venci;

                             $retardo=compararFechas($fecha_actual2,$fecha_compac); 
                             if($retardo>=0)
                             echo $retardo." días";
                             else
                             echo $retardo;*/

                    $tar_pendientes=$rows13;
                    //$tar_prox_vencer=0;
                }else
                 $tar_pendientes=0;


        }
?>
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4> </div>     
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

                <div class="white-box bg-theme m-b-0 p-b-0 mailbox-widget">
                            <h2 class="text-white p-b-20">Mis tareas </h2>
                            <ul class="nav customtab nav-tabs" role="tablist">                                
                                <li role="presentation" class="active"><a href="#profile1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-export"></i></span> <span class="hidden-xs">HOY</span></a></li>
                                <li role="presentation" class=""><a href="#home1" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-email"></i></span><span class="hidden-xs"> VENCIDAS</span></a></li>
                                <li role="presentation" class=""><a href="#messages1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-panel"></i></span> <span class="hidden-xs">PENDIENTES</span></a></li>
                               <!--  <li role="presentation" class=""><a href="#settings1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-trash"></i></span> <span class="hidden-xs">PRÓXIMAS A VENCERSE</span></a></li>-->
                            </ul>
                </div>

                <div class="white-box p-0">
                            <div class="tab-content m-t-0">

                                <div role="tabpanel" class="tab-pane fade active in" id="profile1">
                                   <div class="p-30">
                                       <!-- <ul class="side-icon-text pull-right">
                                            <li><a href="#"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span>Nueva tarea</span></a></li>
                                            <li><a href="#"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span>Delete</span></a></li>
                                        </ul>-->
                                        <h3><i class="ti-email"></i>TAREAS PARA HOY</h3>
                                    </div>
                                    <div class="inbox-center table-responsive">
                                    <?php
                                               if($tar_hoy>0){
                                                        
                                                ?>
                                       <table width="821" class="table table-hover">
                                            <tbody>
                                                <tr class="unread">
                                                  <td>#</td>
                                                  <td style="width: 50px"><strong>Proyecto</strong></td>
                                                  <td class="max-texts" style="width: 50px"><strong>Tarea</strong></td>
                                                  <td class="max-texts"><strong>Descripción</strong></td>
                                                  <td class="max-texts"><strong>Prioridad</strong></td>
                                                  <td class="hidden-xs"><strong>Vence</strong></td>
                                                  <td class=""><strong>Seguimiento</strong></td>
                                                </tr>
                                                <?php
                                                $i=1;                                                     
                                                            while($datos=pg_fetch_assoc($query)){
                                                        
                                                ?>
                                                <tr class="unread">
                                                    <td width="2"> <?php echo $i; ?></td>
                                                    <td width="68" style="width: 50px"><?php echo $datos['proyecto'] ?></td>
                                                    <td width="62" class="max-texts" style="width: 50px"><?php echo $datos['tarea'] ?></td>
                                                    <td width="95" class="max-texts"><?php echo $datos['descripcion'] ?></td>
                                                    <td width="10" class="max-texts"> <a href="inbox-detail.html"><span class="label label-info m-r-10"><?php if($datos["prioridad"]==1) echo "Alta"; elseif($datos["prioridad"]==2) echo "Media"; else echo "Baja" ?></span></a></td>
                                                    <td width="30" class="max-texts">Hoy</td>
                                                    <td width="30" class="">Ver</td>
                                                </tr>
                                                  <?php
                                                            $i++;
                                                            }
                                                ?>
                                            </tbody>
                                        </table>

                                        <?php
                                                           
                                             }else
                                            echo "No tienes ninguna tarea que se vence hoy.";
                                      ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="home1">
                                    <div class="p-30">
                                       <!-- <ul class="side-icon-text pull-right">
                                            <li><a href="#"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span>Nueva tarea</span></a></li>
                                            <li><a href="#"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span>Delete</span></a></li>
                                        </ul>-->
                                        <h3><i class="ti-email"></i>TAREAS VENCIDAS</h3>
                                    </div>
                                    <div class="inbox-center table-responsive">
                                    <?php
                                               if($tar_vencidas>0){
                                                        
                                                ?>
                                       <table width="821" class="table table-hover">
                                            <tbody>
                                                <tr class="unread">
                                                  <td>#</td>
                                                  <td style="width: 50px"><strong>Proyecto</strong></td>
                                                  <td class="max-texts" style="width: 50px"><strong>Tarea</strong></td>
                                                  <td class="max-texts"><strong>Descripción</strong></td>
                                                  <td class="max-texts"><strong>Prioridad</strong></td>
                                                  <td class="hidden-xs"><strong>Vence</strong></td>
                                                  <td class=""><strong>Seguimiento</strong></td>
                                                </tr>
                                                <?php
                                                $i=1;                                                     
                                                            while($datos=pg_fetch_assoc($query2)){
                                                        
                                                ?>
                                                <tr class="unread">
                                                    <td width="2"> <?php echo $i; ?></td>
                                                    <td width="68" style="width: 50px"><?php echo $datos['proyecto'] ?></td>
                                                    <td width="62" class="max-texts" style="width: 50px"><?php echo $datos['tarea'] ?></td>
                                                    <td width="95" class="max-texts"><?php echo $datos['descripcion'] ?></td>
                                                    <td width="10" class="max-texts"> <a href="inbox-detail.html"><span class="label label-info m-r-10"><?php if($datos["prioridad"]==1) echo "Alta"; elseif($datos["prioridad"]==2) echo "Media"; else echo "Baja" ?></span></a></td>
                                                    <td width="30" class="max-texts"><?php echo $datos['fecha_venci'] ?></td>
                                                    <td width="30" class="">Ver</td>
                                                </tr>
                                                  <?php
                                                            $i++;
                                                            }
                                                ?>
                                            </tbody>
                                        </table>

                                        <?php
                                                           
                                             }else
                                            echo "No tienes ninguna tarea vencida.";
                                      ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                
                             <div role="tabpanel" class="tab-pane fade" id="messages1">
                                    <div class="p-30">
                                       <!-- <ul class="side-icon-text pull-right">
                                            <li><a href="#"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span>Nueva tarea</span></a></li>
                                            <li><a href="#"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span>Delete</span></a></li>
                                        </ul>-->
                                        <h3><i class="ti-email"></i>TAREAS PENDIENTES</h3>
                                    </div>
                                    <div class="inbox-center table-responsive">
                                    <?php
                                               if($tar_pendientes>0){
                                                        
                                                ?>
                                       <table width="821" class="table table-hover">
                                            <tbody>
                                                <tr class="unread">
                                                  <td>#</td>
                                                  <td style="width: 50px"><strong>Proyecto</strong></td>
                                                  <td class="max-texts" style="width: 50px"><strong>Tarea</strong></td>
                                                  <td class="max-texts"><strong>Descripción</strong></td>
                                                  <td class="max-texts"><strong>Prioridad</strong></td>
                                                  <td class="hidden-xs"><strong>Vence</strong></td>
                                                  <td class=""><strong>Seguimiento</strong></td>
                                                </tr>
                                                <?php
                                                $i=1;                                                     
                                                            while($datos=pg_fetch_assoc($query3)){
                                                        
                                                ?>
                                                <tr class="unread">
                                                    <td width="2"> <?php echo $i; ?></td>
                                                    <td width="68" style="width: 50px"><?php echo $datos['proyecto'] ?></td>
                                                    <td width="62" class="max-texts" style="width: 50px"><?php echo $datos['tarea'] ?></td>
                                                    <td width="95" class="max-texts"><?php echo $datos['descripcion'] ?></td>
                                                    <td width="10" class="max-texts"> <a href="inbox-detail.html"><span class="label label-info m-r-10"><?php if($datos["prioridad"]==1) echo "Alta"; elseif($datos["prioridad"]==2) echo "Media"; else echo "Baja" ?></span></a></td>
                                                    <td width="30" class="max-texts"><?php echo $datos['fecha_venci'] ?></td>
                                                    <td width="30" class="">Ver</td>
                                                </tr>
                                                  <?php
                                                            $i++;
                                                            }
                                                ?>
                                            </tbody>
                                        </table>

                                        <?php
                                                           
                                             }else
                                            echo "No tienes ninguna tarea pendiente.";
                                      ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="settings1">
                                    <div class="col-md-6">
                                        <h3>COMPLETADAS</h3>
                                        <h4></h4>
                                    </div>                                   
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

            
                
            </div>