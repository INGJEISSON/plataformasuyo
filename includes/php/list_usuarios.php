<?php
$sql="select usuarios.cod_usuario, usuarios.email, usuarios.nombre, usuarios.apellidos, tipo_usuario.descripcion as tipo_usuario, grupo_usuarios.descripcion as grupo_usuario, estado.descripcion as estado from usuarios, estado, grupo_usuarios, tipo_usuario  where grupo_usuarios.cod_grupo=tipo_usuario.cod_grupo and usuarios.tipo_usuario=tipo_usuario.tipo_usuario and estado.cod_estado=usuarios.cod_estado  ";
					$query=pg_query($conexion, $sql);
					$rows=pg_num_rows($query);

?>


<script>
  $(document).ready(function(){        
       /* $(".edicion").colorbox({
          iframe:false, 
          width:"100%", 
          height:"100%",
          overlayClose:false,
          //escKey:
          });    */      
  });
</script>


<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DE USUARIOS</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Nombre</th>
                <th width="11%">Apellidos</th>
                <th width="7%">Email</th>
                <th width="9%">Grupo</th>
                <th width="11%">Rol o tipo de usuario</th>
                <th width="12%">Estado</th>
                <th width="10%">Accesos</th>
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
                <td><?php echo ($datos["nombre"]) ?></td>
                <td><?php echo ($datos['apellidos']) ?></td>
                <td><?php echo ($datos['email']) ?></td>
                <td><?php echo ($datos['grupo_usuario']) ?></td>
                <td><?php echo ($datos['tipo_usuario']) ?></td>
                <td><?php echo ($datos['estado']) ?></td>
                <td>&nbsp;</td>
              <td><a href="includes/php/revi_call.php?id_fasfield=<?php echo $datos['id_fasfield']; ?>" tittle='Revisar' class="edicion"></a></td>
               <td><a href="includes/php/revi_call.php?id_fasfield=<?php echo $datos['id_fasfield']; ?>" tittle='Revisar' class="edicion"><img src='img/edit.png' alt="" width="24" height="24"></a><a href="includes/php/revi_call.php?id_fasfield=<?php echo $datos['id_fasfield']; ?>" tittle='Revisar' class="edicion"></a></td>       
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
 <script type="text/javascript">
    
$(document).ready(function () {
 $('#table_id').DataTable();
    
});
</script>