<?php
include('../dependencia/conexion.php');

  $q = strtolower($_POST["query"]);
if($q!=''){
                    $sql="select * from documentacion where apellidos LIKE '%".$q."%' or nombres LIKE '%".$q."%' ";
                    $query=pg_query($conexion, $sql);
                    $rows=pg_num_rows($query);


                        if($rows){  
                           $data = array();
                                while($rs = pg_fetch_assoc($query)) { 
                                 $data[]= $rs['cod_cliente'].", ".($rs['apellidos'])." ".$rs['nombres']." ";
                              //  echo $cname."\n";
                                }
                               echo json_encode($data);
                        }
  }