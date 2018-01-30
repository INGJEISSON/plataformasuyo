<?php
include('../dependencia/conexion.php');

date_default_timezone_set('America/Bogota');
$fecha_registro=date('Y-m-d H:i:s');
$fecha_filtro=date('Y-m-d');

  // Buscamos las encuestas que estén en el estado de aprobado
  $s="select distinct enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and (det_repor_aseso.resul_visita='Visitado y fue gratuito el diagnóstico') ";
  $q=pg_query($conexion, $s);
$carga2=0;
            while($datos1=pg_fetch_assoc($q)){
            echo   $_POST['id_fasfield']=$datos1['id_fasfield'];

                echo "<br>";
                      //Consultamos los datos del cliente
                                            $sql3="select enc_procesadas.id_cliente, enc_procesadas.cliente, enc_procesadas.asesor, enc_procesadas.ciudad, enc_procesadas.telefono, enc_procesadas.barrio, det_repor_aseso.resul_visita, det_repor_aseso.tom_serv, det_repor_aseso.valor, det_repor_aseso.tipo_pago, det_repor_aseso.servi_tomados  from det_repor_aseso, enc_procesadas where det_repor_aseso.id_fasfield=enc_procesadas.id_fasfield and enc_procesadas.id_fasfield='".$_POST['id_fasfield']."' ";
                                          $query3=pg_query($conexion, $sql3);
                                          $datos=pg_fetch_assoc($query3);

                                              // Verificamos que no esté registrado
                                             echo  $sql4="select cod_cliente from cliente where cod_cliente='".$datos['id_cliente']."'";
                                              $query4=pg_query($conexion, $sql4); 
                                               echo  $rows4=pg_num_rows($query4);
                                               echo "<br>";

                                          if($rows4==0){ // SI no está registrado entonces..

                                                          echo   $insert="insert into cliente (id_fasfield, cod_cliente, nombre, tipo_cliente, ciudad, barrio, direccion_predio, telefono_1) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."',  '".$datos['cliente']."', 1, '".$datos['ciudad']."', '".$datos['barrio']."', '', '".$datos['telefono']."') ";
                                                             $query4=pg_query($conexion, $insert);
                                                          // Ahora creamos la carpeta del cliente..
                                                               // insertamos cliente   
                                                        $carpeta_cliente=$datos['cliente'];
                                                        $md5_carp=md5($carpeta_cliente);  

                                                              
                                                      }  

                                               // Veriquemos el tipo de encuesta.... no este
                                                    $sql="select * from diagno_client where id_fasfield='".$_POST['id_fasfield']."' ";
                                                    $query_sql=pg_query($conexion, $sql);
                                                    $rows=pg_num_rows($query_sql);
                                                        if($rows==0){
                                                    echo  $insert2="insert into diagno_client (id_fasfield, cod_cliente, ciudad, direccion, cod_estado) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['ciudad']."', '".$datos['direccion']."', 23) ";
                                                   $query21=pg_query($insert2);
                                                   }                                                        

                                                          /*

                                                               if($query2){
                                                                /* mkdir('../files/clientes/'.$md5_carp); // Creamos carpeta inicial...
                                                                        // Creamos subcarpetas
                                                                       mkdir('../files/clientes/'.$md5_carp."/Documentos de propiedad");
                                                                       mkdir('../files/clientes/'.$md5_carp."/Facturas y contratos");
                                                                      mkdir('../files/clientes/'.$md5_carp."/Otros documentos");
                                                                        mkdir('../files/clientes/'.$md5_carp."/Analisis de caso");
                                                                        echo "1";// Carpeta creada 
                                                                }
                                                    } // Fin si encontró el cliente...*/

                                                   
                                                 
                                                 // Veriquemos el tipo de encuesta.... no este
                                                 /*   $sql="select * from diagno_client where id_fasfield='".$_POST['id_fasfield']."' ";
                                                    $query_sql=pg_query($conexion, $sql);
                                                    $rows=pg_num_rows($query_sql);
                                                        if($rows==0){
                                                             echo  $insert2="insert into diagno_client (id_fasfield, cod_cliente, ciudad, direccion, cod_estado) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['ciudad']."', '".$datos['direccion']."', 23) ";
                                                   $query21=pg_query($insert2);*/

                                                                      // Si es un nuevo cliente entonces buscamos para asignar ese diagnóstico..*/
            } // Fin while (de encuestas)