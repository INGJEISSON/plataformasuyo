<?php
include('../dependencia/conexion.php');

      $sql="select  * from cliente where cod_cliente='".$_GET['cod_cliente']."' ";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);
          $datos=pg_fetch_assoc($query);        




if($_GET['tipo']==1){
  $etapa=1;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 9 and 19 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==2){
  $etapa=1;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 24 and 62 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}
if($_GET['tipo']==3){
  $etapa=1;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 78 and 85 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==4){
  $etapa=1;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 65 and 77 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==5 ){ // Listado de variables de  revisión de bases de datos
  $etapa=1;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 86 and 91 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==6 ){ // Listado de variables de  revisión de mapas colaborativos
  $etapa=1;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 92 and 97 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==7 ){ // Listado de variables de análisis FMI
  $etapa=2;

              $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 112 and 132 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==8 ){ // Listado de variables de análisis titularidad
  $etapa=2;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 98 and 111 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}
if($_GET['tipo']==9 ){ // Listado de variables de análisis titularidad
  $etapa=2;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 133 and 136 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}
if($_GET['tipo']==10 ){ // Listado de variables de análisis titularidad
  $etapa=2;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 137 and 139 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==11 ){ // Listado de variables de análisis titularidad
  $etapa=2;

               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 140 and 142 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==12){ // Listado para afectaciones.. (Técnico)

}
if($_GET['tipo']==13){ // Registro de FInalización de concepto.

   $etapa=8; 
       $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and id_activi_diag between 143 and 144 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}

if($_GET['tipo']==14){ // REgistro de Finalización de cotización

   $etapa=10; 
       $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 145 and 142 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   

}
if($_GET['tipo']==15){ // Registro de  control de calidad (Equipo)

   $etapa=9; 
       $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_GET['cod_equipo']."'  and id_activi_diag between 147 and 149 order by id_activi_diag ";
                   $query3=pg_query($conexion, $sql3); 
                              
                   $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                  $query4=pg_query($conexion, $sql4);
                  $datos4=pg_fetch_assoc($query4);   
   
}



	
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../js/colorbox-master/example1/colorbox.css" />
<script src="../../js/colorbox-master/jquery.colorbox-min.js"></script>
<script src="../../js/datepicker-master/dist/datepicker.js"></script>
<link rel="stylesheet" href="../../js/datepicker-master/dist/datepicker.css">

 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Actividades del diagnostico:  <?php echo ($datos['nombre']);  ?> </h3>
                      <p><strong>ETAPA ACTUAL:</strong> <?php echo strtoupper(($datos4['descripcion']));  ?> </p>
                       <p><strong>FICHA:</strong> <?php echo strtoupper((base64_decode($_GET['ficha'])));  ?> </p>
                      
                    </div>
                    <div class="card-body">
                         <table width="870" border="0" id="pan_add_revision" class="table responsive" cellpadding="1" cellspacing="4">
                           <tr>
                             <td width="189"><strong>Actividad</strong></td>
                             <td width="26">&nbsp;</td>
                             <td width="227"><strong>Detalle:</strong></td>
                             <td width="11">&nbsp;</td>
                             <td width="242"><strong>Fecha de Actividad</strong></td>
                             <td width="16" >&nbsp;</td>
                             <td width="113"><strong>Acción</strong></td>
                           </tr>
                           <tr>
                             <td height="46"><select name="select" id="cod_activi_etapa" class="form-control">
                               <option value="1" selected="selected">Sin actividad</option>
                              <?php while($datos2=pg_fetch_assoc($query3)){ ?>
                               
                               <option value="<?= $datos2['cod_activi_etapa'] ?>"> <?php echo ($datos2['descripcion'])?></option>
                               <?php } ?>
                             </select></td>
                             <td><label for="textfield"></label></td>
                             <td><select name="select" id="observacion" class="form-control">  
                             <option value="2">Ninguno</option>
                             </select>

                                <input type=text class="form-control" name="textfield2" id="observacion2">
                             </td>
                             <td>&nbsp;</td>
                             <td><input type="date" class="form-control" name="textfield2" id="fecha_actividad"></td>
                             <td>&nbsp;</td>
                             <td><input type="button" class="btn btn-primary" name="button" id="g_revision" value="Registrar"></td>
                           </tr>
                         </table>
                         <div id='historial_revi' align="center">
                           <hr>&nbsp;</hr>
                           <table width="155" border="0" cellpadding="0" cellspacing="0">
                             <tr align="center">
                               <td width="106"><strong>Agregar revisión</strong></td>
                             </tr>
                             <tr align="center">
                               <td><img src="../../img/if_Plus_206460.png" id="add_revision" style="cursor:pointer" title="Agregar revisión" width="38" height="38"></td>
                             </tr>
                           </table>
                           <strong>Observaciones</strong>
                           
                           
                           <div id='history_revi' align="center">
                           </div>
                      </div>
                      <p>
                      <div id='cargar2' align="center"> 
                            <img src="../../img/loading_azul.gif" id="cargar2">
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
         
  <script>

$(document).ready(function(){
$("#cargar2").hide();
$("#archrev").hide();
$("#archrev2").hide();
$("#pan_add_revision").hide();

$("#observacion").hide();
$("#observacion2").hide();

$('#fecha_actividad').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });

$("#add_revision").click(function(){
$("#pan_add_revision").show();

});
	
$("#cod_estado").change(function(){
        var cod_estado=$("#cod_estado").val();

           if(cod_estado=='Agendada'){
            $("#archrev").show();
$("#archrev2").show();
		   }
            else{
             $("#archrev").hide();
$("#archrev2").hide();
			}

  });

$("#cod_activi_etapa").change(function(){
  var cod_activi_etapa=$("#cod_activi_etapa").val();
  var b_lista_despleg_diag=1;
    var datos='b_lista_despleg_diag='+b_lista_despleg_diag+'&cod_activi_etapa='+cod_activi_etapa;
$("#observacion").hide();
  $("#observacion2").hide();
            $.ajax({
                  type: "POST",
                  data: datos,
                  url: 'g_procesos.php?'+datos,
                  success: function (valor){

                        if(valor=='<option value=2>Ninguno</option>'){
                          $("#observacion").empty();
                          $("#observacion2").show();
                          $("#observacion").hide();
                          $("#observacion").html(valor);
                        }else{
                          $("#observacion").empty();
                          $("#observacion").html(valor);
                          $("#observacion2").hide();
                           $("#observacion").show();                         

                        }
                  }

            });

});





$("#g_revision").click(function(){  // Abregamos revisión .....

var cod_activi_etapa=$("#cod_activi_etapa").val();
var observacion=$("#observacion").val();
  if(observacion==2)
  var observacion=$("#observacion2").val();

var fecha_actividad=$("#fecha_actividad").val();
var id_serv_cliente="<?php echo "$_GET[id_elab_diag]" ?>";
var tipo="<?php echo "$_GET[tipo]" ?>";
var etapa="<?php echo $etapa ?>";
var datos='id_elab_diag='+id_serv_cliente+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&add_revi_diag='+1+'&fecha_actividad='+fecha_actividad+'&tipo='+tipo+'&etapa='+etapa;
    
    if(cod_activi_etapa!=1){
		
			if(fecha_actividad==""){
						alert("Por favor introduzca la fecha que ha realizado la actividad.");
			}else{

            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();
                                  alert("Se ha agregado su actividad al cliente");   
                                  $("#history_revi").html(valor);
                                 

                                      var id_elab_diag="<?php echo "$_GET[id_elab_diag]" ?>";
var datos='listar_actividades_diag='+1+'&tipo='+tipo+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag+'&etapa='+etapa;
    
          
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                              if(tipo==1){
                                 $("#list_revi_docu").empty();                             
                                   $("#list_revi_docu").html(valor);
                              }
                              else if(tipo==2){
                                 $("#list_revi_docu2").empty();                             
                                   $("#list_revi_docu2").html(valor);
                              }
                              else if(tipo==3){
                                 $("#list_revi_docu3").empty();
                             
                                   $("#list_revi_docu3").html(valor);

                              }
                              else if(tipo==4){
                                 $("#list_revi_docu4").empty();
                              
                                   $("#list_revi_docu4").html(valor);

                              }
                              else if(tipo==5){
                                 $("#list_revi_docu5").empty();
                            
                                   $("#list_revi_docu5").html(valor);

                              }
                              else if(tipo==6){
                                 $("#list_revi_docu6").empty();
                              
                                   $("#list_revi_docu6").html(valor);

                              }
                               else if(tipo==7){
                                 $("#list_revi_docu7").empty();
                              
                                   $("#list_revi_docu7").html(valor);

                              }
                               else if(tipo==8){
                                 $("#list_revi_docu8").empty();
                              
                                   $("#list_revi_docu8").html(valor);

                              }
                              else if(tipo==9){
                                 $("#list_revi_docu9").empty();
                              
                                   $("#list_revi_docu9").html(valor);

                              }
                              else if(tipo==10){
                                 $("#list_revi_docu10").empty();
                              
                                   $("#list_revi_docu10").html(valor);

                              }
                              else if(tipo==11){
                                 $("#list_revi_docu11").empty();
                              
                                   $("#list_revi_docu11").html(valor);

                              }
                           
                        }
                  }); 


                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });
			}

    }
    else
      alert("Por favor selecione un estado de la actividad. ");


});
var id_serv_cliente="<?php echo "$_GET[id_elab_diag]" ?>";
var tipo="<?php echo "$_GET[tipo]" ?>";
var etapa="<?php echo $etapa ?>";

var datos='id_elab_diag='+id_serv_cliente+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&revi_serv_diag='+1+'&fecha_actividad='+fecha_actividad+'&tipo='+tipo+'&etapa='+etapa;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();

                              //    alert("Se ha agregado su observación al cliente");   
                                  $("#history_revi").html(valor);
                                 

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });
                  

});

    </script>