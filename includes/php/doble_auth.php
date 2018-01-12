<?php
include('../dependencia/conexion.php');
      // Agregamos archivo....
date_default_timezone_set('America/Bogota');
$fecha_actual= date('Y-m-d');

$fecha_actual2= date('d-m-Y');

  // Generamos la clave de doble autotenticación.

                                echo   $sql2 ="select * from doble_auth where cod_usuario='".$_SESSION['cod_usuario']."' and fecha_filtro='".$fecha_filtro."' and cod_estado=3 ";
                                   $query2=pg_query($conexion, $sql2);
                                   $rows2=pg_num_rows($query2);
                                            
                                        if($rows2==0){ // Si no ha encontrado entonces genere clave

                                          for ($i = 0; $i < 100; $i++)
                                            $clave=generar_clave();

                                                $insert="insert into doble_auth (cod_usuario, fecha_gene, fecha_filtro, ip, peticion, clave, cod_estado) values('".$_SESSION['cod_usuario']."', '".$fecha_registro."', '".$fecha_filtro."', '".$_SERVER["REMOTE_ADDR"]."','sms', '".$clave."', 3) ";
                                                $query_insert=pg_query($conexion, $insert);

                                                    if($query_insert){ // Enviamos sms al celular..
                                                           

                                                              $telefono="57".$_SESSION['telefono'];                       
                                                              $mensaje="Su código de doble autenticación es: ".$clave;

                                                              $url = 'https://api.hablame.co/sms/envio/';
                                                              $data = array(
                                                                'cliente' => 10010646, //Numero de cliente
                                                                'api' => 'IlHFpX4NJNt2UOOluEHC8oseMCmvKD', //Clave API suministrada
                                                                'numero' => $telefono, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
                                                                'sms' => $mensaje, //Mensaje de texto a enviar
                                                                'fecha' => '', //(campo opcional) Fecha de envio, si se envia vacio se envia inmediatamente (Ejemplo: 2017-12-31 23:59:59)
                                                                'referencia' => 'Suyo Colombia', //(campo opcional) Numero de referencio ó nombre de campaña
                                                              );

                                                              $options = array(
                                                                  'http' => array(
                                                                      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                                                      'method'  => 'POST',
                                                                      'content' => http_build_query($data)
                                                                  )
                                                              );
                                                              |$context  = stream_context_create($options);
                                                              $result = json_decode((file_get_contents($url, false, $context)), true);

                                                              if ($result["resultado"]===0) {
                                                               // $access=1; // Acceso permitido..

                                                                //print 'Se ha enviado el SMS exitosamente';

                                                              } else {
                                                                print 'ha ocurrido un error!!';
                                                              }

                                                    }
                                        }

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