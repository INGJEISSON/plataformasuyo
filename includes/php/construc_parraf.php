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

                                <input type=text class="form-control" name="textfield2" id="observacion2">
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
                                     <td><input type="button" class="btn btn-primary" name="button" id="g_add_campo_parr" value="Agregar"></td>
                                   </tr>
                                 </table>

                           </div>
                            <hr>&nbsp;</hr>
                               <table width="155" border="0" cellpadding="0" cellspacing="0" id='editparrafo'>
                                 <tr align="center">
                                   <td width="106"><strong>Edición  de Párrafo</strong></td>
                                 </tr>
                                 <tr align="center">
                                   <td><textarea id="edit_parrafo" class="form-control" style=" width: 500px; height: 200px"></textarea><br><input type="button" class="btn btn-primary" name="button" id="g_revision_parraf" value="Actualizar"></td>
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
$("#pan_add_campos").show();

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




$("#g_revision").click(function(){  // Abregamos revisión .....

var cod_activi_etapa=$("#cod_activi_etapa").val();
var observacion=$("#observacion").val();
  if(observacion==2)
  var observacion=$("#observacion2").val();

var id_serv_cliente="<?php echo "$_GET[id_elab_diag]" ?>";
var tipo="<?php echo "$_GET[tipo]" ?>";
var datos='id_elab_diag='+id_serv_cliente+'&cod_activi_etapa='+cod_activi_etapa+'&observacion='+observacion+'&add_parrafo_diag='+1+'&tipo='+tipo+'&g_revision_parraf='+1;
    
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

                             /*  var id_elab_diag="<?php echo "$_GET[id_elab_diag]" ?>";
                              var datos='listar_actividades_diag='+1+'&tipo='+tipo+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;    
                                        
                                               $.ajax({

                                                      type: "POST",
                                                      data: datos,
                                                      url: 'g_procesos.php?'+datos,
                                                      success: function(valor){
                                                                               
                                                      }
                                                 }); */

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


});

    </script>