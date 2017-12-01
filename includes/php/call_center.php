<?php
include('../dependencia/conexion.php');

					$parametro='AgendaCallCenter';	 // Si son llamadas sólo para call center.				
$sql="select enc_procesadas.asesor, enc_procesadas.ciudad, enc_procesadas.fecha_filtro, enc_procesadas.tipo_agenda, tipo_encuesta.nombre as encuesta, enc_procesadas.cliente,  enc_procesadas.fecha_recepcion, enc_procesadas.Barrio,  estado.descripcion as estado, enc_procesadas.id_fasfield, enc_procesadas.telefono from  enc_procesadas, estado, tipo_encuesta where enc_procesadas.tipo_encuesta=tipo_encuesta.tipo_encuesta and enc_procesadas.cod_estado=estado.cod_estado and enc_procesadas.tipo_encuesta=5 and enc_procesadas.tipo_agenda='".$parametro."' and enc_procesadas.fecha_filtro >= '2017-07-01' ";
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
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">AGENDAMIENTO DE VISITAS (CALL CENTER)</h4> </div>
                </div>

 <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                         
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Asesor</th>
                <th width="11%">Nombre</th>
                <th width="7%">Ciudad</th>
                <th width="9%">Barrio</th>
                <th width="11%">Teléfono</th>
                <th width="11%">Aliado</th>
                <th width="11%">Fecha de recepcion</th>
                <th width="12%">Estado de llamada</th>
                <th width="10%">Ultima llamada</th>
                <th width="10%">Observ</th>
                <th width="15%">Seguim.</th>

            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
			
				 $tipo_encuesta="Prospectos";                     
                        
						
									// BUscamos la cantidad de observaciones que tiene el prospecto
									 $sql2="select seguimientos.fecha_registro, estado.descripcion as estado from seguimientos, estado where seguimientos.cod_estado=estado.cod_estado and  seguimientos.id_fasfield='".$datos['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.cod_estado!=0 order by seguimientos.id_segui_llam desc  ";
									$query2=pg_query($conexion, $sql2);
									$rows2=pg_num_rows($query2);
									$datos2=pg_fetch_assoc($query2);

                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $datos["asesor"] ?></td>
                <td><?php echo ($datos['cliente']) ?></td>
                <td><?php echo ($datos['ciudad']) ?></td>
                <td><?php echo ($datos['Barrio']) ?></td>
                <td><?php echo ($datos['telefono']) ?></td>
                 <td><?php echo ($datos['telefono']) ?></td>
               <td><?php echo ($datos['fecha_filtro']) ?></td>
                <td><?php echo ($datos2['estado']) ?></td>
                <td><?php echo ($datos2['fecha_registro']) ?></td>
              <td><?php echo $rows2 ?></td>
               <td><a href="includes/php/revi_call.php?id_fasfield=<?php echo $datos['id_fasfield']; ?>" tittle='Revisar' class="edicion"><img src='img/edit.png' width="24" height="24"></a></td>       </tr>
             <?php
			 $i++;
           }
	  ?>
     </tbody>
    </table> </div>
                        </div>
                    </div>
                </div>    
 <script type="text/javascript">
    
$(document).ready(function () {
 $('#table_id').DataTable();
    
});
</script>