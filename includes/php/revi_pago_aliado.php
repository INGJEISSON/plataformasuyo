 <?php
include('../dependencia/conexion.php');
      if(isset($_GET['id_fasfield'])){ // Buscamos las encuestas

      $sql="select  enc_procesadas.cod_enc_proc, enc_procesadas.asesor, enc_procesadas.cliente, enc_procesadas.fecha_recepcion, enc_procesadas.fecha_revision, enc_procesadas.archivos, estado.descripcion as estado, enc_procesadas.id_fasfield, enc_procesadas.ciudad, enc_procesadas.arch_pdf, tipo_encuesta.nombre as tipo_encuesta from enc_procesadas, estado, tipo_encuesta where enc_procesadas.cod_estado=estado.cod_estado and enc_procesadas.tipo_encuesta=tipo_encuesta.tipo_encuesta  and enc_procesadas.id_fasfield='".$_GET['id_fasfield']."' ";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);
          $datos=pg_fetch_assoc($query);
        $archivo_pdf=$datos['arch_pdf'];    
    
      
        }
?>

 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Observaciones de pagos de aliados Cliente:  <?php echo $datos['cliente'];  ?> - Ciudad: <?php echo $datos['ciudad'];  ?> </h3>
                    </div>
                    <div class="card-body">

                           <table width="600" border="0" id="pan_add_revision" class="table responsive" cellpadding="1" cellspacing="4">
                           <tr>
                             <td width="189"><strong>Estado Actual:</strong></td>
                             <td width="26">&nbsp;</td>
                             <td width="227"><strong>Valor</strong></td>
                             <td width="11">&nbsp;</td>
                             <td width="113"><strong>Acción</strong></td>
                           </tr>
                           <tr>
                             <td height="46"><select name="select" id="cod_estado" class="form-control">
                               <option value="1" selected="selected">Sin revisar</option>
                               <option value="6">Aprobado</option>
                               <option value="7">No Aprobado</option>
                             </select></td>
                             <td><label for="textfield"></label></td>
                             <td><input type="number" class="form-control" name="textfield2" id="valor"></td>
                             <td>&nbsp;</td>
                             <td><input type="button" class="btn btn-primary" name="button" id="g_revision" value="Registrar"></td>
                           </tr>
                         </table>
                           <table width="155" border="0" align="center" cellpadding="0" cellspacing="0">
                             <tr align="center">
                               <td width="106"><strong>Agregar revisión</strong></td>
                             </tr>
                             <tr align="center">
                               <td><img src="img/if_Plus_206460.png" id="add_revision" style="cursor:pointer" title="Agregar revisión" width="38" height="38"></td>
                             </tr>
                           </table>
                        
                      <p>
                      <div id='cargar2' align="center"> 
                        <img src="../../img/loading_azul.gif" id="cargar2">
                            
                      </div>
                          <div id='resul_seguimiento' align="center"> 
                          
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
var valor=$("#valor").val();
var id_fasfield="<?php echo "$_GET[id_fasfield]" ?>";
var datos='id_fasfield='+id_fasfield+'&cod_estado='+cod_estado+'&observacion='+valor+'&add_revi_call='+1+'&tipo_seguimiento='+5;
    
    if(cod_estado!=1){

            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'includes/php/g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();
                                  alert("Se ha agregado su a la factura");   
								  $("#resul_seguimiento").html(valor);                            

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


var id_fasfield="<?php echo "$_GET[id_fasfield]" ?>";
var datos='id_fasfield='+id_fasfield+'&cod_estado='+cod_estado+'&valor='+valor+'&revi_revi_call='+1+'&tipo_seguimiento='+5;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'includes/php/g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();
                              //    alert("Se ha agregado su observación al cliente");   
                                  $("#resul_seguimiento").html(valor);

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });


});

    </script>