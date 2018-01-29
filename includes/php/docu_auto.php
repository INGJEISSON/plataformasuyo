<?php
include('../dependencia/conexion.php');

date_default_timezone_set('America/Bogota');
$fecha_registro=date('Y-m-d H:i:s');
$fecha_filtro=date('Y-m-d');

  // Buscamos las encuestas que estén en el estado de aprobado
  $s="select distinct enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and (det_repor_aseso.resul_visita='Visitado y pagado') and enc_procesadas.cod_estado=6   ";
  $q=pg_query($conexion, $s);
$carga2=0;
            while($datos1=pg_fetch_assoc($q)){
            echo   $_POST['id_fasfield']=$datos1['id_fasfield'];

               
                                                               // insertamos cliente   
                                                        $carpeta_cliente=$datos['cliente'];
                                                        $md5_carp=md5($carpeta_cliente);  

                                                                // Verificamos que no tenga documentación ya realizada
                                                  $sql5="select cod_cliente from documentacion where cod_cliente='".$datos['id_cliente']."'";
                                              $query5=pg_query($conexion, $sql5); 
                                                $rows5=pg_num_rows($query5);        
                                                                if($rows5==0){

                                                                     echo  $sql2="insert into documentacion (cod_cliente,  nombres, apellidos, tipo_docu, ciudad, cod_bodega, cod_estante, ubicacion, usr_codif) values('".$_POST['id_cliente']."', '".$_POST['cliente']."', '', 2, '', 1, 1, 1, '".$md5_carp."') ";        
                                                                   $query2=pg_query($conexion, $sql2);
                                                                      $query2=1;

                                                                         if($query2==1){

                                                                            mkdir('../files/clientes/'.$md5_carp); // Creamos carpeta inicial...
                                                                                  // Creamos subcarpetas
                                                                                 mkdir('../files/clientes/'.$md5_carp."/Documentos de propiedad");
                                                                                 mkdir('../files/clientes/'.$md5_carp."/Facturas y contratos");
                                                                                mkdir('../files/clientes/'.$md5_carp."/Otros documentos");
                                                                                  mkdir('../files/clientes/'.$md5_carp."/Analisis de caso");

                                                                                  echo "1";// Carpeta creada 
                                                                          }

                                                                  }                                                       
            } // Fin while (de encuestas)