<?php
$sql="select usuarios.cod_usuario, usuarios.email, usuarios.nombre, usuarios.apellidos, tipo_usuario.descripcion as tipo_usuario, grupo_usuarios.descripcion as grupo_usuario, estado.descripcion as estado from usuarios, estado, grupo_usuarios, tipo_usuario  where grupo_usuarios.cod_grupo=tipo_usuario.id_grupo and usuarios.tipo_usuario=tipo_usuario.tipo_usuario and estado.cod_estado=usuarios.cod_estado  ";
					$query=mysqli_query($conexion, $sql);
					$rows=mysqli_num_rows($query);

?>

<link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="js/custom.min.js"></script>
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
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
                while($datos=mysqli_fetch_assoc($query)){
			
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo utf8_encode($datos["nombre"]) ?></td>
                <td><?php echo utf8_encode($datos['apellidos']) ?></td>
                <td><?php echo utf8_encode($datos['email']) ?></td>
                <td><?php echo utf8_encode($datos['grupo_usuario']) ?></td>
                <td><?php echo utf8_encode($datos['tipo_usuario']) ?></td>
                <td><?php echo utf8_encode($datos['estado']) ?></td>
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