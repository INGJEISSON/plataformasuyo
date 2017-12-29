<?php
include('../dependencia/conexion.php');

      $sql="select  * from cliente where cod_cliente='".$_GET['cod_cliente']."' ";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);
          $datos=pg_fetch_assoc($query);        

// Verificamos que no esté en devolución.

          $s1="select * from devolucion where id_serv_cliente='".$_GET['id_serv_cliente']."' ";
          $q1=pg_query($conexion, $s1);
          $r1=pg_num_rows($q1);

          if($r1==1){
                  // Buscamos la etapa de la última actuación..
                $sql2="select max(activ_serv.cod_activi_etapa) as cod_activi_etapa from activ_serv, activi_etapa where activi_etapa.cod_activi_etapa=activ_serv.cod_activi_etapa and activ_serv.id_serv_cliente='".$_GET['id_serv_cliente']."' ";
                $query2=pg_query($conexion, $sql2);
                $rows2=pg_num_rows($query2);
                 $datos2=pg_fetch_assoc($query2);
                $etapa=12;   
                    if($datos2['cod_activi_etapa']==12){
                      //if()
                       
                              $sql5="select * from activi_etapa where cod_activi_etapa='".$datos2['cod_activi_etapa']."' ";
                              $query5=pg_query($conexion, $sql5);
                              $datos5=pg_fetch_assoc($query5);

                              $etapa=$datos5['cod_etapa']; // Obtengo la etapa del usuario..

                            // Consulto las actividades  necesarias de la etapa
                                 $sql3="select * from activ_etapa_devol where cod_etapa='".$etapa."'  ";
                                $query3=pg_query($conexion, $sql3);
                                $n_activi=pg_num_rows($query3); // Número de actividades a reallizar..
                                    
                                    $n_activi_hechas=0;
                                      
                                        if(isset($n_activi)){

                                              while($datos3=pg_fetch_assoc($query3)){

                                                            // Comparo con las actividades realizadas
                                                        $sql4="select * from activ_serv where cod_activi_etapa='".$datos3['cod_activi_etapa']."' and id_serv_cliente='".$_GET['id_serv_cliente']."' ";
                                                        $query4=pg_query($conexion, $sql4);
                                                         $rows4=pg_num_rows($query4); 

                                                              if($rows4>=1){                                                 
                                                                     $n_activi_hechas=$n_activi_hechas+1; 
                                                              }                                 
                                              }// Fin contancdo las activides realizadas por el usuario en la etapa del servicio..

                                               
                                        }
                        

                    }else{ // SI no hay etapa aaún realiazada entonces listo las actviades de la etapa.
                    
                      $sql3="select activ_etapa_devol.id_activi_devol as cod_activi_etapa, activ_etapa_devol.descripcion from activ_etapa_devol where cod_etapa='".$etapa."' ";
                        $query3=pg_query($conexion, $sql3); 
                        
                        $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                        $query4=pg_query($conexion, $sql4);
                        $datos4=pg_fetch_assoc($query4);    
                    }

          }else{


                // Buscamos la etapa de la última actuación..
                $sql2="select max(activ_serv.cod_activi_etapa) as cod_activi_etapa from activ_serv, activi_etapa where activi_etapa.cod_activi_etapa=activ_serv.cod_activi_etapa and activ_serv.id_serv_cliente='".$_GET['id_serv_cliente']."' ";
                $query2=pg_query($conexion, $sql2);
                $rows2=pg_num_rows($query2);
                 $datos2=pg_fetch_assoc($query2);
                $etapa=1;   
                    if($datos2['cod_activi_etapa']!=""){
                       
                              $sql5="select * from activi_etapa where cod_activi_etapa='".$datos2['cod_activi_etapa']."' ";
                              $query5=pg_query($conexion, $sql5);
                              $datos5=pg_fetch_assoc($query5);

                              $etapa=$datos5['cod_etapa']; // Obtengo la etapa del usuario..

                            // Consulto las actividades  necesarias de la etapa
                                 $sql3="select * from activi_etapa where cod_etapa='".$etapa."' and cod_servicio='".$_GET['cod_servicio']."'  ";
                                $query3=pg_query($conexion, $sql3);
                                $n_activi=pg_num_rows($query3); // Número de actividades a reallizar..
                                    
                                    $n_activi_hechas=0;
                                      
                                        if(isset($n_activi)){

                                              while($datos3=pg_fetch_assoc($query3)){

                                                            // Comparo con las actividades realizadas
                                                        $sql4="select * from activ_serv where cod_activi_etapa='".$datos3['cod_activi_etapa']."' and id_serv_cliente='".$_GET['id_serv_cliente']."' ";
                                                        $query4=pg_query($conexion, $sql4);
                                                         $rows4=pg_num_rows($query4); 

                                                              if($rows4>=1){                                                 
                                                                     $n_activi_hechas=$n_activi_hechas+1; 
                                                              }                                 
                                              }// Fin contancdo las activides realizadas por el usuario en la etapa del servicio..

                                              if($n_activi_hechas==$n_activi){
                                                   if($_GET['cod_servicio']==54){
                                                        if($etapa==2)
                                                          $etapa=6;
                                                        else
                                                           $etapa=$etapa+1; 
                                                   }

                                                // Avanza de etapa
                                                  $etapa=$etapa+1; 
                                              }                                       
                                              

                                               
                                        }

                                  if($etapa<=4){
                                        // Ubico al usuario en la etapa donde debe estar...

                                              $sql3="select * from activi_etapa where cod_etapa='".$etapa."' and cod_servicio='".$_GET['cod_servicio']."' ";
                                              $query3=pg_query($conexion, $sql3); 
                                              
                                              $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                                              $query4=pg_query($conexion, $sql4);
                                              $datos4=pg_fetch_assoc($query4);              
                                      } else

                                      $datos4['descripcion']='SIN ETAPA A REALIZAR';
                                  
                        

                    }else{ // SI no hay etapa aaún realiazada entonces listo las actviades de la etapa.
                    
                      $sql3="select * from activi_etapa where cod_etapa='".$etapa."' and cod_servicio='".$_GET['cod_servicio']."' ";
                        $query3=pg_query($conexion, $sql3); 
                        
                        $sql4="select * from etapa_activ where cod_etapa='".$etapa."' ";
                        $query4=pg_query($conexion, $sql4);
                        $datos4=pg_fetch_assoc($query4);    
                    }

          }




	
?>

 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Actividades del servicio:  <?php echo ($datos['nombre']);  ?> </h3>
                      <p><strong>ETAPA ACTUAL:</strong> <?php echo strtoupper(($datos4['descripcion']));  ?> </p>
                    </div>
                    <div class="card-body">
                         <table width="870" border="0" id="pan_add_revision" class="table responsive" cellpadding="1" cellspacing="4">
                           <tr>
                             <td width="189"><strong>Actividad</strong></td>
                             <td width="26">&nbsp;</td>
                             <td width="227"><strong>Observación:</strong></td>
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
                             <td><input type="text" class="form-control" name="textfield2" id="observacion"></td>
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




$("#g_revision").click(function(){  // Abregamos revisión .....

var cod_activi_etapa=$("#cod_activi_etapa").val();
var observacion=$("#observacion").val();
var fecha_actividad=$("#fecha_actividad").val();
var id_serv_cliente="<?php echo "$_GET[id_serv_cliente]" ?>";
var datos='id_serv_cliente='+id_serv_cliente+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&add_revi_serv='+1+'&fecha_actividad='+fecha_actividad;
    
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
                                  
                                   var datos='id_serv_cliente='+id_serv_cliente+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&revi_serv2='+1+'&fecha_actividad='+fecha_actividad;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();

                              //    alert("Se ha agregado su observación al cliente");   
                                  $("#history_revi3").html(valor);
                                 

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

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

var id_serv_cliente="<?php echo "$_GET[id_serv_cliente]" ?>";
var datos='id_serv_cliente='+id_serv_cliente+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&revi_serv='+1+'&fecha_actividad='+fecha_actividad;
    
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
                  
                  var datos='id_serv_cliente='+id_serv_cliente+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&revi_serv2='+1+'&fecha_actividad='+fecha_actividad;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();

                              //    alert("Se ha agregado su observación al cliente");   
                                  $("#history_revi3").html(valor);
                                 

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });



});

    </script>