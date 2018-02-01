<?php
if(empty($_POST['email']))
include('../dependencia/conexion.php');
                 if(isset($_POST['email'])){
                      if( $datos['tipo_usuario']==22)
                        $parametro="diagno_client.cod_usu_legal='".$datos['cod_usuario']."' and ";
                      else
                        $parametro="diagno_client.cod_usu_tecnico='".$datos['cod_usuario']."'  and ";  
                        
                        $cod_resp=base64_encode($datos['cod_usuario']);
                        
                    }
                    else
                    $parametro="";  

  $sql="select  distinct cliente.cod_cliente, cliente.nombre as cliente, cliente.telefono_1, cliente.ciudad, cliente.barrio, tipo_cliente.descripcion as tipo_cliente from cliente, diagno_client, tipo_cliente where $parametro cliente.tipo_cliente=tipo_cliente.tipo_cliente and cliente.cod_cliente=diagno_client.cod_cliente and diagno_client.cod_estado=23 ";
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
                        <h4 class="page-title">CLIENTES CON DIAGNÓSTICOS </h4> </div>
                </div>

 <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                         
                            <div class="table-responsive">
       <table id="table_id" class='table-hover' cellspacing="0" width="100%">
         <thead>
        <tr>
          <th width="3%">#</th>
           <th width="7%">Ver</th>
          <th width="8%">Identificación</th>
          <th width="18%">Cliente</th>  
          <th width="18%">Barrio</th> 
          <th width="18%">Ciudad</th> 
          <th width="7%"># Teléfonos</th>  
          <th width="7%"># Diagnósticos</th> 
          <th width="7%">Pago acumulado</th> 
          <th width="7%">Valor total</th> 
          <th width="7%">Primer contacto</th>
          <th width="7%">Forma de aquisición</th>
          <th width="7%">Fecha de primer contacto</th>
         
        </tr>
      </thead>
      <tbody>
      <?php
      $i=1;
        while($datos=pg_fetch_assoc($query)){

         // $archivo_pdf=$datos['arch_pdf'];
           
            $query2=pg_query($conexion, "select cod_cliente from diagno_client where cod_cliente='".$datos['cod_cliente']."' ");
            $rows2=pg_num_rows($query2);
            //@$datos2=pg_fetch_assoc($query2);
            // @$archivo_pdf2=$datos2['arch_pdf'];

      ?>

       
              <tr>
                <td><?php echo $i; ?></td>
                 <td><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src="includes/php/det_diag_client.php?cod_cliente=<?php echo $datos['cod_cliente']; ?>&cod_resp=<?php echo $cod_resp; ?>" tittle='Revisar'><p class='icon-note lg'></p></a></td> 
                <td><?php echo $datos['cod_cliente']; ?></td>
                <td><?php echo $datos['cliente']; ?></td>             
                <td><?php echo $datos['barrio']; ?></td>
                <td><?php echo ($datos['ciudad']) ?></td>
                <td><?php // echo $rows2 ?></td>
                <td><?php echo $rows2 ?></td>     
                <td><?php echo $rows2 ?></td>     
                <td><?php echo $rows2 ?></td>     
                <td><?php echo $rows2 ?></td>     
                <td><?php echo $rows2 ?></td>     
                <td><?php echo $rows2 ?></td>     
              
                
              </tr>
            <?php   
             pg_free_result($query2);
           
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