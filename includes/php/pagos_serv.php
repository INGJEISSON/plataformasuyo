<?php
@include('../dependencia/conexion.php');
$cod_resp=0;
             if(isset($_POST['email'])){
                        $parametro="serv_cliente.cod_usuario='".$datos['cod_usuario']."' and ";
                        
                        $cod_resp=base64_encode($datos['cod_usuario']);
                        
                    }
                    else
                    $parametro="";   
$sql="select distinct enc_procesadas.id_cliente, enc_procesadas.cliente, enc_procesadas.fecha_filtro, enc_procesadas.ciudad, enc_procesadas.id_fasfield,  det_repor_aseso.det_servi_tomado, det_repor_aseso.n_cuotas, det_repor_aseso.valor, det_repor_aseso.tipo_pago, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.cod_estado=6";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
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
                        <h4 class="page-title">PAGOS DE SERVICIOS </h4> </div>
                </div>

 <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                         
                            <div class="table-responsive">
       <table id="table_id" class='table-hover' cellspacing="0" width="100%">
         <thead>
        <tr>
          <th width="3%">#</th>
          <th width="8%">Identificación</th>
          <th width="18%">Cliente</th>
          <th width="18%">Servicios Tomados</th>
          <th width="7%">Fecha de recepción</th>
          <th width="9%">Ciudad</th>
          <th width="9%">Costo</th>
          <th width="7%">Cuotas</th>
          <th width="11%">Comprobante</th>
          <th width="9%">Acción</th>
          <?php if($_SESSION['tipo_usuario']==1){ ?><th width="9%">Editar</th><?php }  ?>
        </tr>
      </thead>
      <tbody>
      <?php
      $i=1;
        while($datos=pg_fetch_assoc($query)){
           
            /*$query2=pg_query($conexion, "select distinct id_serv_cliente from serv_cliente where cod_cliente='".$datos['cod_cliente']."' and cod_estado=23");
            $rows2=pg_num_rows($query2);
             pg_free_result($query2);*/
      ?>

       
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $datos['id_cliente']; ?></td>
                <td><?php echo ($datos['det_servi_tomado']); ?></td>
                <td><?php echo $datos['fecha_filtro']; ?></td>
                <td><?php echo $datos['ciudad']; ?></td>
                <td><?php echo $datos['valor']; ?></td>
                <td><?php echo $datos['n_cuotas']; ?></td>
                <td><?php  ?></td>
                <td><?php  ?></td>
                <td><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src="includes/php/det_serv_client.php?cod_cliente=<?php echo $datos['id_cliente']; ?>" tittle='Revisar'><p class='icon-note lg'></p></a></td> 
                <td><a href="includes/php/edicion_usu.php?cod_cliente=<?php echo $datos['cod_cliente']; ?>&cod_resp=<?php echo $cod_resp; ?>" tittle='Revisar' class="edicion"><p class='icon-note lg'></p></a></td>
                
              </tr>
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
  $('#table_id').DataTable({
    "bJQueryUI": true,
   // scrollY: 600,
    //paging: false
      dom: 'Bfrtip',
      stateSave: true,
       /* buttons: [
            'copy', 'excel', "print", 'columnsToggle'
        ]*/
        buttons: [

             {
                extend: 'copy',
                text: 'Copiar',
               
            },
             {
                extend: 'excel',
                text: 'Excel',
               
            },
            
            {
                extend: 'print',
                text: 'Imprimir',
                autoPrint: false
            },

             {
                extend: 'colvis',
                text: 'Ver/Ocultar',
                collectionLayout: 'fixed two-column'
              
            },

            
             

        ]
} );
    
});
</script>