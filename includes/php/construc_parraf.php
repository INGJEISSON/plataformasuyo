<?php
include('../dependencia/conexion.php');

      $sql="select  * from cliente where cod_cliente='".$_GET['cod_cliente']."' ";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);
          $datos=pg_fetch_assoc($query);        


// Listamos las fichas de párrafos


       $sql3="select  cod_parrafo as cod_activi_etapa, descripcion from parrafos";
        $query3=pg_query($conexion, $sql3); 




	
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
                      <h3 class="h4">CONSTRUCCIÓN DE PÁRRAFO:  <?php echo ($datos['nombre']);  ?> </h3>      
                      
                    </div>

                      <table width="155" border="0" align="center" cellpadding="0" cellspacing="0">
                                   <tr align="center">
                                     <td width="106"><strong>Agregar/Editar Parrafo</strong></td>
                                   </tr>
                                   <tr align="center">
                                     <td><img src="../../img/if_Plus_206460.png" id="add_revision" style="cursor:pointer" title="Agregar/Editar Párrafo" width="38" height="38"></td>
                                   </tr>
                                 </table>


                    <div class="card-body">
                         <table width="870" border="0" id="pan_add_revision" class="table responsive" cellpadding="1" cellspacing="4">
                           <tr>
                             <td width="189"><strong>Titulo</strong></td>
                             <td width="26">&nbsp;</td>
                             <td width="227"><strong>Párrafo:</strong></td>
                             <td width="11">&nbsp;</td>
                           
                             <td width="113"><strong>Acción</strong></td>
                           </tr>
                           <tr>
                             <td height="46"><select name="select" id="cod_activi_etapa" class="form-control">
                               <option value="1" selected="selected">Seleccione</option>
                              <?php while($datos2=pg_fetch_assoc($query3)){ ?>
                               
                               <option value="<?= $datos2['cod_activi_etapa'] ?>"> <?php echo ($datos2['descripcion'])?></option>
                               <?php } ?>
                             </select></td>
                             <td><label for="textfield"></label></td>
                             <td><select name="select" id="observacion" class="form-control">  
                             <option value="2">Ninguno</option>
                             </select>
                             </td>
                             <td>&nbsp;</td>
                             <td><input type="button" class="btn btn-primary" name="button" id="g_revision_parraf" value="Registrar/Editar"></td>
                           </tr>
                         </table>

                          <div  align="justify" id="pan_add_campos" style="font-weight: bold">Nota: Sólo podrás agregar seleccionar campos donde hayas registrado información 
                                  <table width="870" border="0"  class="table responsive" cellpadding="1" cellspacing="4">
                                   <tr>
                                     <td width="189"><strong>Ficha</strong></td>
                                     <td width="26">&nbsp;</td>
                                     <td width="227"><strong>Actividad:</strong></td>
                                     <td width="11">&nbsp;</td>
                                   
                                     <td width="113"><strong>Agregar</strong></td>
                                   </tr>
                                   <tr>
                                     <td height="46"><select name="select" id="b_ficha" class="form-control">
                                       <option value="0" selected="selected">Seleccione</option>
                                      <?php // while($datos2=pg_fetch_assoc($query3)){ ?>
                                       
                                       <option value=1>Revisión de los documentos del cliente y de la encuesta</option>
                                       <option value=2>Identificar cadena de tradiciones</option>
                                       <option value=3>Revisión páginas de mapas</option>
                                       <option value=4>Revisión páginas impuestos</option>
                                       <option value=5>Revisión bases de datos</option>
                                       <option value=6>Revisión de mapas colaborativos</option>
                                       <option value=7>Analisis de FMI</option>
                                       <option value=8>Analisis de la titularidad</option>
                                       <option value=9>Analisis de la situación actual del impuesto predial </option>
                                       <option value=10>Análisis situación actual servicios públicos</option>
                                       <option value=11>Otras situaciones (Legal)</option>
                                       <?php // } ?>
                                     </select></td>
                                     <td><label for="textfield"></label></td>
                                     <td><select name="select" id="actividad" class="form-control">  
                                     <option value="2">Ninguno</option>
                                     </select>
                                     </td>
                                     <td>&nbsp;</td>
                                     <td><input type="button" class="btn btn-primary" name="button" id="g_add_campo_parr" value="Agregar"></td>
                                   </tr>
                                 </table>

                           </div>
                            <hr>&nbsp;</hr>
                               <table width="155" border="0" cellpadding="0" cellspacing="0" id='editparrafo'>
                                 <tr align="center">
                                   <td width="106"><strong>Edición de Párrafo</strong></td>
                                 </tr>
                                 <tr align="center">
                                   <td><textarea id="edit_parrafo" class="form-control" style=" width: 800px; height: 400px"></textarea><br><input type="button" class="btn btn-primary" name="button" id="actuali_parraf" value="Actualizar"></td>
                                 </tr>
                               </table>
                           
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

  var id_elab_diag="<?php echo "$_GET[id_elab_diag]" ?>";
$("#cargar2").hide();
$("#archrev").hide();
$("#archrev2").hide();
$("#pan_add_revision").hide();
$("#pan_add_campos").hide();

$("#observacion").hide();
$("#observacion2").hide();
$("#editparrafo").hide();

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
  var b_lista_parraf=1;
$("#pan_add_campos").hide();
$("#editparrafo").hide();
    var datos='b_lista_parraf='+b_lista_parraf+'&cod_activi_etapa='+cod_activi_etapa;
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

$("#b_ficha").change(function(){
  var b_ficha=$("#b_ficha").val();
  var cod_equipo=2;
    var datos='b_ficha='+b_ficha+'&cod_equipo='+cod_equipo+'&id_elab_diag='+id_elab_diag;
            $.ajax({
                  type: "POST",
                  data: datos,
                  url: 'g_procesos.php?'+datos,
                  success: function (valor){

                        if(valor=='<option value=2>Ninguno</option>'){                          
                           $("#actividad").empty();
                          $("#actividad").html(valor);
                          $("#actividad").show();  
                        }else{
                          $("#actividad").empty();
                          $("#actividad").html(valor);
                          $("#actividad").show();                         

                        }
                  }

            });

});

    $("#g_revision_parraf").click(function(){  // Abregamos revisión .....

    var cod_activi_etapa=$("#cod_activi_etapa").val();
    var observacion=$("#observacion").val();    

        
          var datos='id_elab_diag='+id_elab_diag+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&add_parrafo_diag='+1+'&g_revision_parraf='+1;
        
        if(cod_activi_etapa!=0){
                $("#cargar2").show();
                  $.ajax({

                            type: "POST",
                            data: datos,
                            url: 'g_procesos.php?'+datos,
                            success: function(valor){                               
                                   if(valor!=2){
                                    $("#cargar2").hide();
                                   
                                    $("#edit_parrafo").empty();
                                    $("#edit_parrafo").val(valor); // Mostramos párrafo .. 
                                    $("#editparrafo").show();
                                    $("#editparrafo").focus();
                                    $("#pan_add_campos").show();  

                                   }else if(valor==3){
                                          $("#cargar2").hide();
                                    alert("Ocurrió un error al crear el párrafo, por favor intenta de nuevo o comuníquese con el administrador.");

                                   }


                            }
                      });

        }
        else
          alert("Por favor selecione un título de párrafo.");

    });


    // Agregar información al parráfo

         $("#g_add_campo_parr").click(function(){

          var actividad=$("#actividad").val();
          var edit_parrafo=$("#edit_parrafo").val();
          var datos='g_revision_parraf='+1+'&g_add_campo_parr='+1+'&actividad='+actividad+'&id_elab_diag='+id_elab_diag+'&edit_parrafo='+edit_parrafo;

                    if(actividad!=""){

                            $.ajax({
                                    type: "POST",
                                    data: datos,
                                    url: 'g_procesos.php?'+datos,
                                    success: function(valor2){
                                     // alert("Jei");
                                              
                                   //$("#edit_parrafo").empty();                                 
                                   $("#edit_parrafo").val(valor2); // Mostramos párrafo .. 
                                    /* $("#editparrafo").show();
                                     $("#editparrafo").focus();
                                    $("#pan_add_campos").show();*/


                                    }

                              });
                    }else
                      alert("No se encontró ninguna actividad en la ficha seleccionada");
              




         });

            // Actualizamos párrafo..

          $("#actuali_parraf").click(function(){

          var observacion=$("#observacion").val();   // Párrafo seleccionado..         
          var edit_parrafo=$("#edit_parrafo").val();
          var cod_activi_etapa=$("#cod_activi_etapa").val(); // Titulo del párrafo..
          var datos='g_revision_parraf='+1+'&actuali_parraf='+1+'&id_elab_diag='+id_elab_diag+'&edit_parrafo='+edit_parrafo+'&observacion='+observacion+'&cod_parrafo='+cod_activi_etapa;

                    if(actividad!=""){
                            $.ajax({
                                    type: "POST",
                                    data: datos,
                                    url: 'g_procesos.php?'+datos,
                                    success: function(valor4){

                                        if(valor4==1){
                                          alert("Párrafo construido y actualizado correctamente");

                                            var datos5='listar_actividades_diag='+1+'&tipo='+12+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;    
                                              $("#cargar2").show();
                                                $.ajax({

                                                          type: "POST",
                                                          data: datos5,
                                                          url: 'g_procesos.php?',
                                                          success: function(valor5){
                                                              $("#list_revi_docu12").empty();
                                                                  $("#cargar2").hide();
                                                                     $("#list_revi_docu12").html(valor5);
                                                          }
                                                    });
                                        }
                                        else
                                          alert("Ocurrió un error técnico, por favor comuníquese con el administrador");
                                    }

                              });
                    }else
                      alert("No se encontró ninguna actividad en la ficha seleccionada");


         });

});

    </script>