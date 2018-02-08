<?php
include('../../dependencia/conexion.php');
   
//decodificamo id_serv_cliente
//$id_elab_diag=base64_decode($_GET['id_elab_diag']);
$id_elab_diag=($_GET['id_elab_diag']);

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../../js/datepicker-master/dist/datepicker.js"></script>
<link rel="stylesheet" href="../../js/datepicker-master/dist/datepicker.css">


<script>
  $(document).ready(function(){        
              

var id_fasfield="<?php echo $id_elab_diag ?>";
var tipo_seguimiento=8;
var datos='id_fasfield='+id_fasfield+'&revi_revi_call='+1+'&tipo_seguimiento='+tipo_seguimiento;    
            $("#cargar2").show();
              $.ajax({

                        type: "POST",
                        data: datos,
                        url: '../../includes/php/../g_procesos.php?'+datos,
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
                        url: '../../includes/php/../g_procesos.php?'+datos,
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
                                                      url: '../g_procesos.php?'+datos,
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
                        url: '../../includes/php/../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
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
                        url: '../g_procesos.php?'+datos,
                        success: function(valor){
                            $("#list_revi_docu12").empty();
                                $("#cargar2").hide();
                                   $("#list_revi_docu12").html(valor);
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
                    
                    <div class="card-body">
                      <p> 
    <div class="panel-group" id="">
 


    

   <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="" data-parent="#" href="#3">
       Información básica del usuario</a>
      </h4>
    </div>
    <div id="3" class="panel- ">
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
          <a data-toggle="" data-parent="#" href="#4">
        Revisión de los documentos del cliente y de la encuesta </a>
        </h4>
      </div>
      <div id="4" class="panel- ">
        <div class="panel-body">

        <div id='list_revi_docu'></div>

           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=1&ficha=<?php echo base64_encode('Revisión de los documentos del cliente y de la encuesta') ?>" class='edicion'></a>
          </div>
       </div>
  </div>

  <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#41">
        Identificar cadena de tradiciones  </a>
        </h4>
      </div>
      <div id="41" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu2'></div>

        <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=2&ficha=<?php echo base64_encode('Identificar cadena de tradiciones') ?>" class='edicion'></a>
       </div>
      </div>
  </div>

  <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#42">
        Revisión páginas de mapas </a>
        </h4>
      </div>
      <div id="42" class="panel- ">
        <div class="panel-body">

           <div id='list_revi_docu3'></div>
       <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=3&ficha=<?php echo base64_encode('Revisión páginas de mapas') ?>" class='edicion'></a>
       </div>
      </div>
  </div>
  
   <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#43">
       Revisión páginas impuestos </a>
        </h4>
      </div>
      <div id="43" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu4'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=4&ficha=<?php echo base64_encode('Revisión páginas impuestos') ?>" class='edicion'></a>

       </div>
      </div>
    </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#431">
       Revisión bases de datos </a>
        </h4>
      </div>
      <div id="431" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu5'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=5&ficha=<?php echo base64_encode('Revisión bases de datos') ?>" class='edicion'></a>

       </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#432">
       Revisión de mapas colaborativos </a>
        </h4>
      </div>
      <div id="432" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu6'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=6&ficha=<?php echo base64_encode('Revisión mapas colaboartivos') ?>" class='edicion'></a>

       </div>
      </div>
    </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#4331">
       Analisis de FMI </a>
        </h4>
      </div>
      <div id="4331" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu7'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=7&ficha=<?php echo base64_encode('Analisis de FMI') ?>" class='edicion'></a>

       </div>
      </div>
    </div>

     <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#4332">
       Analisis de la titularidad </a>
        </h4>
      </div>
      <div id="4332" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu8'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=8&ficha=<?php echo base64_encode('Analisis de la titularidad') ?>" class='edicion'></a>

       </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#4321">
       Analisis de la situación actual del impuesto predial </a>
        </h4>
      </div>
      <div id="4321" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu9'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=9&ficha=<?php echo base64_encode('Analisis de la situación actual del impuesto predial') ?>" class='edicion'></a>

       </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#4322">
        Análisis situación actual servicios públicos  </a>
        </h4>
      </div>
      <div id="4322" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu10'></div>
           <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=10&ficha=<?php echo base64_encode('Análisis situación actual servicios públicos ') ?>" class='edicion'></a>

       </div>
      </div>
    </div>
          

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#43321">
       Otras situaciones (Legal) </a>
        </h4>
      </div>
      <div id="43321" class="panel- ">
        <div class="panel-body">
           <div id='list_revi_docu11'></div>
          <?php if($_SESSION['tipo_usuario']==22 or $_SESSION['tipo_usuario']==1){ ?> <a href="../../includes/php/activi_diag.php?id_elab_diag=<?php echo $id_elab_diag ?>&cod_equipo=2&cod_cliente=<?php echo $d['cod_cliente'] ?>&tipo=11&ficha=<?php echo base64_encode('Otras situaciones') ?>" class='edicion'></a>  <?php } ?>

       </div>
      </div>
    </div>

<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="" data-parent="#" href="#5">
       Situación actual y ubicación del predio</a>
      </h4>
    </div>
    <div id="5" class="panel- ">
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
          <a data-toggle="" data-parent="#" href="#6">
        Afectaciones</a>
        </h4>
      </div>
      <div id="6" class="panel- ">
        <div class="panel-body">
            <div id='history_afect' align="center"> </div>
    <p><a href="../../includes/php/revi_diag.php?id_elab_diag=<?php echo $_GET['id_elab_diag'] ?>&tipo_seguimiento=8" class='edicion'><?php if($_SESSION['tipo_usuario']==23 or $_SESSION['tipo_usuario']==1){ ?> Agregar/Editar Afectaciones <?php } ?></a></p></div>
       

       </div>
      </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#8">
        Análisis del cumplimento y ordenamiento territorial</a>
        </h4>
      </div>
      <div id="8" class="panel- ">
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


    <!--<div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="" data-parent="#" href="#13">
        Servicios recomendados</a>
        </h4>
      </div>
      <div id="13" class="panel- ">
        <div class="panel-body">
             <div id='history_serv_recom2' align="center"> </div>
    <p><a href="../../includes/php/revi_diag.php?id_elab_diag=<?php echo $_GET['id_elab_diag'] ?>&tipo_seguimiento=15" class='edicion'>Agregar/Editar Servicios</a></p></div>

        </div>
      </div>-->

  
   
 

   <!--
 <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="" data-parent="#" href="#16">
     Soporte técnico</a>
      </h4>
    </div>
    <div id="16" class="panel- ">
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