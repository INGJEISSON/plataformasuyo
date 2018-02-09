<?php
include('../dependencia/conexion.php');
   
//decodificamo id_serv_cliente
$id_elab_diag=base64_decode($_GET['id_elab_diag']);


    // consultamos los datos del servicio
     $sql="select * from diagno_client where id_elab_diag='".$id_elab_diag."' limit 1 ";
     $query=pg_query($conexion, $sql);
     $d=pg_fetch_assoc($query);

// Consultamos del servicio
     $sql2="select * from cliente where cod_cliente='".$d['cod_cliente']."' ";
     $query2=pg_query($conexion, $sql2);
     $datos2=pg_fetch_assoc($query2);

     $f="select * from usuarios where cod_usuario='".$d['cod_usu_legal']."' ";
     $g=pg_query($conexion, $f);
     $d2=pg_fetch_assoc($g);

       $f3="select * from usuarios where cod_usuario='".$d['cod_usu_tecnico']."' ";
     $g3=pg_query($conexion, $f3);
     $d3=pg_fetch_assoc($g3);

     // Buscamos la fecha de la asignación

      $sql4="select fecha_filtro from asigna_diag where id_elab_diag='".$id_elab_diag."' order by id_elab_diag desc limit 1  ";
                                  $query4=pg_query($conexion, $sql4);
                                  $rows4=pg_num_rows($query4);
                                      if($rows4){
                                        $datos4=pg_fetch_assoc($query4);    
                                        $fecha_filtro= $datos4['fecha_filtro'];                                   
                                      }else
                                      $fecha_filtro="";
     


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

var id_fasfield="<?php echo $id_elab_diag ?>";
var tipo_seguimiento=8;
var datos='id_fasfield='+id_fasfield+'&revi_revi_call='+1+'&tipo_seguimiento='+tipo_seguimiento;    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: '../../includes/php/g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();
                              //    alert("Se ha agregado su observación al cliente");                                 
                                   $("#history_afect").html(valor);      

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });
var id_fasfield="<?php echo $id_elab_diag ?>";
var tipo_seguimiento=14;
var datos='id_fasfield='+id_fasfield+'&revi_revi_call='+1+'&tipo_seguimiento='+tipo_seguimiento;    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: '../../includes/php/g_procesos.php?'+datos,
                        success: function(valor){
                           
                               if(valor!=2){
                                $("#cargar2").hide();
                              //    alert("Se ha agregado su observación al cliente");                                 
                                   $("#history_serv_recom").html(valor);  

                          // Listamos servicios cotizados
                              var id_elab_diag="<?php echo $id_elab_diag ?>";
                              var datos='id_elab_diag='+id_elab_diag+'&list_servicios='+1;
                                  
                                          $("#cargar2").show();
                                            $.ajax({

                                                      type: "POST",
                                                      data: datos,
                                                      url: 'g_procesos.php?'+datos,
                                                      success: function(valor){
                                                          $("#history_serv_recom2").empty();
                                                              $("#cargar2").hide();
                                                            //    alert("Se ha agregado su observación al cliente");   
                                                                $("#history_cotizacion").html(valor);

                                                             


                                                      }
                                                });     

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }
                        }
                  });

var id_fasfield="<?php echo $id_elab_diag ?>";
var tipo_seguimiento=15;
var datos='id_fasfield='+id_fasfield+'&revi_revi_call='+1+'&tipo_seguimiento='+tipo_seguimiento;    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: '../../includes/php/g_procesos.php?'+datos,
                        success: function(valor){
                            
                               if(valor!=2){


                                $("#cargar2").hide();
                              //    alert("Se ha agregado su observación al cliente");                                 
                                   $("#history_serv_recom2").html(valor);      

                               }else{
                                      $("#cargar2").hide();
                                alert("Ocurrió un error al crear el registro de la observación, por favor intenta de nuevo o comuníquese con el administrador.");

                               }


                        }
                  });
        

var id_fasfield="<?php echo $id_elab_diag ?>";
var datos='id_fasfield='+id_fasfield+'&revi_revi_call2='+1+'&tipo_seguimiento='+18;
    
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

// Listamos servicios cotizados
var id_elab_diag="<?php echo $id_elab_diag ?>";
var datos='id_elab_diag='+id_elab_diag+'&list_servicios='+1;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#history_serv_recom2").empty();
                                $("#cargar2").hide();
                              //    alert("Se ha agregado su observación al cliente");   
                                  $("#history_cotizacion").html(valor);

                               


                        }
                  }); 


    // Listamos las actividades de los documentos del cliente y lde la encuesta.
    var id_elab_diag="<?php echo $id_elab_diag ?>";
var datos='listar_actividades_diag='+1+'&tipo='+1+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu").html(valor);
                        }
                  }); 

        // Listamos las actividades de los documentos del cliente y lde la encuesta.
var datos='listar_actividades_diag='+1+'&tipo='+2+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu2").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu2").html(valor);
                        }
                  });
    
    // Listamos las actividades de los documentos del cliente y lde la encuesta.
var datos='listar_actividades_diag='+1+'&tipo='+3+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu3").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu3").html(valor);
                        }
                  });

      // Listamos las actividades de los documentos del cliente y lde la encuesta.
var datos='listar_actividades_diag='+1+'&tipo='+4+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu4").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu4").html(valor);
                        }
                  });

            // Listamos las actividades de los documentos del cliente y lde la encuesta.
var datos='listar_actividades_diag='+1+'&tipo='+5+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu5").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu5").html(valor);
                        }
                  });

              // Listamos las actividades de los documentos del cliente y lde la encuesta.
var datos='listar_actividades_diag='+1+'&tipo='+6+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu6").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu6").html(valor);
                        }
                  });

    var datos='listar_actividades_diag='+1+'&tipo='+7+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu7").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu7").html(valor);
                        }
                  });

      var datos='listar_actividades_diag='+1+'&tipo='+8+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu8").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu8").html(valor);
                        }
                  });
         var datos='listar_actividades_diag='+1+'&tipo='+9+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu9").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu9").html(valor);
                        }
                  });

           var datos='listar_actividades_diag='+1+'&tipo='+10+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu10").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu10").html(valor);
                        }
                  });

             var datos='listar_actividades_diag='+1+'&tipo='+11+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu11").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu11").html(valor);
                        }
                  });

            var datos='listar_actividades_diag='+1+'&tipo='+12+'&cod_equipo='+2+'&id_elab_diag='+id_elab_diag;
    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: 'g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu12").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu12").html(valor);
                        }
                  });

          // Registramos datos del diagnóstico (Técnico y datos básicos)

 $("#grabar_proc").click(function(){
        
        var grupo_usuario=1;
        var ciudad= $('#ciudad').val();
        var fecha= $('#fecha').val();
        var direccion= $('#direccion').val();
        var id_usuario= $('#id_usuario').val();
        var dir_form_igac= $('#dir_form_igac').val();
        var barrio= $('#barrio').val();
        var municipio= $('#municipio').val();
        var f_nec_form= $('#f_nec_form').val();
        var f_nec_legal= $('#f_nec_legal').val();
        var f_ubic_coor= $('#f_ubic_coor').val();
        var f_cons_lic= $('#f_cons_lic').val();       
        var f_riesg_inun= $('#f_riesg_inun').val();
        var f_riesg_remo= $('#f_riesg_remo').val();
        var f_riesg_proct= $('#f_riesg_proct').val();
        var tipol_cant_constr= $('#tipol_cant_constr').val();
        var alt_cant_pisos= $('#alt_cant_pisos').val();
        var area_lote= $('#area_lote').val();
        var dim_frent_lote= $('#dim_frent_lote').val();
        var dim_frent_const= $('#dim_frent_const').val();
        var dist_lad_lot= $('#dist_lad_lot').val();
        var dist_lot_izq= $('#dist_lot_izq').val();
        var dist_lot_der= $('#dist_lot_der').val();
        var area_catastral= $('#area_catastral').val();
        var area_docu= $('#area_docu').val();
        var ara_docu_es_de= $('#ara_docu_es_de').val();
        var area_med_de= $('#area_med_de').val();
        var raz_cumpl= $('#raz_cumpl').val();
        var par_predio_client= $('#par_predio_client').val();
        var analis_client= $('#analis_client').val();
        var msg_info= $('#msg_info').val();
        var f_esp_legal= $('#f_esp_legal').val();
        var f_esp_tecn= $('#f_esp_tecn').val();
        var foto_graf_all_serv= $('#foto_graf_all_serv').val();
        var foto_graf_serv= $('#foto_graf_serv').val();
        var cond_serv= $('#cond_serv').val();
        var aport_client_legal= $('#aport_client_legal').val();
        var aport_client_tecni= $('#aport_client_tecni').val();
        var aport_legal= $('#aport_legal').val();
        var aport_tecni= $('#aport_tecni').val();
        var llamada_client= $('#llamada_client').val();
        var pagina_web= $('#pagina_web').val();
        var consult_ent= $('#consult_ent').val();
        var pot= $('#pot').val();
        var der_peticion= $('#der_peticion').val();
        var elab_legal= $('#elab_legal').val();
        var elab_tecnico= $('#elab_tecnico').val();
        var elab_analitic= $('#elab_analitic').val();
        var apr_legal= $('#apr_legal').val();
        var apro_tecnico= $('#apro_tecnico').val();
        var apr_analitic= $('#apr_analitic').val();
        var id_fasfield=id_elab_diag;
        var cod_estado_tec= $('#cod_estado_tec').val();
        var cod_estado_ana= $('#cod_estado_ana').val();
        var cod_estado_leg= $('#cod_estado_leg').val();
        var ubu_predio=$("#ubu_predio").val();
        var latitud=$("#latitud").val();
        var longitud=$("#longitud").val();
        var uso_suelo=$("#uso_suelo").val();
                

                if(latitud!="" && ubu_predio!="" && longitud!="" && uso_suelo!=""){

                         // Equipo analítico
                   /* if(grupo_usuario==3)
                        var datos='g_elab_diag='+1+'&fecha='+fecha+'&direccion='+direccion+'&cond_serv='+cond_serv+'&elab_analitic='+elab_analitic+'&apr_analitic='+apr_analitic+'&llamada_client='+llamada_client+'&pagina_web='+pagina_web+'&consult_ent='+consult_ent+'&pot='+pot+'&der_peticion='+der_peticion+'&id_fasfield='+id_fasfield+'&cod_estado_ana='+cod_estado_ana;

                // Equipo Legal
                 else  if(grupo_usuario==4)
                        var datos='g_elab_diag='+1+'&dir_form_igac='+dir_form_igac+'&barrio='+barrio+'&municipio='+municipio+'&f_nec_form='+f_nec_form+'&par_predio_client='+par_predio_client+'&analis_client='+analis_client+'&msg_info='+msg_info+'&f_esp_legal='+f_esp_legal+'&aport_client_legal='+aport_client_legal+'&elab_legal='+elab_legal+'&apr_legal='+apr_legal+'&llamada_client='+llamada_client+'&pagina_web='+pagina_web+'&consult_ent='+consult_ent+'&pot='+pot+'&der_peticion='+der_peticion+'&aport_legal='+aport_legal+'&id_fasfield='+id_fasfield+'&cod_estado_leg='+cod_estado_leg;

                 // Equipo técnico
                 else  if(grupo_usuario==5)
                        var datos='g_elab_diag='+1+'&f_nec_legal='+f_nec_legal+'&f_ubic_coor='+f_ubic_coor+'&f_cons_lic='+f_cons_lic+'&f_riesg_inun='+f_riesg_inun+'&f_riesg_remo='+f_riesg_remo+'&f_riesg_proct='+f_riesg_proct+'&tipol_cant_constr='+tipol_cant_constr+'&alt_cant_pisos='+alt_cant_pisos+'&dim_frent_lote='+dim_frent_lote+'&dim_frent_const='+dim_frent_const+'&dist_lad_lot='+dist_lad_lot+'&dist_lot_izq='+dist_lot_izq+'&dist_lot_der='+dist_lot_der+'&area_catastral='+area_catastral+'&area_docu='+area_docu+'&ara_docu_es_de='+ara_docu_es_de+'&area_med_de='+area_med_de+'&raz_cumpl='+raz_cumpl+'&f_esp_tecn='+f_esp_tecn+'&aport_client_tecni='+aport_client_tecni+'&aport_tecni='+aport_tecni+'&apro_tecnico='+apro_tecnico+'&area_lote='+area_lote+'&elab_tecnico='+elab_tecnico+'&id_fasfield='+id_fasfield+'&cod_estado_tec='+cod_estado_tec;
                    */
                    // Usuario super administrador..
                //  else  if(grupo_usuario==1)
                     var datos='g_elab_diag='+1+'&fecha='+fecha+'&direccion='+direccion+'&cond_serv='+cond_serv+'&elab_analitic='+elab_analitic+'&apr_analitic='+apr_analitic+'&llamada_client='+llamada_client+'&pagina_web='+pagina_web+'&consult_ent='+consult_ent+'&pot='+pot+'&der_peticion='+der_peticion+'&direccion='+direccion+'&dir_form_igac='+dir_form_igac+'&barrio='+barrio+'&municipio='+municipio+'&f_nec_form='+f_nec_form+'&par_predio_client='+par_predio_client+'&analis_client='+analis_client+'&msg_info='+msg_info+'&f_esp_legal='+f_esp_legal+'&aport_client_legal='+aport_client_legal+'&elab_legal='+elab_legal+'&apr_legal='+apr_legal+'&f_nec_legal='+f_nec_legal+'&f_ubic_coor='+f_ubic_coor+'&f_cons_lic='+f_cons_lic+'&f_riesg_inun='+f_riesg_inun+'&f_riesg_remo='+f_riesg_remo+'&f_riesg_proct='+f_riesg_proct+'&tipol_cant_constr='+tipol_cant_constr+'&alt_cant_pisos='+alt_cant_pisos+'&dim_frent_lote='+dim_frent_lote+'&dim_frent_const='+dim_frent_const+'&dist_lad_lot='+dist_lad_lot+'&dist_lot_izq='+dist_lot_izq+'&dist_lot_der='+dist_lot_der+'&area_catastral='+area_catastral+'&area_docu='+area_docu+'&ara_docu_es_de='+ara_docu_es_de+'&area_med_de='+area_med_de+'&raz_cumpl='+raz_cumpl+'&f_esp_tecn='+f_esp_tecn+'&aport_client_tecni='+aport_client_tecni+'&aport_tecni='+aport_tecni+'&apro_tecnico='+apro_tecnico+'&area_lote='+area_lote+'&elab_tecnico='+elab_tecnico+'&aport_legal='+aport_legal+'&id_fasfield='+id_fasfield+'&cod_estado_tec='+cod_estado_tec+'&cod_estado_ana='+cod_estado_ana+'&cod_estado_leg='+cod_estado_leg+'&ubu_predio='+ubu_predio+'&latitud='+latitud+'&longitud='+longitud+'&uso_suelo='+uso_suelo;

                  
                            $.ajax({

                                 type: "POST",
                                 data: datos,
                                 url: 'g_procesos.php?'+datos,
                                 success: function(valor){
                                            if(valor==1)
                                                alert("Datos guardados correctamente");
                                            else
                                                alert("Ocurrió un error, por favor contacte con el administrador");

                                 }

                            });

                }
                else
                  alert("Por favor complete la siguiente Información: Uso del suelo, latitud, longitud y ubicación del predio");
               
        
    });
    

  });
</script>

 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <center>
                   <?php if($_SESSION['tipo_usuario']==23 || $_SESSION['tipo_usuario']==1 ){   ?> <input type="button" name="guardar" id='grabar_proc' class='btn btn-warning' value='Guardar'><?php } ?></center>
                    <div class="card-body">
                      <p> 
    <div class="panel-group" id="accordion">
 


    <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
      Estado del diagnóstico</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse in">
      <div class="panel-body">
      <table width="70%" border="0" class="table responsive">
      <tr>
        <td width="155">Fecha de asignación</td>
        <td width="613"><?php echo $fecha_filtro ?></td>
      </tr>
      <tr>
        <td>Tiempo de vencimiento:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Responsable legal:</td>
        <td><?php echo $d2['nombre']." ".$d2['apellidos'] ?></td>
      </tr>
      <tr>
        <td>Responsable técnico: </td>
        <td><?php echo $d3['nombre']." ".$d3['apellidos'] ?></td>
      </tr>
      <tr>
        <td>Etapa:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Última actuación:</td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td>Perfil del cliente:</td>
        <td><a href="perfil_cliente2.php?cod_cliente=<?php echo $datos2['cod_cliente']; ?>" target='_blank'>Ver perfil</a></td>
      </tr>

      <tr>
        <td>Documento (Diagnóstico) :</td>
        <td><a href="reportes/pdfdiagnostico_online.php?id_elab_diag=<?php echo $_GET['id_elab_diag']; ?>" target='_blank'>Visualizar (Online)</a>
<a href="reportes/creatediagnostico.php?id_elab_diag=<?php echo $_GET['id_elab_diag']; ?>" target='_blank'>Visualizar (PDF))</a>
        </td>
      </tr>

      <tr>
        <td>Ver ficha:</td>
        <td><a href="reportes/ficha_diagno.php?id_elab_diag=<?php echo $id_elab_diag; ?>" target='_blank'>Ver ficha</a>
        </td>
      </tr>




    </table>

</div>

    </div>
  </div>

   <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
       Información básica del usuario</a>
      </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body">
   <table width="42%" border="0" class="table responsive">
      <tr>
        <td width="203">(*)Nombre del cliente:</td>
        <td width="259"><input type="text" name="textfield" class="form-control" id="nombre" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?>  value="<?php echo $datos2['nombre'] ?>">
       </td>
      </tr>
      <tr>
        <td>(*)Identificación:</td>
        <td><input type="text" name="textfield2" class="form-control" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?>  id="cod_cliente" value="<?php echo $datos2['cod_cliente'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Dirección (Formato IGAC):</td>
        <td><input type="text" name="textfield3" class="form-control" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?>  id="dir_form_igac" value="<?php echo $d['dir_form_igac'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Barrio (nombre legal):</td>
        <td><input type="text" name="textfield4" class="form-control" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> id="barrio" value="<?php echo $d['barrio'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Ciudad (Asesor):</td>
        <td><input type="text" name="textfield5" class="form-control" id="ciudad" <?php if($_SESSION['tipo_usuario']==22 or $_SESSION['tipo_usuario']==23){ ?> readonly="readonly" <?php } ?>  value="<?php echo $d['ciudad'] ?>"></td>
      </tr>  

      <tr>
        <td>(*)Ciudad (Cliente):</td>
        <td><input type="text" name="textfield5" class="form-control" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?>  id="municipio" value="<?php echo $d['municipio'] ?>"></td>
      </tr>  

      </table>
</div>
    </div>
  </div>


<div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
        Revisión de los documentos del cliente y de la encuesta </a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">

        <div id='list_revi_docu'></div>

           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=1&ficha=<?php echo base64_encode('Revisión de los documentos del cliente y de la encuesta') ?>" class='edicion'>Registrar/Editar</a>
          </div>
       </div>
  </div>

  <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse41">
        Identificar cadena de tradiciones  </a>
        </h4>
      </div>
      <div id="collapse41" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu2'></div>

        <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=2&ficha=<?php echo base64_encode('Identificar cadena de tradiciones') ?>" class='edicion'>Registrar/Editar</a>
       </div>
      </div>
  </div>

  <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse42">
        Revisión páginas de mapas </a>
        </h4>
      </div>
      <div id="collapse42" class="panel-collapse collapse">
        <div class="panel-body">

           <div id='list_revi_docu3'></div>
       <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=3&ficha=<?php echo base64_encode('Revisión páginas de mapas') ?>" class='edicion'>Registrar/Editar</a>
       </div>
      </div>
  </div>
  
   <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse43">
       Revisión páginas impuestos </a>
        </h4>
      </div>
      <div id="collapse43" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu4'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=4&ficha=<?php echo base64_encode('Revisión páginas impuestos') ?>" class='edicion'>Registrar/Editar</a>

       </div>
      </div>
    </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse431">
       Revisión bases de datos </a>
        </h4>
      </div>
      <div id="collapse431" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu5'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=5&ficha=<?php echo base64_encode('Revisión bases de datos') ?>" class='edicion'>Registrar/Editar</a>

       </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse432">
       Revisión de mapas colaborativos </a>
        </h4>
      </div>
      <div id="collapse432" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu6'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=6&ficha=<?php echo base64_encode('Revisión mapas colaboartivos') ?>" class='edicion'>Registrar/Editar</a>

       </div>
      </div>
    </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4331">
       Analisis de FMI </a>
        </h4>
      </div>
      <div id="collapse4331" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu7'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=7&ficha=<?php echo base64_encode('Analisis de FMI') ?>" class='edicion'>Registrar/Editar</a>

       </div>
      </div>
    </div>

     <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4332">
       Analisis de la titularidad </a>
        </h4>
      </div>
      <div id="collapse4332" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu8'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=8&ficha=<?php echo base64_encode('Analisis de la titularidad') ?>" class='edicion'>Registrar/Editar</a>

       </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4321">
       Analisis de la situación actual del impuesto predial </a>
        </h4>
      </div>
      <div id="collapse4321" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu9'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=9&ficha=<?php echo base64_encode('Analisis de la situación actual del impuesto predial') ?>" class='edicion'>Registrar/Editar</a>

       </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4322">
        Análisis situación actual servicios públicos  </a>
        </h4>
      </div>
      <div id="collapse4322" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu10'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=10&ficha=<?php echo base64_encode('Análisis situación actual servicios públicos ') ?>" class='edicion'>Registrar/Editar</a>

       </div>
      </div>
    </div>
          

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse43321">
       Otras situaciones (Legal) </a>
        </h4>
      </div>
      <div id="collapse43321" class="panel-collapse collapse">
        <div class="panel-body">
           <div id='list_revi_docu11'></div>
          <?php if($_SESSION['tipo_usuario']==22 or $_SESSION['tipo_usuario']==1){ ?> <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=11&ficha=<?php echo base64_encode('Otras situaciones') ?>" class='edicion'>Registrar/Editar</a>  <?php } ?>

       </div>
      </div>
    </div>

<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
       Situación actual y ubicación del predio</a>
      </h4>
    </div>
    <div id="collapse5" class="panel-collapse collapse">
      <div class="panel-body">
       <table width="42%" border="0" class="table responsive">
      <tr>
        <td width="203">(*)Ubicación del predio:</td>
        <td width="259"><input type="text" name="textfield" class="form-control" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> id="ubu_predio" value="<?php echo $d['ubu_predio'] ?>">
       </td>
      </tr>
      <tr>
        <td>(*)Longitud:</td>
        <td><input type="text" name="textfield2" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> class="form-control" id="longitud" value="<?php echo $d['longitude'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Latitud:</td>
        <td><input type="text" name="textfield3" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> class="form-control" id="latitud" value="<?php echo $d['latitude'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Uso de suelo</td>
        <td><input type="text" name="textfield4" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> class="form-control" id="uso_suelo" value="<?php echo $d['uso_suelo'] ?>">></td>
      </tr>
      <tr>
        <td>(*)Foto o imagen</td>
        <td>Ver/Visualizar</td>
      </tr>
      </table>
</div>
    </div>
  </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
        Afectaciones</a>
        </h4>
      </div>
      <div id="collapse6" class="panel-collapse collapse">
        <div class="panel-body">
            <div id='history_afect' align="center"> </div>
    <p><a href="../../includes/php/revi_diag.php?id_elab_diag=<?php echo $_GET['id_elab_diag'] ?>&tipo_seguimiento=8" class='edicion'><?php if($_SESSION['tipo_usuario']==23 or $_SESSION['tipo_usuario']==1){ ?> Agregar/Editar Afectaciones <?php } ?></a></p></div>
       

       </div>
      </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
        Análisis del cumplimento y ordenamiento territorial</a>
        </h4>
      </div>
      <div id="collapse8" class="panel-collapse collapse">
        <div class="panel-body"> <table width="68%" border="0" class="table responsive">
      <tr>
        <td width="487">(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">TIPOLOGÍA: cantidad de viviendas por construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) )
            :</label>
        </span></td>
        <td width="258"><span class="col-sm-9">
          <textarea name="tipol_cant_constr" class="form-control" id="tipol_cant_constr" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder=" Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['tipol_cant_constr'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td>(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">ALTURA: cantidad de pisos construidos ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) )
            :</label>
        </span></td>
        <td><span class="col-sm-9">
        <textarea name="alt_cant_pisos" class="form-control" id="alt_cant_pisos" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)
"><?php echo $d['alt_cant_pisos'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td>(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">Area del lote ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) ):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="area_lote" class="form-control" id="area_lote" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['area_lote'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td>(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">Dimensión frente del lote  ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) ):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dim_frent_lote" class="form-control" id="dim_frent_lote" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dim_frent_lote'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">(*) Dimensión frente de la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) )
            :</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dim_frent_const" class="form-control" id="dim_frent_const" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dim_frent_const'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Distancia entre el lado posterior del lote y la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) )
            :</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dist_lad_lot" class="form-control" id="dist_lad_lot" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dist_lad_lot'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Distancia entre el lado izquierdo del lote y la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) ):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dist_lot_izq" class="form-control" id="dist_lot_izq" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dist_lot_izq'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Distancia entre el lado derecho del lote y la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dist_lot_der" class="form-control" id="dist_lot_der" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dist_lot_der'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Se toma el área tipo de área (catastral, registral, etc):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="area_catastral" class="form-control" id="area_catastral" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Introduzca tipo de area (Catastral, registral, etc)"><?php echo $d['area_catastral'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">"PONER LO QUE CUMPLEXXXXXX y XXXXXXXXPONER LO QUE NO CUMPLE Y LAS RAZONES, CUANDO SEA EL CASO"
            :</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="raz_cumpl" class="form-control" id="raz_cumpl" <?php if($_SESSION['tipo_usuario']==22){ ?> readonly="readonly" <?php } ?> placeholder="Introduzca Lo que cumploe xxxx y xxxxintroducir lo que no cumple y las razones, cuando sea el caso"><?php echo $d['raz_cumpl'] ?></textarea>
        </span></td>
      </tr>
      </table>
</div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse12">
        Servicios ofrecidos </a>
        </h4>
      </div>
      <div id="collapse12" class="panel-collapse collapse">
        <div class="panel-body">
          <div id='history_serv_recom' align="center"> </div>
    <p><a href="../../includes/php/revi_diag.php?id_elab_diag=<?php echo $_GET['id_elab_diag'] ?>&tipo_seguimiento=14" class='edicion'>Agregar/Editar Servicios</a></p></div>

        </div>
      </div>

      <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse12">
        Servicios recomendados </a>
        </h4>
      </div>
      <div id="collapse12" class="panel-collapse collapse">
        <div class="panel-body">
          <div id='history_serv_recom' align="center"> </div>
    <p><a href="../../includes/php/revi_diag.php?id_elab_diag=<?php echo $_GET['id_elab_diag'] ?>&tipo_seguimiento=14" class='edicion'>Agregar/Editar Servicios</a></p></div>

        </div>
      </div>

    <!--<div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse13">
        Servicios recomendados</a>
        </h4>
      </div>
      <div id="collapse13" class="panel-collapse collapse">
        <div class="panel-body">
             <div id='history_serv_recom2' align="center"> </div>
    <p><a href="../../includes/php/revi_diag.php?id_elab_diag=<?php echo $_GET['id_elab_diag'] ?>&tipo_seguimiento=15" class='edicion'>Agregar/Editar Servicios</a></p></div>

        </div>
      </div>-->

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1311">
        Párrafos</a>
        </h4>
      </div>
      <div id="collapse1311" class="panel-collapse collapse">
        <div class="panel-body">
             <div id='list_revi_docu12'></div>
            <p><a href="../../includes/php/construc_parraf.php?cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=12&id_elab_diag=<?php echo $id_elab_diag ?>" class='edicion'>Construcción de parrafos</a></p>

        </div>
      </div>
    </div>

      <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse131">
        Cotización</a>
        </h4>
      </div>
      <div id="collapse131" class="panel-collapse collapse">
        <div class="panel-body">
                <div id='history_cotizacion' align="center"> Espere por favor.
                    </div>
        </div>
      </div>
    </div>

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse14">
      Política de comunicación (Última comunicación)</a>
      </h4>
    </div>
    <div id="collapse14" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi4' align="center">                           </div>
    <p><a href="../../includes/php/revi_call2.php?cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo_seguimiento=6&id_serv_cliente=<?php echo $id_elab_diag ?>" class='edicion'>Nueva comunicación</a></p></div>
    </div>
  </div>


   <!--
 <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse16">
     Soporte técnico</a>
      </h4>
    </div>
    <div id="collapse16" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi5' align="center">                           </div>
    <p><a href="../../includes/php/solicitud.php?cod_cliente=<?php echo $d['cod_cliente'] ?>&id_serv_cliente=<?php echo $id_elab_diag ?>" class='edicion'>Reportar problema</a></p></div>
    </div>
  </div>-->
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