<?php
$sql="select documentacion.apellidos, documentacion.cod_cliente, documentacion.nombres, documentacion.ciudad, tipo_docu.descripcion as tipo_documentacion from documentacion, tipo_docu where tipo_docu.tipo_docu=documentacion.tipo_docu ";
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


<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DE CLIENTES (DOCUMENTACIÓN)</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Nombre</th>
                <th width="11%">Apellidos</th>
                <th width="7%">Ciudad</th>
                <th width="9%">Tipo de usuario</th>
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
                <td><?php echo ($datos["nombres"]) ?></td>
                <td><?php echo ($datos['apellidos']) ?></td>
                <td><?php echo ($datos['ciudad']) ?></td>
                <td><?php echo ($datos['tipo_documentacion']) ?></td>
            <td><a href="includes/php/add_docu.php?id_cliente=<?php echo $datos['cod_cliente']; ?>" tittle='Agregar documentacion' class="edicion">Editar</a></td>                  
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