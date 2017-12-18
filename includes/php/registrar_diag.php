<?php
include('../dependencia/conexion.php');

// Registramos todos los diagnósticos que están aprobados 

   $sql71="select distinct enc_procesadas.id_cliente, enc_procesadas.cliente, enc_procesadas.id_fasfield, enc_procesadas.ciudad, enc_procesadas.telefono, enc_procesadas.Barrio, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and resul_visita='Visitado y pagado'  and enc_procesadas.cod_estado=6 and  enc_procesadas.fecha_filtro between '2017-10-01' and '2017-11-30' ";
                          $query71=pg_query($conexion, $sql71);
                        $rows_71=pg_num_rows($query71); 
                           
         if($rows_71){                                 

                                 
                                  while($datos=pg_fetch_assoc($query71)){

                                  	           // Verificamos que no esté registrado
                                              $sql4="select cod_cliente from cliente where cod_cliente='".$datos['id_cliente']."'";
                                              $query4=pg_query($conexion, $sql4); 
                                                $rows4=pg_num_rows($query4);

                                                    if($rows4==0){ // SI no está registrado entonces..

                                                          $insert="insert into cliente (id_fasfield, cod_cliente, nombre, tipo_cliente, ciudad, barrio, direccion_predio, telefono_1) values('".$datos['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['cliente']."', 1, '".$datos['ciudad']."', '".$datos['Barrio']."', '".$datos['direccion']."', '".$datos['telefono']."') ";
                                                             $query4=pg_query($conexion, $insert);

                                                          // Ahora creamos la carpeta del cliente..

                                                               // insertamos cliente   
                                                        $carpeta_cliente=$datos['cliente'];
                                                        $md5_carp=md5($carpeta_cliente);                                                                                

                                                         $sql2="insert into documentacion (cod_cliente,  nombres, apellidos, tipo_docu, ciudad, cod_bodega, cod_estante, ubicacion, usr_codif) values('".$datos['id_cliente']."', '".$datos['cliente']."', '', 2, '', 1, 1, 1, '".$md5_carp."') ";

                                                         //$carpeta_cliente=$_POST['nombre']."_".$_POST['apellidos']."_".$_POST['id_cliente'];
                                                                     
                                                      //  $query2=pg_query($conexion, $sql2);

                                                               if($query2){
                                                              /*    mkdir('../files/clientes/'.$md5_carp); // Creamos carpeta inicial...
                                                                        // Creamos subcarpetas
                                                                       mkdir('../files/clientes/'.$md5_carp."/Documentos de propiedad");
                                                                       mkdir('../files/clientes/'.$md5_carp."/Facturas y contratos");
                                                                      mkdir('../files/clientes/'.$md5_carp."/Otros documentos");
                                                                        mkdir('../files/clientes/'.$md5_carp."/Analisis de caso");

                                                                        echo "1";// Carpeta creada */
                                                                }
                                                    }


                                                 // Veriquemos el tipo de encuesta....

                                              if($datos['resul_visita']=='Visitado y pagado'){

                                                    // Es un diagnóstico entonces.. registramos el diagnóstico nuevo del cliente..

                                                $insert2="insert into diagno_client (id_fasfield, cod_cliente, ciudad, direccion, cod_estado) values('".$datos['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['ciudad']."', '".$datos['direccion']."', 23) ";
                                               // $query2=pg_query($insert2);

                                                		if($query2)
                                                			echo "si";
                                                		else
                                                			echo "no";

                                              } 
                                   
                            	  }                                 
         }