<?php
include('../dependencia/conexion.php');
$cod_resp=base64_decode($_GET['cod_resp']);
		        if(isset($cod_resp)){
		          //  $parametro="serv_cliente.cod_usu_resp='".$cod_resp."' and ";
		            $parametro="";
		        }else
		        $parametro="";
										
					//$parametro='AgendaCallCenter';	 // Si son llamadas s贸lo para call center.				
$sql="select distinct diagno_client.id_elab_diag, enc_procesadas.asesor, estado.descripcion as estado, diagno_client.barrio, diagno_client.ciudad, diagno_client.direccion from diagno_client, enc_procesadas, estado where diagno_client.cod_estado=estado.cod_estado and diagno_client.id_fasfield=enc_procesadas.id_fasfield and enc_procesadas.id_cliente='".$_GET['cod_cliente']."'   ";
					$query=pg_query($conexion,$sql);
					$rows=pg_num_rows($query);

$sql2="select * from cliente where  cod_cliente='".$_GET['cod_cliente']."' ";
$query2=pg_query($conexion, $sql2);
$datos2=pg_fetch_assoc($query2);

?>
<script src="../../plugins/bower_components/jquery/dist/jquery.min.js"></script>
<link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/style.css" rel="stylesheet">
 <link href="../../css/colors/megna-dark.css" id="theme" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="../../js/colorbox-master/example1/colorbox.css" />
<script src="../../js/colorbox-master/jquery.colorbox-min.js"></script>


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
                        <h4 class="page-title"> <strong>DIAGNÓSTICOS DEL CLIENTE: <?php echo  ($datos2['nombre']) ?> </strong></h4> </div>
                </div>

 <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                         
                            <div class="table-responsive">
    <table id="table_id2" class='table responsive' cellspacing="0" width="100%">
      <thead>
        <tr>
          <th width="3%">#</th>
          <th>Asesor</th>
          <th>Estado</th>
          <th>Ciudad del predio</th>
          <th>Barrio</th>
          <th>Teléfono</th>
          <th>Dirección</th>
          <th>Tipo Diagnóstico</th>
          <th>Afectaciones</th>
          <th>Relación jurídica</th>
          <th>Call center</th>
          <th>Última actuación</th>
          <th>Acuerdo(Pago)</th>
          <th>Fuente(Pago)</th>
          <th>Valor pagado</th>
          <th>Seguimiento</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  $i=1;
	   while($datos=pg_fetch_assoc($query)){ 
	       
	      /* $sql11="select distinct usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$datos['id_serv_cliente']."'  limit 1 ";
    $query11=pg_query($conexion, $sql11);
    @$datos11=pg_fetch_assoc($query11);*/
     
	   
	   ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td width="5%"><?php echo ($datos['asesor']); ?></td>
          <td><?php echo ($datos['estado']); ?></td>
          <td><?php echo $datos['ciudad']; ?></td>
          <td><?php echo $datos['barrio']; ?></td>
          <td><?php //echo $datos['telefono']; ?></td>
          <td><?php echo $datos['direccion']; ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td style="alignment-adjust:auto"><?php  // echo ($datos11['etapa'].": ".$datos11['actividad']); ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td><a href="segui_diag.php?&id_elab_diag=<?php echo base64_encode($datos['id_elab_diag']); ?>" tittle='Seguimiento' class='ediicion'><p class='icon-note lg'></p></a>
          		
          </td>
           </tr>
          <?php 
          //78 pg_free_result($query11);
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
$('#table_id2').DataTable();
    
});
</script>