<?php
include('../dependencia/conexion.php');
    
                    $parametro="";     
  //if($_SESSION['tipo_usuario']!=6)

 $sql="select  distinct cliente.cod_cliente, cliente.nombre as cliente, cliente.telefono_1, cliente.ciudad, cliente.barrio, tipo_cliente.descripcion as tipo_cliente, diagno_client.id_elab_diag, diagno_client.cod_usu_legal, diagno_client.cod_usu_tecnico from cliente, diagno_client, tipo_cliente where $parametro cliente.tipo_cliente=tipo_cliente.tipo_cliente and cliente.cod_cliente=diagno_client.cod_cliente and diagno_client.cod_estado=23";
          $query=pg_query($conexion, $sql);

          $rows=pg_num_rows($query);
    
          
    if($_SESSION['tipo_usuario']==1)
      $sql6="select * from usuarios where  tipo_usuario=21 or tipo_usuario=6 or tipo_usuario=19  "; 
    else if($_SESSION['tipo_usuario']!=6)
    $sql6="select * from usuarios where  tipo_usuario=19  ";
    else
    $sql6="select * from usuarios where  tipo_usuario=21 or tipo_usuario=6 ";
                    $query6=pg_query($conexion, $sql6);
                    $rows6=pg_num_rows($query6);
                  
                           
?>






<link rel="stylesheet" href="js/colorbox-master/example1/colorbox.css" />
<script src="js/colorbox-master/jquery.colorbox-min.js"></script>


<script>
  $(document).ready(function(){
        
        $(".edicion").colorbox({
          iframe:false, 
          width:"100%", 
          height:"100%",
          overlayClose:false,
          //escKey:
          });
          
          
  });
</script>
  <p>
  <center>
    <p><strong>ASIGNACI&Oacute;N DE SERVICIOS</strong></p>  

    <div class="col-sm-12">
                        <div class="white-box">                           
                            <div id="container" style="min-width: 900px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
  
  </center>
  </p>
  <div class="card-header d-flex-fluid">
    <table id="table_id" class='table responsive' cellspacing="0" width="100%">
      <thead>
        <tr>
          <th width="34">#</th>
          <th width="110">Identificación</th>
          <th width="147">Cliente</th>        
           <th width="300">Ciudad</th>       
          <th width="137">Asignaci&oacute;n</th>
          <th width="175">Asignado/Reasignar (Legal)</th>
          <th width="175">Asignado/Reasignar (T�cnico)</th>
          <th width="74"><p>&nbsp;</p>
          <p>Confirmar</p></th>
        </tr>
      </thead>
      <tbody>
      <?php
      $i=1;
        while($datos=pg_fetch_assoc($query)){
                             /* if($_SESSION['tipo_usuario']!=6)
                                $sql3="select * from usuarios where tipo_usuario=19 ";
                                else
                              $sql3="select * from usuarios where tipo_usuario=21  or tipo_usuario=6 ";*/

                      
                    $sql3="select * from usuarios where  tipo_usuario=22";  //Legal                    
                        $sql5="select * from usuarios where  tipo_usuario=23"; //T�cnico

                        $query3=pg_query($conexion, $sql3);
                         $query4=pg_query($conexion, $sql5);
                              
                            $sql2="select usuarios.nombre, usuarios.cod_usuario, usuarios.apellidos from diagno_client, usuarios where diagno_client.cod_usu_legal=usuarios.cod_usuario and  diagno_client.id_elab_diag='".$datos['id_elab_diag']."' and diagno_client.cod_usu_legal='".$datos['cod_usu_legal']."'   ";
                              $query2=pg_query($conexion, $sql2);
                              $rows2=pg_num_rows($query2);
                                  if($rows2){
                                     
                                          $datos2=pg_fetch_assoc($query2);
                                    $estado="Asignado";

                                  }else
                                  $estado="Sin asignar";

                            $sql21="select usuarios.nombre, usuarios.cod_usuario, usuarios.apellidos from diagno_client, usuarios where diagno_client.cod_usu_tecnico=usuarios.cod_usuario and  diagno_client.id_elab_diag='".$datos['id_elab_diag']."' and diagno_client.cod_usu_tecnico='".$datos['cod_usu_tecnico']."'   ";
                              $query21=pg_query($conexion, $sql21);
                              $rows21=pg_num_rows($query21);
                                  if($rows21){
                                     
                                          $datos21=pg_fetch_assoc($query21);
                                    $estado2="Asignado";

                                  }else
                                  $estado2="Sin asignar";



                            // Buscamoss la fecha de asignaci��n: 

                                  $sql4="select fecha_filtro from asigna_diag where id_elab_diag='".$datos['id_elab_diag']."' order by id_elab_diag desc limit 1  ";
                                  $query4=pg_query($conexion, $sql4);
                                  $rows4=pg_num_rows($query4);
                                      if($rows4){
                                        $datos4=pg_fetch_assoc($query4);    
                                        $fecha_filtro= $datos4['fecha_filtro'];                                   
                                      }else
                                      $fecha_filtro="";
      ?>

        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $datos['cod_cliente']; ?></td>
          <td><?php echo ($datos['cliente']); ?></td>       
          <td><?php echo ($datos['ciudad']); ?></td>
          <td id='fecha_filtro<?php echo $i ?>'><?php echo $fecha_filtro; ?></td>          
          <td><select name="select" id="cod_usu_resp<?php echo $i ?>">
          
            <option value="0">Sin asignar</option>
            <
                    <?php
                     
                while($datos3=pg_fetch_assoc($query3)){  
                    
                        if($rows2){
                    
                  ?>
                   <option value="<?= $datos3['cod_usuario'] ?>"<?php if($datos3['cod_usuario']==$datos2['cod_usuario']){    ?> selected='selected' <?php } ?> > <?php echo $datos3['nombre']." ". $datos3['apellidos']?></option>
             <?php
                }else{
            ?>
            <option value="<?= $datos3['cod_usuario'] ?>"> <?php echo $datos3['nombre']." ". $datos3['apellidos']?></option>
            <?php   
                }
            }
        ?>
          </select></td>
          <td><select name="select" id="cod_usu_resp2<?php echo $i ?>">
          
            <option value="0">Sin asignar</option>
            <
                    <?php
                     
                while($datos31=pg_fetch_assoc($query5)){  
                    
                        if($rows21){
                    
                  ?>
                   <option value="<?= $datos31['cod_usuario'] ?>"<?php if($datos31['cod_usuario']==$datos21['cod_usuario']){    ?> selected='selected' <?php } ?> > <?php echo $datos31['nombre']." ". $datos31['apellidos']?></option>
             <?php
                }else{
            ?>
            <option value="<?= $datos3['cod_usuario'] ?>"> <?php echo $datos31['nombre']." ". $datos31['apellidos']?></option>
            <?php   
                }
            }
        ?>
          </select></td>
          <td><input type="button" class="btn btn-primary" id="confir<?php echo $i ?>" name="button"  value="Confirmar"></td>       </tr>
             </tr>
        </td>
        
        </tr>  


            <script type="text/javascript">

            $(document).ready(function(){


                        $("#confir<?php echo $i ?>").click(function(){

                          var cod_usu_resp=$("#cod_usu_resp<?php echo $i ?>").val();
                          var cod_usu_resp2=$("#cod_usu_resp2<?php echo $i ?>").val();
                          var id_elab_diag=<?php echo $datos['id_elab_diag'] ?>;

                              var datos='asig_diagnostico='+1+'&cod_usu_resp='+cod_usu_resp+'&id_elab_diag='+id_elab_diag+'&cod_usu_resp2='+cod_usu_resp2;

                              
                                           $.ajax({

                                                    data: datos,
                                                    type: "POST",
                                                    url:"includes/php/g_procesos.php",
                                                    success: function(valor){
                                                        
                                                            if(valor==1){
                                                            alert("Diagn�stico asignado correctamente");
                                                            $("#fecha_filtro<?php echo $i ?>").val("jeisson");
                                                           }
                                                            else
                                                            alert("Ocurri�� un problema, comun��cate con el administrador");

                                                    }
                                            });

                        });
             });
            </script>

        <?php   
        $i++; 

           }

        ?>
      </tbody>
    </table>
  </div>         
  <p>
    <script type="text/javascript">
    
$(document).ready(function () {
 //$('#table_id').DataTable();
 
 $('#table_id').DataTable({
    //"bJQueryUI": true,
   // scrollY: 600,
    //paging: false
      dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
        ]
} );
 /*

 $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Diagn�sticos asignados por responsable'
        },
        subtitle: {
            text: 'Generado en: <a href="http://platform.suyo.io">Plataforma Suyo (Beta)</a>'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        
        series: [{
            name: 'Population',
            data: [
            <?php 
               while($datos4=pg_fetch_assoc($query6)){

                                        $sql2="select * from asigna_diag where cod_usu_legal='".$datos4['cod_usuario']."' or cod_usu_tecnico='".$datos4['cod_usuario']."' ";
                                    $query2=pg_query($conexion, $sql2);
                                    $datos2=pg_fetch_assoc($query2);
                                    $rows2=pg_num_rows($query2);
            ?>
                ['<?php echo $datos4['nombre'].' '.$datos4['apellidos'] ?>', <?php echo $rows2 ?>],
            <?php 
                }
            ?>
                
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.0f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });

*/
    
});
    </script>
  </p>
  <p>&nbsp; </p>
