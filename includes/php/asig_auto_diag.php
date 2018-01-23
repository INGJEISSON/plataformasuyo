<?php
include('../dependencia/conexion.php');

date_default_timezone_set('America/Bogota');
$fecha_registro=date('Y-m-d H:i:s');
$fecha_filtro=date('Y-m-d');

  // Buscamos las encuestas que estén en el estado de aprobado
  $s="select distinct enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and (det_repor_aseso.resul_visita='Visitado y pagado'    ) and enc_procesadas.cod_estado=6  ";
  $q=pg_query($conexion, $s);
$carga2=0;
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
                                                            // $query4=pg_query($conexion, $insert);

                                                          // Ahora creamos la carpeta del cliente..

                                                               // insertamos cliente   
                                                        $carpeta_cliente=$datos['cliente'];
                                                        $md5_carp=md5($carpeta_cliente);  

                                                                // Verificamos que no tenga documentación ya realizada
                                                                  $sql5="select cod_cliente from documentacion where cod_cliente='".$datos['id_cliente']."'";
                                              $query5=pg_query($conexion, $sql5); 
                                                $rows5=pg_num_rows($query5);        
                                                                if($rows5==0){

                                                                      $sql2="insert into documentacion (cod_cliente,  nombres, apellidos, tipo_docu, ciudad, cod_bodega, cod_estante, ubicacion, usr_codif) values('".$_POST['id_cliente']."', '".$_POST['cliente']."', '', 2, '', 1, 1, 1, '".$md5_carp."') ";        
                                                                  // $query2=pg_query($conexion, $sql2);

                                                                }                                                            

                                                          

                                                               if($query2){
                                                                /* mkdir('../files/clientes/'.$md5_carp); // Creamos carpeta inicial...
                                                                        // Creamos subcarpetas
                                                                       mkdir('../files/clientes/'.$md5_carp."/Documentos de propiedad");
                                                                       mkdir('../files/clientes/'.$md5_carp."/Facturas y contratos");
                                                                      mkdir('../files/clientes/'.$md5_carp."/Otros documentos");
                                                                        mkdir('../files/clientes/'.$md5_carp."/Analisis de caso");
                                                                        echo "1";// Carpeta creada */
                                                                }
                                                    } // Fin si encontró el cliente...
                                                   
                                                 
                                                 // Veriquemos el tipo de encuesta.... no este
                                                    $sql="select * from diagno_client where id_fasfield='".$_POST['id_fasfield']."' ";
                                                    $query_sql=pg_query($conexion, $sql);
                                                    $rows=pg_num_rows($query_sql);
                                                        if($rows==0){
                                                             echo  $insert2="insert into diagno_client (id_fasfield, cod_cliente, ciudad, direccion, cod_estado) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['ciudad']."', '".$datos['direccion']."', 23) ";
                                                   $query21=pg_query($insert2);

                                                                      // Si es un nuevo cliente entonces buscamos para asignar ese diagnóstico..
                                if($query21){


                                     // Verificamos la carga de diagnósticos (Equipo Legal)

                                                        // Buscamos los usuarios habilitados (Diagnósticos (Equipo Legal))
                                                $s1="select cod_usuario from usuarios where tipo_usuario=22";
                                                $q1=pg_query($conexion, $s1);
                                                 $r1=pg_num_rows($q1);
                                                      if($r1){
                                                         $patron=0;
                                                              $carga=0;
                                                              
                                                              $i=1;
                                                             while($d=pg_fetch_assoc($q1)){

                                                                    echo $sql="select distinct id_elab_diag, cod_usu_respon as cod_usuario from asigna_diag where cod_usu_respon='".$d['cod_usuario']."' ";
                                                                    $query=pg_query($conexion, $sql);
                                                                    $rows=pg_num_rows($query);
                                                                      
                                                                         if($i==1)
                                                                        $carga=$rows; // Carga del primer usuario (Lo utilizamos como patrón para comparar)
                                                                          
                                                                          if($rows>=1){
                                                                            $datos=pg_fetch_assoc($query);
                                                                                if($carga<=$carga2){
                                                                                   $patron=$datos['cod_usuario'];

                                                                                  $carga2=$carga2+1;

                                                                                }
                                                                               
                                                                          }else{
                                                                             $i=$r1;
                                                                             $patron=$d['cod_usuario'];
                                                                             $carga2=1;
                                                                          }
                                                                         
                                                                          if($i==$r1){ // Si ya llegó al último usuario entonces.. (Asignamos diagnóstico)
                                                                            // BUscamos el código del diagnóstico del cliente

                                                                            $s2="select max(id_elab_diag) as id_elab_diag from diagno_client";
                                                                            $q2=pg_query($conexion,$s2);
                                                                            $r2=pg_num_rows($q2);
                                                                                  if($r2){
                                                                                    $d2=pg_fetch_assoc($q2);

                                                                                  echo  $insert="insert into asigna_diag (id_elab_diag, cod_usu_coor, cod_usu_respon, fecha_registro, fecha_filtro) values('".$d2['id_elab_diag']."', 1, '".$patron."', '".$fecha_registro."', '".$fecha_filtro."') ";   
                                                                                    $q4=pg_query($conexion, $insert);
                                                                                        if($q4){
                                                                                            // Actualizamos el usuario asignado (Legal)
                                                                                          $update="update diagno_client set cod_usu_legal='".$patron."' where id_elab_diag='".$d2['id_elab_diag']."' ";
                                                                                          $up=pg_query($conexion, $update);
                                                                                        }
                                                                                  }

                                                                                  break; // Salgo del bucle

                                                                           } // Fin  si llegó al último usuario...


                                                                    $i++;
                                                                } // Finalizado WHile
                                                             
                                                            
                                                      } // Finalizado si (encontro los usuarios del equipo legal)

                                }
                                                

                                                        }



                                


                                                       

            } // Fin while (de encuestas)