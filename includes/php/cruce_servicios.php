<?php
include('../dependencia/conexion.php');
$_POST['cod_estado']=6;
date_default_timezone_set('America/Bogota');
$fecha_registro=date('Y-m-d H:m:s');
if($_POST['cod_estado']==6){ // Si aprobado, lo agrgamos al grupo de clientes..

  // Buscamos las encuestas que estén en el estado de aprobado
  $s="select distinct enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and det_repor_aseso.tom_serv='Si' and enc_procesadas.cod_estado=6 and ( tipo_pago='Contado' or tipo_pago='Cuotas') ";
  $q=pg_query($conexion, $s);

            while($datos1=pg_fetch_assoc($q)){
              $_POST['id_fasfield']=$datos1['id_fasfield'];

                                            //Consultamos los datos del cliente
                                            $sql3="select enc_procesadas.id_cliente, enc_procesadas.cliente, enc_procesadas.asesor, enc_procesadas.ciudad, enc_procesadas.telefono, enc_procesadas.barrio, det_repor_aseso.resul_visita, det_repor_aseso.tom_serv, det_repor_aseso.valor, det_repor_aseso.tipo_pago, det_repor_aseso.servi_tomados  from det_repor_aseso, enc_procesadas where det_repor_aseso.id_fasfield=enc_procesadas.id_fasfield and enc_procesadas.id_fasfield='".$_POST['id_fasfield']."' ";
                                          $query3=pg_query($conexion, $sql3);
                                          $datos=pg_fetch_assoc($query3);

                                              // Verificamos que no esté registrado
                                             echo  $sql4="select cod_cliente from cliente where cod_cliente='".$datos['id_cliente']."'";
                                              $query4=pg_query($conexion, $sql4); 
                                                $rows4=pg_num_rows($query4);

                                                 if($rows4==0){ // SI no está registrado entonces..

                                                          echo   $insert="insert into cliente (id_fasfield, cod_cliente, nombre, tipo_cliente, ciudad, barrio, direccion_predio, telefono_1) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."',  '".$datos['cliente']."', 1, '".$datos['ciudad']."', '".$datos['barrio']."', '', '".$datos['telefono']."') ";
                                                            $query4=pg_query($conexion, $insert);

                                                          // Ahora creamos la carpeta del cliente..

                                                               // insertamos cliente   
                                                        $carpeta_cliente=$datos['cliente'];
                                                        $md5_carp=md5($carpeta_cliente);                                                                                

                                                          $sql2="insert into documentacion (cod_cliente,  nombres, apellidos, tipo_docu, ciudad, cod_bodega, cod_estante, ubicacion, usr_codif) values('".$_POST['id_cliente']."', '".$_POST['cliente']."', '', 2, '', 1, 1, 1, '".$md5_carp."') ";                                                       
                                                                     
                                                          $query2=pg_query($conexion, $sql2);

                                                               if($query2){
                                                                /* mkdir('../files/clientes/'.$md5_carp); // Creamos carpeta inicial...
                                                                        // Creamos subcarpetas
                                                                       mkdir('../files/clientes/'.$md5_carp."/Documentos de propiedad");
                                                                       mkdir('../files/clientes/'.$md5_carp."/Facturas y contratos");
                                                                      mkdir('../files/clientes/'.$md5_carp."/Otros documentos");
                                                                        mkdir('../files/clientes/'.$md5_carp."/Analisis de caso");*/
                                                                        echo "1";// Carpeta creada 
                                                                }
                                                    } // Fin si no encontró el cliente...
                                                   
                                                 
                                                 // Veriquemos el tipo de encuesta....

                                             /* if($datos['resul_visita']=='Visitado y pagado'){   // Es un diagnóstico entonces.. registramos el diagnóstico nuevo del cliente..                                                
                                                $insert2="insert into diagno_client (id_fasfield, cod_cliente, ciudad, direccion, cod_estado) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['ciudad']."', '".$datos['direccion']."', 23) ";
                                                $query2=pg_query($insert2);

                                              } else*/  if($datos['tom_serv']=='Si'){ // Es un servicio nuevo 


                                                    $serv_tomados=$datos['servi_tomados'];
                                                    $separar=explode(',',$serv_tomados); 

                                                          for($i=0;$i<count($separar);$i++){

                                                                echo "servicio: ".$cod_servicio=$separar[$i];

                                                                if(is_numeric($cod_servicio)){ // Si es un código de servicio entonces...

                                                                  //Verificamos que el servicio no se haya registrado al cliente..
                                                              echo   $sql31="select * from serv_cliente where cod_servicio='".$cod_servicio."' and cod_cliente='".$datos['id_cliente']."' ";
                                                                $query31=pg_query($conexion, $sql31);
                                                                $rows31=pg_num_rows($query31);

                                                                          if($rows31==0){ // EL servicio no se ha registrado enttonces... agréguelo..
                                                                              
                                                                              if($datos['tipo_pago']=='Contado'){
                                                                             echo  $insert2="insert into serv_cliente (asesor, cod_servicio, cod_estado, cod_cliente, valor, fecha_registro, cod_usuario, cod_acuer_pago, id_list_despleg) values('".$datos['asesor']."', '".$cod_servicio."', 23, '".$datos['id_cliente']."', '".$datos['valor']."', '".$fecha_registro."', 95, 1, 1)  ";
                                                                                 $queryinser=pg_query($conexion, $insert2); // INsertamos el cliente..
                                                                              }
                                                                              if($datos['tipo_pago']=='Cuotas'){
                                                                             echo  $insert2="insert into serv_cliente (asesor, cod_servicio, cod_estado, cod_cliente, valor, fecha_registro, cod_usuario, cod_acuer_pago, id_list_despleg) values('".$datos['asesor']."', '".$cod_servicio."', 23, '".$datos['id_cliente']."', '".$datos['valor']."', '".$fecha_registro."', 95, 1, 1)  ";
                                                                                 $queryinser=pg_query($conexion, $insert2); // INsertamos el cliente..
                                                                              }

                                                                          }      

                                                                } // FIn Si es un codigo de servicio...
                                                          }

                                              }  // Fin si es un servicio nuevo..... tomado por el cliente.

                                  }


            }