<?php
include('../dependencia/conexion.php');    
                    $parametro="";   
                    
  $sql="select serv_cliente.id_serv_cliente, serv_cliente.cod_cliente, cliente.ciudad, cliente.nombre, servicios.nom_servicio from serv_cliente, servicios, cliente  where cliente.cod_cliente=serv_cliente.cod_cliente and serv_cliente.cod_servicio=servicios.cod_servicio and serv_cliente.cod_cliente=cliente.cod_cliente and  serv_cliente.cod_estado_caso=23 ";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);
?>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
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
    <p><strong>ESTADOS DE SERVICIOS</strong></p>    
  </center>
  </p>
  <div class="card-header d-flex-fluid">
    <table id="table_id" class='table responsive' cellspacing="0" width="100%">
      <thead>
        <tr>
          <th width="34">#</th>
          <th width="110">Identificaci贸n</th>
          <th width="147">Cliente</th>
          <th width="300">Servicio</th>
           <th width="300">Ciudad</th>
          <th width="129">Estado</th>
           <th>Última Actuación</th>  
           <th>Fecha de actividad</th>  
        <th>Asignado</th>  
        <th>Estado del Servicio(Seguimiento)</th>  
        </tr>
      </thead>
      <tbody>
      <?php
      $i=1;
        while($datos=pg_fetch_assoc($query)){

          $sql5="select distinct cliente.cod_cliente, cliente.nombre, cliente.ciudad, tipo_cliente.descripcion as tipo_cliente, servicios.nom_servicio, serv_cliente.cod_usu_resp, serv_cliente.id_serv_cliente, deta_list_despleg.descripcion as estado_segui_interno, usuarios.nombre as usuario, usuarios.apellidos as apellidos from cliente, serv_cliente, tipo_cliente, servicios, deta_list_despleg, usuarios where usuarios.cod_usuario=serv_cliente.cod_usu_resp and deta_list_despleg.id_list_despleg=serv_cliente.cod_estado_segui and servicios.cod_servicio=serv_cliente.cod_servicio and cliente.tipo_cliente=tipo_cliente.tipo_cliente and cliente.cod_cliente=serv_cliente.cod_cliente and serv_cliente.id_serv_cliente='".$datos['id_serv_cliente']."' ";
          $query5=pg_query($conexion, $sql5);
          $rows5=pg_num_rows($query5);
          @$datos5=pg_fetch_assoc($query5);
                             

               $sql11="select distinct activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from etapa_activ, activ_serv, activi_etapa where etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$datos['id_serv_cliente']."' order by activ_serv.id_activi_serv desc limit 0,1 ";
                  $query11=pg_query($conexion, $sql11);
                  @$datos11=pg_fetch_assoc($query11);
      ?>

        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $datos['cod_cliente']; ?></td>
          <td><?php echo ($datos['nombre']); ?></td>
          <td><?php echo ($datos['nom_servicio']); ?></td>
          <td><?php echo ($datos['ciudad']); ?></td>
          <td><?php echo (($datos11['etapa'])); ?></td>
          <td style="alignment-adjust:auto"><?php echo (($datos11['etapa'].": ".$datos11['actividad'])); ?></td> 
          <td><?php echo (($datos11['fecha_actividad'])); ?></td>
           <td><?php echo (($datos5['usuario']." ".$datos5['apellidos'])); ?></td>
            <td><?php echo (($datos5['estado_segui_interno'])); ?></td>
      </tr>
            
        </td>
        
        </tr>  

        <?php   
        $i++; 

           }

        ?>
      </tbody>
    </table>
  </div> 