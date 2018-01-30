<?php
$sql="select documentacion.usr_codif,  detalle_docu.cod_cliente, categorias_docu.descripcion as categoria, detalle_docu.ruta as archivo, usuarios.nombre, usuarios.apellidos, estado.descripcion as estado from documentacion, detalle_docu, categorias_docu, estado, usuarios where estado.cod_estado=detalle_docu.cod_estado and documentacion.cod_cliente=detalle_docu.cod_cliente and categorias_docu.id_cate_docu=detalle_docu.id_cate_docu and usuarios.cod_usuario=detalle_docu.cod_usuario and detalle_docu.cod_cliente='".$_POST['cod_cliente']."' ";
					$query=pg_query($conexion, $sql);
					$rows=pg_num_rows($query);

?>


<script>
  $(document).ready(function(){        
        $(".edicion").colorbox({
          iframe:true, 
          width:"100%", 
          height:"100%",
          overlayClose:false,
          //escKey:
          });          
  });
</script>


<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DOCUMENTOS DE USUARIO</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Categoria</th>
                <th width="11%">Archivo</th>
                <th width="7%">Estado</th>
                <th width="15%">Ver</th>
                <th width="15%">Editar</th>
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
			
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["categoria"]) ?></td>
                <td><?php echo ($datos['archivo']) ?></td>
                <td><?php echo ($datos['estado']) ?></td>
            <td><a href="files/clientes/<?php echo $datos['usr_codif']; ?>/<?php echo $datos['categoria']; ?>/<?php echo $datos['archivo']; ?>" tittle='Agregar documentacion' class="edicion">Ver</a></td>       
            <td><a href="includes/php/add_docu.php?id_cliente=<?php echo $datos['cod_cliente']; ?>" tittle='Agregar documentacion' class="edicion">Deshabilitar</a></td>             
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