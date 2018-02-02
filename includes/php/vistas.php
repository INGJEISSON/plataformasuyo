<?php
if($_POST['vistas']==2) // Vista de menús.
$sql="select * from menu ";
elseif($_POST['vistas']==3) // Vista de submenús.
$sql="select * from submenu where cod_menu='".$_POST['cod_menu']."' ";
elseif($_POST['vistas']==4) // Vista de  permisos de usuario
$sql="select estado.descripcion as estado, submenu.descripcion as submenu from permisos_menu, submenu, estado where permisos_menu.cod_permiso=estado.cod_estado and permisos_menu.cod_submenu=submenu.cod_submenu and permisos_menu.cod_usuario='".$_POST['cod_usuario']."' ";

elseif($_POST['vistas']==5) // Vista de tareas creadas por el usuario (Manual)
$sql="select tareas.id_tarea, tareas.nombre as tarea, tareas.descripcion, proyectos_tar.descripcion as proyecto, tareas.fecha_inicio, tareas.fecha_venci, tareas.prioridad from proyectos_tar, tareas where tareas.cod_proyecto=proyectos_tar.cod_proyecto and tareas.cod_usu_emisor='".$_SESSION['cod_usuario']."' order by tareas.prioridad asc  ";

elseif($_POST['vistas']==6) // Vista de clientes con su respectiva documentación...
$sql="select * from cliente ";

elseif($_POST['vistas']==7) // Vista de clientes en devolución.
$sql="select cliente.nombre, tipo_cliente.descripcion as tipo_cliente, cliente.ciudad, cliente.cod_cliente from devolucion, serv_cliente, cliente, tipo_cliente where cliente.tipo_cliente=tipo_cliente.tipo_cliente and  cliente.cod_cliente=serv_cliente.cod_cliente and devolucion.id_serv_cliente=serv_cliente.id_serv_cliente ";

elseif($_POST['vistas']==8) // Vista de listas desplegables
$sql="select * from listas_despleg";

elseif($_POST['vistas']==9) // Vista de opciones listas desplegables
$sql="select * from deta_list_despleg where tipo_lista='".$_POST['tipo_lista']."' ";

elseif($_POST['vistas']==10) // Vista de dependencias de servicios.
$sql="select distinct servicios.nom_servicio from dependencia_serv, servicios where dependencia_serv.cod_servicio=servicios.cod_servicio ";

elseif($_POST['vistas']==11){

// Vista (Detalle dashboard Clientes pagos)
$sql="select distinct servicios.nom_servicio from dependencia_serv, servicios where dependencia_serv.cod_servicio=servicios.cod_servicio ";

if($_POST['ciudad']!=''){    
                    if($_POST['ciudad']=='Todos')  // Si son todas las ciudad
                      $parametro='';
                      else if($_POST['ciudad']=='solbaq')  // Si son todas las ciudad
                      $parametro="(enc_procesadas.ciudad='Barranquilla' or enc_procesadas.ciudad='Soledad')  and ";
                      else
                      $parametro="enc_procesadas.ciudad='".($_POST['ciudad'])."' and";
                
                    
                  if($_SESSION['tipo_usuario']==2 or $_SESSION['tipo_usuario']==19)
$sql="select distinct enc_procesadas.asesor, enc_procesadas.id_cliente, tipo_encuesta.nombre as encuesta, enc_procesadas.tipo_encuesta, enc_procesadas.cliente,  enc_procesadas.fecha_recepcion, enc_procesadas.fecha_fin_registro, enc_procesadas.archivos, estado.descripcion as estado, enc_procesadas.id_fasfield from  enc_procesadas, det_repor_aseso, estado, tipo_encuesta where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=tipo_encuesta.tipo_encuesta and $parametro enc_procesadas.cod_estado=estado.cod_estado and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'and enc_procesadas.tipo_encuesta=2 and (det_repor_aseso.valor>0 or det_repor_aseso.tipo_pago='Credito')  ";
      else
    $sql="select distinct enc_procesadas.asesor,  enc_procesadas.id_cliente, tipo_encuesta.nombre as encuesta, enc_procesadas.tipo_encuesta, enc_procesadas.cliente,  enc_procesadas.fecha_recepcion, enc_procesadas.fecha_fin_registro, enc_procesadas.archivos, estado.descripcion as estado, enc_procesadas.id_fasfield from  enc_procesadas, estado, tipo_encuesta where enc_procesadas.tipo_encuesta=tipo_encuesta.tipo_encuesta and $parametro enc_procesadas.cod_estado=estado.cod_estado and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'  ";
    }
    else{
      $sql="select distinct enc_procesadas.id_cliente, enc_procesadas.asesor, tipo_encuesta.nombre as encuesta, enc_procesadas.tipo_encuesta, enc_procesadas.cliente,  enc_procesadas.fecha_recepcion, enc_procesadas.fecha_fin_registro, enc_procesadas.archivos, estado.descripcion as estado, enc_procesadas.id_fasfield from  enc_procesadas, estado, tipo_encuesta where enc_procesadas.tipo_encuesta=tipo_encuesta.tipo_encuesta and $parametro enc_procesadas.cod_estado=estado.cod_estado and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'  and enc_procesadas.asesor='".$_POST['asesor']."' ";
    }
} 
//elseif($_POST['vistas']==7) // Estados de servicios
//$sql="select * from cliente ";
//$sql="select documentacion.cod_cliente, documentacion.apellidos, documentacion.nombres, documentacion.ciudad, bodegas.descripcion as bodega, documentacion.cod_estante as estante, documentacion.ubicacion, documentacion.usr_codif from documentacion, bodegas where documentacion.cod_bodega=bodegas.cod_bodega ";


          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);

?>


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

<?php if($_POST['vistas']==2){ // Vista de menús.
?>

<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DE MENUS</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Nombre del menú</th>
                <th width="11%">Campo</th>
                <th width="7%">Ruta</th>               
                <th width="10%">Fecha de creación</th>
                <th width="15%">Ver/Editar</th>
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
      
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["descripcion"]) ?></td>
                <td><?php echo ($datos['campo']) ?></td>
                <td><?php echo ($datos['ruta']) ?></td>
                <td><?php echo ($datos['fecha_registro']) ?></td>
               <td><a href="includes/php/submenus.php?cod_menu=<?php echo $datos['cod_menu']; ?>" tittle='Revisar' class="edicion"><img src='img/edit.png' alt="" width="24" height="24"></a></td>       
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 

<?php if($_POST['vistas']==3){ // Vista de submenús.
?>

<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DE SUBMENUS</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Nombre del submenu</th>
                <th width="7%">Estado</th>              
                <
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
      
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["descripcion"]) ?></td>
                <td><?php echo ($datos['ruta']) ?></td>
                <td><?php echo ($datos['m_order']) ?></td>
                <td><?php echo ($datos['comentario']) ?></td>
               <td><a href="includes/php/submenus.php?cod_menu=<?php echo $datos['cod_menu']; ?>" tittle='Revisar' class="edicion"><img src='img/edit.png' alt="" width="24" height="24"></a></td>       
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 


<?php if($_POST['vistas']==4){ // Vista de permisos de usuario (Menús)
?>

<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DE PERMISOS DE USUARIO</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Nombre del Submenú</th>
                <th width="11%">Estado</th>         
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
      
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["submenu"]) ?></td>
                <td><?php if($datos['estado']==5) echo "Habilitado"; else echo "Deshabilitado" ?></td>                 
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 




<?php if($_POST['vistas']==5){ // Vista de tareas realizadas por él a otro miembro del equipo..
?> 
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DE TAREAS CREADAS</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Proyecto</th>
                <th width="11%">Tarea</th>  
                <th width="11%">Asignados</th> 
                 <th width="11%">Fecha de inicio</th> 
                <th width="11%">Fecha de vencimiento</th> 
                <th width="11%">Prioridad</th>
                <th width="11%">Estado</th>     
                <th width="11%">Editar</th> 
                <th width="11%">Eliminar</th>         
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){

                        // Consulto la cantidad de usuarios asignados por tarea.

                      $sql2="select id_tarea from asigna_tareas where id_tarea='".$datos['id_tarea']."' ";
                      $query2=pg_query($conexion, $sql2);
                      $rows2=pg_num_rows($query2);
      
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["proyecto"]) ?></td>
                <td><?php echo ($datos["tarea"]) ?></td>
                <td><?php echo "(".$rows2.")"; ?></td>
                <td><?php echo ($datos["fecha_inicio"]) ?></td>
                <td><?php echo ($datos["fecha_venci"]) ?></td>
                <td><?php if($datos["prioridad"]==1) echo "Alta"; elseif($datos["prioridad"]==2) echo "Media"; else echo "Baja" ?></td>
                <td><?php  ?></td>
                <td><?php  ?></td>
                <td><?php  ?></td>
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 


<?php if($_POST['vistas']==6){ // Vista de tareas realizadas por él a otro miembro del equipo..
?> 
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">                           
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Identificacion</th>
                <th width="11%">Cliente</th>  
                <th width="11%">Ciudad</th> 
                <th width="11%">Teléfono</th> 
                <th width="11%">Bodega (Física)</th> 
                <th width="11%">Estante</th> 
                <th width="11%">Ubicación</th>  
                <th width="11%">Visualizar</th>       
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
                           
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["cod_cliente"]) ?></td>
                <td><?php echo ($datos["nombre"]); ?></td>
                <td><?php echo $datos["ciudad"]; ?></td>
                <td><?php echo $datos["telefono_1"]; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="includes/php/perfil_cliente.php?cod_cliente=<?php echo $datos['cod_cliente']; ?>" tittle='Revisar' class="edicion"><img src='img/edit.png' alt="" width="24" height="24"></a></td> 
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 

<?php if($_POST['vistas']==7){ // Vista de devoluciones...
?> 
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">                           
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Identificacion</th>
                <th width="11%">Cliente</th>  
                <th width="11%">Tipo de cliente</th> 
                <th width="11%">Ciudad</th>  
                <th width="11%">Ver/Editar</th>              
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
                           
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["cod_cliente"]) ?></td>
                <td><?php echo ($datos["nombre"]); ?></td>
                <td><?php echo ($datos["tipo_cliente"]); ?></td>
                <td><?php echo $datos["ciudad"]; ?></td> 
                <td><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src="includes/php/det_devol_client.php?cod_cliente=<?php echo $datos['cod_cliente']; ?>" tittle='Revisar'><p class='icon-note lg'></p></a></td> 
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 


<?php if($_POST['vistas']==8){ // Vista de listas desplegables..
?> 
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">                           
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                 <th width="6%">Código</th>
                <th width="6%">Nombre</th>
                <th width="11%">Ver/Editar</th>              
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
                           
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["tipo_lista"]) ?></td>
                <td><?php echo ($datos["descripcion"]) ?></td>
                <td><a href="includes/php/det_list_desplegable.php?tipo_lista=<?php echo $datos['tipo_lista']; ?>" class="edicion" tittle='Revisar'><p class='icon-note lg'></p></a></td> 
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 

<?php if($_POST['vistas']==9){ // Vista de OPCIONES DE listas desplegables..
?> 
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">                           
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Nombre</th>
                <th width="11%">Ver/Editar</th>              
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
                           
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["descripcion"]) ?></td>
                <td><a href="includes/php/det_list_desplegable.php?tipo_lista=<?php echo $datos['tipo_lista']; ?>" class="edicion" tittle='Revisar'><p class='icon-note lg'></p></a></td> 
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 



<?php if($_POST['vistas']==10){ // Vista de depedencias de servicios
?> 
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">                           
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Servicio Madre</th>
                <th width="11%">Dependencia</th> 
                <th width="11%">Ver/Editar</th>              
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){

                      // Consultamos el nombre del servicio de la dependencia
                               // $sql2="select nom_servicio from servicios  where cod_servicio='".$datos['cod_servcio_dep']."' ";

                           
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["nom_servicio"]) ?></td>
                <td><?php ?></td>
                <td><a href="includes/php/det_list_desplegable.php?tipo_lista=<?php echo $datos['tipo_lista']; ?>" class="edicion" tittle='Revisar'><p class='icon-note lg'></p></a></td> 
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
  </div>

  <?php
}
?> 



<?php if($_POST['vistas']==11){ // Vista detalle clientes..
?> 
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">                           
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
       <thead>
            <tr>
                <th width="4%">#</th>
                <th width="10%">Asesor</th>
                <th width="21%">Identificación</th>
                <th width="21%">Cliente</th>
                <th width="9%">Tipo de Encuesta</th>
                <th width="11%">Detalle Encuesta</th>
                <th width="8%">Valor</th>
                <th width="12%">Fecha Entrega/Pago</th>
              <th width="12%">Tomó el servicio</th>
               <th width="5%">Estado</th>
              <th width="5%">Ver encuesta</th>
                <th width="5%">Acción</th>
            </tr>
        </thead>
       <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
        if($datos['tipo_encuesta']==1)
         $tipo_encuesta="Diagnóstico";
         if($datos['tipo_encuesta']==2)
         $tipo_encuesta="Asesor y Líderes";
         if($datos['tipo_encuesta']==3)
         $tipo_encuesta="Promotor";     
         if($datos['tipo_encuesta']==5)
         $tipo_encuesta="Prospectos";
                        $sql3="select cliente, asesor, arch_pdf from enc_procesadas where id_fasfield='".$datos['id_fasfield']."' ";
                        $query3=pg_query($conexion, $sql3);
                         $rows3=pg_num_rows($query3);

                             if($query3){
                                  $datos3=pg_fetch_assoc($query3);
                   $archivo_pdf=$datos3['arch_pdf']; 
               }
               // Buscamos informaci贸n del reporte de visita
               
               $sql4="select * from det_repor_aseso where id_fasfield='".$datos['id_fasfield']."' ";
               $query4=pg_query($conexion, $sql4);
                           @$datos4=pg_fetch_assoc($query4);
               
               $sql5="select seguimientos.fecha_registro, estado.descripcion as estado from seguimientos, estado where seguimientos.cod_estado=estado.cod_estado and  seguimientos.id_fasfield='".$datos['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.cod_estado!=0 order by seguimientos.id_segui_llam desc ";
               $query5=pg_query($conexion, $sql5);
               $datos5=pg_fetch_assoc($query5);

                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $datos3["asesor"] ?></td>
                 <td><?php echo @utf8_encode($datos['id_cliente']) ?></td>
                <td><?php echo utf8_encode($datos3['cliente']) ?></td>
                <td><?php echo($tipo_encuesta) ?></td>
                <td><?php if($datos4['resul_visita']=='') echo ($datos4['tipo_visita']); else  echo ($datos4['resul_visita']) ?></td>
                <td><?php echo(number_format($datos4['valor'])) ?></td>
                <td><?php if($datos4['fecha_entrega_diag1']=='') echo $datos4['fecha_compros_pago1']; else        
        echo(($datos4['fecha_entrega_diag1'])) ?></td>
              <td><?php echo "(".($datos4['tom_serv']).")"; ?></td>
               <td><?php echo "(".($datos5['estado']).")"; ?></td>
              <td><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src="http://52.40.169.155/fastfield/<?php echo $datos['encuesta'] ?>/procesados/<?php echo $datos['id_fasfield']."/".$archivo_pdf ?>"><img src="img/icono_pdf.png" width="31" height="31"></a></td>
                <td><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src="includes/php/revi_admin.php?id_fasfield=<?php echo $datos['id_fasfield']; ?>" tittle='Revisar'><img src='img/edit.png' alt="" width="24" height="24"></a>                 
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
                        </div>
                    </div>
  </div>

  <?php
}
?> 
 <script type="text/javascript">
    
$(document).ready(function () {
 $('#table_id').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print'
        ]
    });      
    
});
</script>