<?php
include('../dependencia/conexion.php');
   
//decodificamo id_serv_cliente
$id_serv_cliente=base64_decode($_GET['id_serv_cliente']);


    // consultamos los datos del servicio
  $sql="select cliente.cod_cliente, serv_cliente.cod_servicio, devolucion.v_ejecutado, devolucion.p_identificado, devolucion.exp_caso, devolucion.costo_suyo_devol, devolucion.v_cotizado, devolucion.v_pago_cliente, devolucion.costo_suyo_conti, devolucion.cod_serv_remplazo, devolucion.res_problema from devolucion, cliente, serv_cliente where serv_cliente.id_serv_cliente=devolucion.id_serv_cliente and serv_cliente.cod_cliente=cliente.cod_cliente and devolucion.id_serv_cliente='".$id_serv_cliente."' limit 1 ";
     $query=pg_query($conexion, $sql);
     $datos1=pg_fetch_assoc($query);
     
     // Busco el nombre del responsable..
     
      @$sql10="select nombre from usuarios where cod_usuario='".$datos1['cod_usuario']."' ";
      @$query10=pg_query($conexion, $sql10);
     @$datos10=pg_fetch_assoc($query10);
     
    // Ultima actuación
    
    $sql11="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$id_serv_cliente."' ORDER BY activ_serv.id_activi_serv desc limit 1 ";
    $query11=pg_query($conexion, $sql11);
    @$datos11=pg_fetch_assoc($query11);
        
        
            
//echo "folio: ".$datos1['n_folio_inm'];
                                        
                  //  $parametro='AgendaCallCenter';   // Si son llamadas s贸lo para call center.              
$sql9="select * from cliente where cod_cliente='".$datos1['cod_cliente']."' ";
                    $query9=pg_query($conexion, $sql9);
                    $datos9=pg_fetch_assoc($query9);



  // Buscamos la calificación del director regional..
 $sql112="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$id_serv_cliente."' and etapa_activ.cod_etapa=12 ORDER BY activ_serv.id_activi_serv desc limit 1 ";
    $query112=pg_query($conexion, $sql112);
    @$datos112=pg_fetch_assoc($query112);
        

// COnsultamos lo nombres de los servicios..
      $sql40="select servicios.nom_servicio as descripcion, servicios.cod_servicio  from servicios";
      $query40=pg_query($conexion, $sql40);


      // COnsultamos lo nombres de los servicios..
      $sql41="select cod_serv_remplazo as cod_servicio  from devolucion where id_serv_cliente='".$id_serv_cliente."' ";
      @$query41=pg_query($conexion, $sql41);
      @$datos41=pg_fetch_assoc($query41);


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<link rel="stylesheet" href="../../js/colorbox-master/example1/colorbox.css" />
<script src="../../js/colorbox-master/jquery.colorbox-min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../../js/datepicker-master/dist/datepicker.js"></script>
<link rel="stylesheet" href="../../js/datepicker-master/dist/datepicker.css">


<script>
  $(document).ready(function(){
        
        $(".edicion").colorbox({
          iframe:false, 
          width:"100%", 
          height:"100%",
          overlayClose:false,
          //escKey:
          });
          
          $("#panel_ubi_predio").hide(); // Ubicación del predio.
          
           $("#exp_ubi_predio").click(function(){
               $("#exp_ubi_predio").slideToggle( "slow", function() {               
                    
                     $("#panel_ubi_predio").show();
               });
           });
           
        $('#fecha_firm_compro_contr').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });
      
        $('#fecha_firm_contr').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });
$('#fecha_ini_tramite').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });
        
          
          
function daysBetween(f1, f2){ 
var aFecha1 = f1.split('-'); 
 var aFecha2 = f2.split('-'); 
 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
 return dias;   

} 


// Calculmos fecha de compromiso

$("#fecha_firm_contr").change(function(){
    
var hoy = new Date();
var dd = hoy.getDate();
var mm = hoy.getMonth()+1; //hoy es 0!
var yyyy = hoy.getFullYear();

var fecha_hoy=(yyyy+'-'+mm+'-'+dd);
                // La suma  del tiempo de compromiso y la fecha de compromiso...

                var fecha_firm_contr=$("#fecha_firm_contr").val();
                var tiempo_compros=$("#tiempo_compros").val();
               
                var separar=fecha_firm_contr.split('-');
             
                var dia=separar[2];
                var mes=separar[1];
                var ano=separar[0];
                
             dia=parseInt(dia)+parseInt(tiempo_compros);
            
                    if(dia>=30){
                            mes=parseInt(mes)+1;
                                if(mes==12){
                                    ano=parseInt(ano)+1;
                                dia=1;
                                mes=1;
                                    
                                }else{
                                dia=30-dia;
                                }
                     }
                $("#fecha_compro_contr").val(ano+'-'+mes+'-'+dia);
         
    var tiempo_venc=daysBetween(fecha_hoy,$("#fecha_compro_contr").val());
    $("#tiempo_venc").val(tiempo_venc);
    if(tiempo_venc<0)
        $("#cod_estado_venc").val("VENCIDO");
    else if(tiempo_venc==0)
     $("#cod_estado_venc").val("A TIEMPO");
    else
         $("#cod_estado_venc").val("SE VENCERÁ");
    
});

          $("#guardar").click(function(){

                             
                     var id_serv_cliente=<?php echo $id_serv_cliente ?>; 
                     var v_ejecutado=$("#v_ejecutado").val();
                     var p_identificado=$("#p_identificado").val();
                     var res_problema=$("#res_problema").val();
                     var exp_caso=$("#exp_caso").val();
                     var cod_serv_reemplazo=$("#cod_serv_reemplazo").val();
                     var costo_suyo_devol=$("#costo_suyo_devol").val();
                     var costo_suyo_conti=$("#costo_suyo_conti").val();
                     var v_cotizado=$("#v_cotizado").val();
                     var v_pago_cliente=$("#v_pago_cliente").val();


                     if(costo_suyo_devol=!"" && costo_suyo_devol!="" & v_ejecutado!=""){

   var datos='add_segui_devol='+1+'&id_serv_cliente='+id_serv_cliente+'&v_ejecutado='+v_ejecutado+'&p_identificado='+p_identificado+'&res_problema='+res_problema+'&exp_caso='+exp_caso+'&cod_serv_reemplazo='+cod_serv_reemplazo+'&exp_caso='+exp_caso+'&cod_serv_reemplazo='+cod_serv_reemplazo+'&costo_suyo_conti='+costo_suyo_conti+'&costo_suyo_devol='+costo_suyo_devol+'&v_cotizado='+v_cotizado+'&v_pago_cliente='+v_pago_cliente;

                                    $.ajax({
                                                type: "POST",
                                                data: datos,
                                                url: "g_procesos.php",
                                                success: function(valor){

                                                        if(valor==1)
                                                            alert("Información actualizada");
                                                        else
                                                            alert("Hubo error de comunicación con el servidor, intente de nuevo.");
                                                }
                                    });
                      }else
                      alert("Por favor introduzca los campos con asteríscos, son obligatorios (*)");


                   

         });
var id_serv_cliente="<?php echo $id_serv_cliente ?>";
var datos='id_serv_cliente='+id_serv_cliente+'&revi_serv2='+1;
    
          //  $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                             //   $("#cargar2").hide();

                              //    alert("Se ha agregado su observación al cliente");   
                                  $("#history_revi3").html(valor);

                               }else{
                                    
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }

                        }
                  });

/*var id_fasfield="<?php echo $datos1['cod_cliente'] ?>";
var datos='id_fasfield='+id_fasfield+'&revi_revi_call2='+1+'&tipo_seguimiento='+6;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();
                              //    alert("Se ha agregado su observación al cliente");   
                                  $("#history_revi4").html(valor);

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });*/
          
  });
</script>

 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    
                    <div class="card-header d-flex align-items-center" style="background-color:#CCC; border-radius:20">
                      <table width="467" border="0">
                        <tr>
                          <td width="181">Cliente:</td>
                          <td width="276"><?php echo ($datos9['nombre']) ?></td>
                        </tr>
                        <tr>
                          <td>Responsable:</td>
                          <td><?php echo $datos10['nombre'] ?></td>
                        </tr>                     
                      </table>
                    </div>
              <center><input type="button" name="guardar" id='guardar' class='btn btn-warning' value='Guardar'></center>
                    <div class="card-body">
                      <p> 
    <div class="panel-group" id="accordion">
  
 <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
       Seguimiento (Devolución)</a>
      </h4>
    </div>
    <div id="collapse6" class="panel-collapse collapse in">
      <div class="panel-body">
      <table width="483" border="0" class="table responsive">
      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Servicio recomendado contratado'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,11982760],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Servicio recomendado contratado</span></td>
        <td><?php echo base64_decode($_GET['nom_servicio']) ?></td>
      </tr>

      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Valor ejecutado de conformidad con la etapa'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,16770457],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Valor cotizado</span></td>
        <td><input type="text" id='v_ejecutado'  class="form-control" value="<?php echo $datos1['v_cotizado'] ?>"></td>
      </tr>

       <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Valor ejecutado de conformidad con la etapa'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,16770457],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Valor pagador por el cliente</span></td>
        <td><input type="text" id='v_ejecutado'  class="form-control" value="<?php echo $datos1['v_pago_cliente'] ?>"></td>
      </tr>

      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Valor ejecutado de conformidad con la etapa'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,16770457],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Valor gastado hasta el momento</span></td>
        <td><input type="text" id='v_ejecutado'  class="form-control" value="<?php echo $datos1['v_ejecutado'] ?>"></td>
      </tr>
      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Problema Identificado'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,11982760],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Problema Identificado</span></td>
        <td><input type="text" id='p_identificado'  class="form-control" value="<?php echo $datos1['p_identificado'] ?>"></td>
      </tr>
      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Responsable del problema'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,11982760],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Responsable del problema</span></td>
        <td><input type="text" id='res_problema'  class="form-control" value="<?php echo $datos1['res_problema'] ?>"></td>
      </tr>
      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Explicación del caso'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,11982760],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Explicación del caso</span></td>
        <td><input type="text" id='exp_caso'  class="form-control" value="<?php echo $datos1['exp_caso']?>"></td>
      </tr>
      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Costos para Suyo en caso de devolución '}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,16770457],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Costos para Suyo en caso de devolución </span></td>
        <td><input type="text" id='costo_suyo_devol'  class="form-control" value="<?php echo $datos1['costo_suyo_devol'] ?>"></td>
      </tr>
      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Costos para Suyo en caso de que decida continuar el servicio'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,16770457],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Costos para Suyo en caso de que decida continuar el servicio</span></td>
        <td><input type="text" id='costo_suyo_conti' class="form-control" value="<?php echo $datos1['costo_suyo_conti'] ?>"></td>
      </tr>
      <tr>
        <td><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
          <span data-sheets-value="{'1':2,'2':'Estado de vencimiento del servicio'}" data-sheets-userformat="{'2':29695,'3':[null,0],'4':[null,2,11982760],'5':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'6':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'7':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'8':{'1':[{'1':2,'2':0,'5':[null,2,0]},{'1':0,'2':0,'3':3},{'1':1,'2':0,'4':1}]},'9':1,'10':1,'11':4,'12':0,'15':'Arial','16':10,'17':1}">Estado de vencimiento del servicio</span></td>
        <td>&nbsp;</td>
      </tr>
    
      <tr>
        <td><b>(*)</b>Última actuación:   </td>
        <td><?php echo ($datos11['etapa'].": ".$datos11['actividad']); ?></td>
      </tr>
      <tr>
        <td><b>(*)</b>Fecha de (Última actuación):</td>
        <td><?php echo ($datos11['fecha_actividad']); ?> </td>
      </tr>
   </table></div>
    </div>
  </div>

<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
      Servicio de reemplazo</a>
      </h4>
    </div>
    <div id="collapse7" class="panel-collapse collapse">
   <select name="firm_contrato" id="cod_serv_reemplazo" class="form-control">

    <option value="" selected='selected'>Seleccionar</option>
        <?php

                while($datos20=pg_fetch_assoc($query40)){

        ?>
           <option value="<?= $datos20['cod_servicio'] ?>"<?php if($datos20['cod_servicio']==$datos41['cod_servicio']){ ?> selected='selected' <?php } ?>><?php echo ($datos20['descripcion'])?></option>
     <?php

               }

        ?>
        </select>
    </div>


<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
      Calificación del director según el riesgo de reputación</a>
      </h4>
    </div>
    <div id="collapse8" class="panel-collapse collapse">
   
   <table width="483" border="0" class="table responsive">
     <tr>
        <td width="321"><b></b>Calificación</td>
        <td width="860"><?php echo $datos112['actividad'] ?></td>
      </tr>
      <tr>
        <td>Comentarios adicionales de los directores</td>
        <td><?php echo $datos112['observacion'] ?></td>
      </tr>
   </table>
   </div>
    </div>

<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">
      Decisión de comité</a>
      </h4>
    </div>
    <div id="collapse9" class="panel-collapse collapse">
   
   <table width="483" border="0" class="table responsive">
     <tr>
        <td width="321"><b></b>Estado</td>
        <td width="860"></td>
      </tr>
      <tr>
        <td>Valor de la devolución</td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td>Fecha de devolución</td>
        <td>&nbsp;</td>
      </tr>
   </table>
   </div>
    </div>


  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">
      Política de comunicación (Última comunicación)</a>
      </h4>
    </div>
    <div id="collapse10" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi4' align="center">                           </div>
    <p><a href="../../includes/php/revi_call2.php?cod_cliente=<?php echo $datos1['cod_cliente'] ?>&tipo_seguimiento=6&id_serv_cliente=<?php echo $id_serv_cliente ?>" class='edicion'>Nueva comunicación</a></p></div>
    </div>
  </div>

   <div class="panel panel-primary">
    <div class="panel-heading ">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse11">
      Actvidades (Última actividad)</a>
      </h4>
    </div>
    <div id="collapse11" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi3' align="center">
                           </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Nueva actividad</a></div>
    </div>
  </div>
  

                      </p>
                      <p>&nbsp;</p>
                    </div>
                  </div>
                </div>
               
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </section>