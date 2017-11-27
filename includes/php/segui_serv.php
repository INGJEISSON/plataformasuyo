<?php
include('../dependencia/conexion.php');
   
//decodificamo id_serv_cliente
$id_serv_cliente=base64_decode($_GET['id_serv_cliente']);


    // consultamos los datos del servicio
 $sql="select * from serv_cliente where id_serv_cliente='".$id_serv_cliente."' limit 0,1 ";
     $query=mysqli_query($conexion, $sql);
     $datos1=mysqli_fetch_assoc($query);
     
     // Busco el nombre del responsable..
     
     $sql10="select nombre from usuarios where cod_usuario='".$datos1['cod_usu_resp']."' ";
     $query10=mysqli_query($conexion, $sql10);
     $datos10=mysqli_fetch_assoc($query10);
     
    // Ultima actuación
    
    $sql11="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$id_serv_cliente."' order by activ_serv.id_activi_serv desc limit 0,1 ";
    $query11=mysqli_query($conexion, $sql11);
    @$datos11=mysqli_fetch_assoc($query11);
        
        
            
//echo "folio: ".$datos1['n_folio_inm'];
                                        
                  //  $parametro='AgendaCallCenter';   // Si son llamadas s贸lo para call center.              
$sql9="select * from cliente where cod_cliente='".$datos1['cod_cliente']."' ";
                    $query9=mysqli_query($conexion, $sql9);
                    $datos9=mysqli_fetch_assoc($query9);


    // Consulto la lista de poderes  y autorización necesario

            $sql2="select * from deta_list_despleg where tipo_lista=2";
            $query2=mysqli_query($conexion, $sql2);
            
            $sql21="select * from deta_list_despleg where tipo_lista=2 and id_list_despleg='".$datos1['poder_aut_nece']."' ";
            $query21=mysqli_query($conexion, $sql21);
            @$datos21=mysqli_fetch_assoc($query21);
            

     // Consulto la lista de tiene poder y autorización.

            $sql3="select * from deta_list_despleg where tipo_lista=3";
            $query3=mysqli_query($conexion, $sql3);
            
            $sql31="select * from deta_list_despleg where tipo_lista=3 and id_list_despleg='".$datos1['poder_aut']."' ";
            $query31=mysqli_query($conexion, $sql31);
            @$datos31=mysqli_fetch_assoc($query31);

     // Consulto la lista de tiene contrato.
            $sql4="select * from deta_list_despleg where tipo_lista=1";
            $query4=mysqli_query($conexion, $sql4);
            
             $sql41="select * from deta_list_despleg where tipo_lista=1 and id_list_despleg='".$datos1['firm_contrato']."' ";
            $query41=mysqli_query($conexion, $sql41);
            @$datos41=mysqli_fetch_assoc($query41);

     // Consulto la lista de estado de seguimiento (servicio).
            $sql5="select * from deta_list_despleg where tipo_lista=4";
            $query5=mysqli_query($conexion, $sql5);
            
            $sql51="select * from deta_list_despleg where tipo_lista=4 and id_list_despleg='".$datos1['cod_estado_segui']."' ";
            $query51=mysqli_query($conexion, $sql51);
            @$datos51=mysqli_fetch_assoc($query51);


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
                   var cod_cliente=<?php echo $datos1['cod_cliente'] ?>; 
                    var ciudad=$('#ciudad').val();
                    var barrio=$('#barrio').val();
                    var direccion=$('#direccion').val();
                    var n_folio_inm=$('#n_folio_inm').val();
                    var refe_catas=$('#refe_catas').val();
                    var orig_serv=$('#orig_serv').val();
                    var cod_servicio=$('#cod_servicio').val();
                    var proc_v_serv=$('#proc_v_serv').val();
                    var firm_contrato=$('#firm_contrato').val();
                    var fecha_firm_contr=$('#fecha_firm_contr').val();
                    var tiempo_compros=$('#tiempo_compros').val();
                    var fecha_compro_contr=$('#fecha_compro_contr').val();                  
                    var poder_aut_nec=$('#poder_aut_nec').val();
                    var poder_aut=$('#poder_aut').val();
                    var fecha_ini_tramite=$('#fecha_ini_tramite').val();
                    var enti_tramite=$('#enti_tramite').val();
                    var radicado=$('#radicado').val();
                    var cod_estado_segui=$('#cod_estado_segui').val();
                    var resu_serv=$('#resu_serv').val();
                    var coment_serv=$('#coment_serv').val();
                    var cod_estado_venc=$('#cod_estado_venc').val();

                    if(barrio!="" && ciudad!="" && direccion!="" && refe_catas!="" && orig_serv!="" && firm_contrato!="" && fecha_firm_contr!="" && tiempo_compros!="" && fecha_compro_contr!=""  && poder_aut_nec!="" && poder_aut!=""   && cod_estado_segui!="" && resu_serv!="" && coment_serv!="" && cod_estado_venc){


                    var datos='g_serv='+1+'&ciudad='+ciudad+'&barrio='+barrio+'&direccion='+direccion+'&n_folio_inm='+n_folio_inm+'&refe_catas='+refe_catas+'&orig_serv='+orig_serv+'&firm_contrato='+firm_contrato+'&fecha_firm_contr='+fecha_firm_contr+'&tiempo_compros='+tiempo_compros+'&fecha_compro_contr='+fecha_compro_contr+'&poder_aut_nec='+poder_aut_nec+'&poder_aut='+poder_aut+'&fecha_ini_tramite='+fecha_ini_tramite+'&enti_tramite='+enti_tramite+'&radicado='+radicado+'&cod_estado_segui='+cod_estado_segui+'&resu_serv='+resu_serv+'&coment_serv='+coment_serv+'&id_serv_cliente='+id_serv_cliente+'&cod_estado_venc='+cod_estado_venc+'&cod_cliente='+cod_cliente;


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
                    alert("Por favor complete los campos con asterístcos (*), son obligatorios");

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

var id_fasfield="<?php echo $datos1['cod_cliente'] ?>";
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
                  });
          
  });
</script>

 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    
                    <div class="card-header d-flex align-items-center" style="background-color:#CCC; border-radius:20">
                      <h3 class="h4"> Seguimiento del servicio: <?php echo base64_decode($_GET['nom_servicio']) ?></h3>
                      <table width="467" border="0">
                        <tr>
                          <td width="181">Cliente:</td>
                          <td width="276"><?php echo utf8_encode($datos9['nombre']) ?></td>
                        </tr>
                        <tr>
                          <td>Responsable:</td>
                          <td><?php echo $datos10['nombre'] ?></td>
                        </tr>
                        <tr>
                          <td>Fecha y hora de asignación:</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>Estado</td>
                          <td>&nbsp;</td>
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
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
       Ubicación del predio</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body"><table width="70%" border="0" class="table responsive">
      <tr>
        <td width="108">(*)Barrio</td>
        <td width="1073"><input name="barrio" type="text" class="form-control" id="barrio" value="<?php echo utf8_encode($datos9['barrio']) ?>"></td>
      </tr>
      <tr>
        <td>(*)Dirección</td>
        <td><input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $datos9['direccion_predio'] ?>"></td>
      </tr>
    </table></div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        Datos del predio</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body"> <table width="456" border="0" class="table responsive">
      <tr>
        <td width="198"><b></b> Número folio matricula</td>
        <td width="118"><input type="text" name="n_folio_inm" id="n_folio_inm" class="form-control" value="<?php echo $datos1['n_folio_inm'] ?>"></td>
      </tr>
      <tr>
        <td><b>(*)</b> Número referencia catastral</td>
        <td><input type="text" name="refe_catas" id="refe_catas" class="form-control" value="<?php echo $datos1['refe_catas'] ?>"></td>
      </tr>
    </table></div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
        Información contractual</a>
      </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body"><table width="456" border="0" class="table responsive">
      <tr>
        <td width="403"><b>(*)</b>Tiene contrato</td>
        <td width="778"><select name="firm_contrato" id="firm_contrato">
        <?php

                while($datos=mysqli_fetch_assoc($query4)){

        ?>
           <option value="<?= $datos['id_list_despleg'] ?>"<?php if($datos['id_list_despleg']==$datos41['id_list_despleg']){ ?> selected='selected' <?php } ?>><?php echo utf8_decode($datos['descripcion'])?></option>
     <?php

               }

        ?>
        </select>
      </td>
      </tr>
      
       <tr>
        <td><b>(*)</b>Tiempo de compromiso en días</td>
        <td><input type="number"  id="tiempo_compros" class="form-control" value="<?php echo $datos1['tiempo_compros'] ?>"></td>
      </tr>
      <tr>
        <td><b>(*)</b>Fecha firma de contrato</td>
        <td><input type="text" name="fecha_firm_contr" id="fecha_firm_contr" class="form-control" value="<?php echo $datos1['fecha_firm_contr'] ?>"></td>
      </tr>
      
        <tr>
        <td><b>(*)</b>Fecha de compromiso según el contrato</td>
        <td><input type="text" name="fecha_compro_contr" id="fecha_compro_contr" readonly='readonly' class="form-control" value="<?php echo $datos1['fecha_compro_contr'] ?>"></td>
      </tr>
      <tr>
        <td><b>(*)</b>Tiempo de vencimiento clientes con contrato</td>
        <td><input type="text" name="tiempo_venc" id="tiempo_venc" readonly='readonly' class="form-control" value="<?php echo $datos1['tiempo_venc'] ?>"></td>
      </tr>
      
      <tr>
        <td><b>(*)</b>Estado de vencimiento servicios con contrato completo</td>
        <td><input type="text" name="cod_estado_venc" id="cod_estado_venc" readonly='readonly' class="form-control" value="<?php echo $datos1['cod_estado_venc'] ?>"></td>
      </tr>
      

    </table></div>
    </div>
  </div>

<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
        Poderes y autorizaciones</a>
      </h4>
    </div>
    <div id="collapse4" class="panel-collapse collapse">
      <div class="panel-body"> <table width="65%" border="0" class="table responsive">
      <tr>
        <td width="253"><b>(*)</b>Poder y autorización necesario</td>
        <td width="928"><select name="poder_aut_nec" id="poder_aut_nec">

          <?php
                while($datos=mysqli_fetch_assoc($query2)){

        ?>
           <option value="<?= $datos['id_list_despleg'] ?>"<?php if($datos['id_list_despleg']==$datos21['id_list_despleg']){ ?> selected='selected' <?php } ?>><?php echo utf8_encode($datos['descripcion'])?></option>
     <?php

               }

        ?>
        </select>
       </td>
      </tr>
      <tr>
        <td><b>(*)</b>Tiene poder y autorización</td>
        <td><select name="poder_aut" id="poder_aut">
        <?php
                while($datos=mysqli_fetch_assoc($query3)){

        ?>
           <option value="<?= $datos['id_list_despleg'] ?>"<?php if($datos['id_list_despleg']==$datos31['id_list_despleg']){ ?> selected='selected' <?php } ?>><?php echo utf8_encode($datos['descripcion'])?></option>
     <?php

               }

        ?>
        </select></td>
      </tr>
    </table></div>
    </div>
  </div>


<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
       Trámite del servicio</a>
      </h4>
    </div>
    <div id="collapse5" class="panel-collapse collapse">
      <div class="panel-body"><table width="456" border="0" class="table responsive">
      <tr>
        <td width="198"><b></b>Fecha inicio del trámite</td>
        <td width="118"><input type="text" name="fecha_ini_tramite" id="fecha_ini_tramite" class="form-control" value="<?php echo $datos1['fecha_ini_tramite'] ?>"></td>
      </tr>
      <tr>
        <td><b></b>Entidad donde se tramita el servicio</td>
        <td><input type="textarea" name="enti_tramite" id="enti_tramite" class="form-control" value="<?php echo $datos1['enti_tramite'] ?>"></td>
      </tr>
      <tr>
        <td><b></b>Radicado</td>
        <td><input type="textarea" name="radicado" id="radicado" class="form-control" value="<?php echo $datos1['radicado'] ?>"></td>
      </tr>
    </table></div>
    </div>
  </div>

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
       Estado del servicio (Seguimiento)</a>
      </h4>
    </div>
    <div id="collapse6" class="panel-collapse collapse">
      <div class="panel-body">
      <table width="483" border="0" class="table responsive">
      <tr>
        <td width="321"><b>(*)</b>Estado del servicio</td>
        <td width="860"><select name="cod_estado_segui" id="cod_estado_segui"> 

                <?php
                while($datos=mysqli_fetch_assoc($query5)){

        ?>
             <option value="<?= $datos['id_list_despleg'] ?>"<?php if($datos['id_list_despleg']==$datos51['id_list_despleg']){ ?> selected='selected' <?php } ?>><?php echo utf8_encode($datos['descripcion'])?></option>
     <?php

               }

        ?>

               </select>
        </td>
      </tr>
      <tr>
        <td><b>(*)</b>Última actuación:   </td>
        <td><?php echo utf8_encode($datos11['etapa'].": ".$datos11['actividad']); ?></td>
      </tr>
      <tr>
        <td><b>(*)</b>Fecha de (Última actuación):</td>
        <td><?php echo utf8_encode($datos11['fecha_actividad']); ?> </td>
      </tr>
      
      <tr>
        <td><b>(*)</b>Resumen (estado para servicios externos):</td>
        <td><textarea name="resu_serv" id="resu_serv" class="form-control" ><?php echo utf8_encode($datos1['resu_serv']) ?></textarea></td>
      </tr>
      
      <tr>
        <td><b>(*)</b>Comentarios y Observaciones: </td>
        <td><textarea name="resu_serv" id="coment_serv" class="form-control" ><?php echo utf8_encode($datos1['coment_serv']) ?></textarea></td>
      </tr>
   </table></div>
    </div>
  </div>

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
      Política de comunicación (Última comunicación)</a>
      </h4>
    </div>
    <div id="collapse7" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi4' align="center">                           </div>
    <p><a href="../../includes/php/revi_call2.php?cod_cliente=<?php echo $datos1['cod_cliente'] ?>&id_serv_cliente=<?php echo $datos1['id_serv_cliente'] ?>" class='edicion'>Nueva comunicación</a></p></div>
    </div>
  </div>

   <div class="panel panel-primary">
    <div class="panel-heading ">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
      Actvidades (Última actividad)</a>
      </h4>
    </div>
    <div id="collapse8" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi3' align="center">
                           </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Nueva actividad</a></div>
    </div>
  </div>
  
 <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">
     Solicitud de Ajustes</a>
      </h4>
    </div>
    <div id="collapse9" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi5' align="center">                           </div>
    <p><a href="../../includes/php/solicitud.php?cod_cliente=<?php echo $datos1['cod_cliente'] ?>&id_serv_cliente=<?php echo $datos1['id_serv_cliente'] ?>" class='edicion'>Nueva Solicitud</a></p></div>
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