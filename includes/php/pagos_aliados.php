<?php
include('../dependencia/conexion.php');
							
 $sql="select enc_procesadas.id_fasfield, enc_procesadas.id_cliente, estado.descripcion as estado, enc_procesadas.asesor, enc_procesadas.ciudad, det_repor_aseso.valor, det_repor_aseso.aliado, enc_procesadas.fecha_filtro, enc_procesadas.cliente FROM det_repor_aseso, enc_procesadas, estado where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and det_repor_aseso.tipo_pago='Credito' and estado.cod_estado=enc_procesadas.cod_estado and enc_procesadas.id_cliente<>0 ";
					$query=pg_query($conexion, $sql);
					$rows=pg_num_rows($query);

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
       <strong>REGISTRO DE INFORMACIÓN DE PAGOS DE ALIADOS</strong>
     </center>
  </p>
  <div class="card-header d-flex align-items-center">
   <table id="table_id" class="table responsive" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Asesor</th>
                <th width="11%">Identificación</th>
                <th width="7%">Cliente</th>
                <th width="7%">Ciudad</th>
                <th width="9%">Aliado</th>
                <th width="11%">Estado</th>
                <th width="12%">Valor aprobado</th>
                <th width="15%">Seguim.</th>
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){	
				
  				?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $datos["asesor"] ?></td>
                <td><?php echo ($datos['id_cliente']) ?></td>
                <td><?php echo ($datos['cliente']) ?></td>
                <td><?php echo ($datos['ciudad']) ?></td>
                <td><?php echo ($datos['aliado']) ?></td>
                <td><?php echo ($datos['estado']) ?></td>
                <td><?php echo ($datos['valor']) ?></td>
               <td><a href="includes/php/revi_pago_aliado.php?id_fasfield=<?php echo $datos['id_fasfield']; ?>" tittle='Revisar' class="edicion"><img src='img/edit.png' width="24" height="24"></a></td>       </tr>
             <?php
			 $i++;
           }
	  ?>
     </tbody>
    </table>
 </div>         
 <script type="text/javascript">
    
$(document).ready(function () {
 $('#table_id').DataTable();
    
});
</script>