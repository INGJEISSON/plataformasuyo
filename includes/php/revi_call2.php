 <?php
include('../dependencia/conexion.php');
      
    if(isset($_GET['cod_cliente'])){ // Buscamos las encuestas

      $sql="select * from cliente where cod_cliente='".$_GET['cod_cliente']."' ";
      $query=mysqli_query($conexion, $sql);
          $rows=mysqli_num_rows($query);
          $datos=mysqli_fetch_assoc($query);
    
        }
?>



 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Observaciones de comunicación  <?php echo utf8_encode($datos['nombre']);  ?> </h3>
                    </div>
                    <div class="card-body">

                         <p>
                           <?php
                         // Buscamos los archivos....


      if(isset($_GET['id_fasfield'])){ // Buscamos los archivos de la encuesta..

               
        }
?>
                         </p>
                         <table width="870" border="0" id="pan_add_revision" class="table responsive" cellpadding="1" cellspacing="4">
                           <tr>
                             <td width="189"><strong>Estado Actual:</strong></td>
                             <td width="26">&nbsp;</td>
                             <td width="227"><strong>Observación:</strong></td>
                             <td width="11">&nbsp;</td>
                             <td width="242" id="archrev"><strong>Fecha de Agenda</strong></td>
                             <td width="16" >&nbsp;</td>
                             <td width="113"><strong>Acción</strong></td>
                           </tr>
                           <tr>
                             <td height="46"><select name="select" id="cod_estado" class="form-control">
                               <option value="1" selected="selected">Sin revisar</option>
                               <option value="12">AgendaCallCenter</option>
                               <option value="14">Agendada</option>
                               <option value="15">No contesta</option>
                               <option value="16">Numero errado</option>
                               <option value="17">LLamar de nuevo</option>
                               <option value="18">No interesado</option>
                               <option value="27">Comunicación efectiva</option>
                               <option value="28">Nuevo Número/Cambio de Número</option>
                             </select></td>
                             <td><label for="textfield"></label></td>
                             <td><input type="text" class="form-control" name="textfield2" id="observacion"></td>
                             <td>&nbsp;</td>
                             <td id="archrev2"><input type="text" class="form-control" name="textfield2" id="fecha_1"></td>
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
                            <img src="img/loading_azul.gif" id="cargar2">
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

var cod_estado=$("#cod_estado").val();
var observacion=$("#observacion").val();
var id_fasfield="<?php echo "$_GET[id_serv_cliente]" ?>";
var datos='id_fasfield='+id_fasfield+'&cod_estado='+cod_estado+'&observacion='+observacion+'&add_revi_call='+1+'&tipo_seguimiento='+6;
    
    if(cod_estado!=1){

            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();
                                  alert("Se ha agregado su observación al cliente");   
                                  $("#history_revi").html(valor);
                                  
                                  var datos='id_fasfield='+id_fasfield+'&cod_estado='+cod_estado+'&observacion='+observacion+'&revi_revi_call2='+1+'&tipo_seguimiento='+6;
    
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
                  });


                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });

    }
    else
      alert("Por favor selecione un estado a la comunicación ");


});

var id_fasfield="<?php echo "$_GET[id_serv_cliente]" ?>";
var datos='id_fasfield='+id_fasfield+'&cod_estado='+cod_estado+'&observacion='+observacion+'&revi_revi_call='+1+'&tipo_seguimiento='+6;
    
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
                  
            var datos='id_fasfield='+id_fasfield+'&cod_estado='+cod_estado+'&observacion='+observacion+'&revi_revi_call2='+1+'&tipo_seguimiento='+6;
    
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
                  });



});

    </script>