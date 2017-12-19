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
     
     // Busco el nombre del responsable..
  /*   
     $sql10="select nombre from usuarios where cod_usuario='".$datos1['cod_usuario']."' ";
     $query10=pg_query($conexion, $sql10);
     $datos10=pg_fetch_assoc($query10);
     
    // Ultima actuación
    
    $sql11="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$id_serv_cliente."' ORDER BY activ_serv.id_activi_serv desc limit 1 ";
    $query11=pg_query($conexion, $sql11);
    @$datos11=pg_fetch_assoc($query11);*/
        
        
            
//echo "folio: ".$datos1['n_folio_inm'];
                                        
                  //  $parametro='AgendaCallCenter';   // Si son llamadas s贸lo para call center.              
/*$sql9="select * from cliente where cod_cliente='".$datos1['cod_cliente']."' ";
                    $query9=pg_query($conexion, $sql9);
                    $datos9=pg_fetch_assoc($query9);


    // Consulto la lista de poderes  y autorización necesario

            $sql2="select * from deta_list_despleg where tipo_lista=2";
            $query2=pg_query($conexion, $sql2);
            
            $sql21="select * from deta_list_despleg where tipo_lista=2 and id_list_despleg='".$datos1['poder_aut_nece']."' ";
            $query21=pg_query($conexion, $sql21);
            @$datos21=pg_fetch_assoc($query21);

     // Consulto la lista de tiene poder y autorización.

            $sql3="select * from deta_list_despleg where tipo_lista=3";
            $query3=pg_query($conexion, $sql3);
            
            $sql31="select * from deta_list_despleg where tipo_lista=3 and id_list_despleg='".$datos1['poder_aut']."' ";
            $query31=pg_query($conexion, $sql31);
            @$datos31=pg_fetch_assoc($query31);

     // Consulto la lista de tiene contrato.
            $sql4="select * from deta_list_despleg where tipo_lista=1";
            $query4=pg_query($conexion, $sql4);
            
             $sql41="select * from deta_list_despleg where tipo_lista=1 and id_list_despleg='".$datos1['firm_contrato']."' ";
            $query41=pg_query($conexion, $sql41);
            @$datos41=pg_fetch_assoc($query41);

     // Consulto la lista de estado de seguimiento (servicio).
            $sql5="select * from deta_list_despleg where tipo_lista=4";
            $query5=pg_query($conexion, $sql5);
            
            $sql51="select * from deta_list_despleg where tipo_lista=4 and id_list_despleg='".$datos1['id_list_despleg']."' ";
            $query51=pg_query($conexion, $sql51);
            @$datos51=pg_fetch_assoc($query51);*/


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
         
          
  });
</script>

 <header class="page-header">
           <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <center>
                    <input type="button" name="guardar" id='guardar' class='btn btn-warning' value='Guardar'></center>
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
        <td width="613">&nbsp;</td>
      </tr>
      <tr>
        <td>Tiempo de vencimiento:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Responsable legal:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Responsable técnico:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Etapa:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Última actuación:</td>
        <td>&nbsp;</td>
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
        <td width="259"><input type="text" name="textfield" class="form-control" id="textfield" value="<?php echo $datos2['nombre'] ?>">
       </td>
      </tr>
      <tr>
        <td>(*)Identificación:</td>
        <td><input type="text" name="textfield2" class="form-control" id="textfield2" value="<?php echo $datos2['cod_cliente'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Dirección (Formato IGAC):</td>
        <td><input type="text" name="textfield3" class="form-control" id="textfield3" value="<?php echo $d['dir_form_igac'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Barrio (nombre legal):</td>
        <td><input type="text" name="textfield4" class="form-control" id="textfield4" value="<?php echo $d['barrio'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Municipio:</td>
        <td><input type="text" name="textfield5" class="form-control" id="textfield5" value="<?php echo $d['ciudad'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Folio de matrícula:</td>
        <td><input type="text" name="textfield6" class="form-control" id="textfield6" value="<?php echo $d['folio_mat'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Referencia catastral:</td>
        <td><input type="text" name="textfield7" class="form-control" id="textfield7" value="<?php echo $d['refe_catas'] ?>"></td>
      </tr>
      </table>
</div>
    </div>
  </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
        Necesidad identificada</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">
            <div id='history_revi4' align="center"> </div>
    <p><a href="../../includes/php/seguimientos.php?cod_cliente=<?php echo $datos1['cod_cliente'] ?>&id_serv_diag=<?php echo $datos1['id_serv_diag'] ?>" class='edicion'>Agregar/Editar Necesidad</a></p></div>

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
        <td width="259"><input type="text" name="textfield" class="form-control" id="textfield" value="<?php echo $d['ubu_predio'] ?>">
       </td>
      </tr>
      <tr>
        <td>(*)Longitud:</td>
        <td><input type="text" name="textfield2" class="form-control" id="textfield2" value="<?php echo $d['longitud'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Latitud:</td>
        <td><input type="text" name="textfield3" class="form-control" id="textfield3" value="<?php echo $d['latitud'] ?>"></td>
      </tr>
      <tr>
        <td>(*)Uso de suelo</td>
        <td><input type="text" name="textfield4" class="form-control" id="textfield4" value="<?php echo $d['uso_suelo'] ?>">></td>
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
    <p><a href="../../includes/php/revi_diag.php?id_elab_diag=<?php echo $_GET['id_elab_diag'] ?>&tipo_seguimiento=8" class='edicion'>Agregar/Editar Afectaciones</a></p></div>
       

       </div>
      </div>

    

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
        Relación jurídica</a>
        </h4>
      </div>
      <div id="collapse7" class="panel-collapse collapse">
        <div class="panel-body">
            <div id='history_revi4' align="center"> </div>
    <p><a href="../../includes/php/seguimientos.php?cod_cliente=<?php echo $datos1['cod_cliente'] ?>&id_serv_diag=<?php echo $datos1['id_serv_diag'] ?>" class='edicion'>Agregar/Editar Relación jurídica</a></p></div>

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
          <textarea name="tipol_cant_constr" class="form-control" id="tipol_cant_constr" placeholder=" Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['tipol_cant_constr'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td>(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">ALTURA: cantidad de pisos construidos ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) )
            :</label>
        </span></td>
        <td><span class="col-sm-9">
        <textarea name="alt_cant_pisos" class="form-control" id="alt_cant_pisos" placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)
"><?php echo $d['alt_cant_pisos'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td>(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">Area del lote ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) ):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="area_lote" class="form-control" id="area_lote" placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['area_lote'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td>(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">Dimensión frente del lote  ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) ):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dim_frent_lote" class="form-control" id="dim_frent_lote" placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dim_frent_lote'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">(*) Dimensión frente de la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) )
            :</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dim_frent_const" class="form-control" id="dim_frent_const" placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dim_frent_const'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Distancia entre el lado posterior del lote y la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) )
            :</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dist_lad_lot" class="form-control" id="dist_lad_lot" placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dist_lad_lot'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Distancia entre el lado izquierdo del lote y la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias) ):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dist_lot_izq" class="form-control" id="dist_lot_izq" placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dist_lot_izq'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Distancia entre el lado derecho del lote y la construcción ( Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="dist_lot_der" class="form-control" id="dist_lot_der" placeholder="Separe por comas: el concepto de (Predio del usuario, Exigencias del POT, Cumplimiento de las exigencias)"><?php echo $d['dist_lot_der'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">Se toma el área tipo de área (catastral, registral, etc):</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="area_catastral" class="form-control" id="area_catastral" placeholder="Introduzca tipo de area (Catastral, registral, etc)"><?php echo $d['area_catastral'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td><span class="form-group row">
          <label class="col-sm-9 form-control-label">"PONER LO QUE CUMPLEXXXXXX y XXXXXXXXPONER LO QUE NO CUMPLE Y LAS RAZONES, CUANDO SEA EL CASO"
            :</label>
        </span></td>
        <td><span class="col-sm-9">
          <textarea name="raz_cumpl" class="form-control" id="raz_cumpl" placeholder="Introduzca Lo que cumploe xxxx y xxxxintroducir lo que no cumple y las razones, cuando sea el caso"><?php echo $d['raz_cumpl'] ?></textarea>
        </span></td>
      </tr>
      </table>
</div>
      </div>
    </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">
        Titularidad del predio</a>
        </h4>
      </div>
      <div id="collapse9" class="panel-collapse collapse">
        <div class="panel-body"> <table width="68%" border="0" class="table responsive">
      <tr>
        <td width="487">(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">Párrafo de cómo fue adquirido el predio por el cliente
            :</label>
        </span></td>
        <td width="258"><span class="col-sm-9">
          <textarea name="par_predio_client" class="form-control" id="par_predio_client" placeholder="Introduzca Párrafo de cómo fue adquirido el predio por el cliente"><?php echo $d['par_predio_client'] ?></textarea>
        </span></td>
      </tr>
      <tr>
        <td>(*)<span class="form-group row">
          <label class="col-sm-9 form-control-label">Párrafo de quién es el titular</label>
          :
        </span></td>
        <td><span class="col-sm-9">
        <textarea name="alt_cant_pisos" class="form-control" id="til_predio_client" placeholder="Introduzca el párrafo de quién es el titular"><?php echo $d['til_predio_client'] ?></textarea>
        </span></td>
      </tr>
      </table>
</div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">
        Situación actual en relación con el impuesto</a>
        </h4>
      </div>
      <div id="collapse10" class="panel-collapse collapse">
        <div class="panel-body"><div id='history_revi3' align="center">
                           </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Registrar/Editar</a></div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse15">
       Situación actual con lo servicios públicos</a>
        </h4>
      </div>
      <div id="collapse15" class="panel-collapse collapse">
        <div class="panel-body">
          <div id='history_revi3' align="center">
                    </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Registrar/Editar</a>

        </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse11">
        Otras situaciones</a>
        </h4>
      </div>
      <div id="collapse11" class="panel-collapse collapse">
        <div class="panel-body">
          <div id='history_revi3' align="center">
                    </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Nueva situación</a>

        </div>
      </div>
    </div>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse12">
        Servicios recomendados</a>
        </h4>
      </div>
      <div id="collapse12" class="panel-collapse collapse">
        <div class="panel-body">
          <div id='history_revi3' align="center">
                    </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Registrar/Editar</a>


        </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse13">
        Servicios que no se pueden recomendar</a>
        </h4>
      </div>
      <div id="collapse13" class="panel-collapse collapse">
        <div class="panel-body">
                <div id='history_revi3' align="center">
                    </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Registrar/Editar</a>


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
                <div id='history_revi31' align="center">
                    </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Cotizar</a>


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
    <p><a href="../../includes/php/revi_call2.php?cod_cliente=<?php echo $datos1['cod_cliente'] ?>&id_serv_cliente=<?php echo $datos1['id_serv_cliente'] ?>" class='edicion'>Nueva comunicación</a></p></div>
    </div>
  </div>

   <div class="panel panel-primary">
    <div class="panel-heading ">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse17">
      Actvidades (Última actividad)</a>
      </h4>
    </div>
    <div id="collapse17" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi3' align="center">
                           </div>
   <a href="../../includes/php/revi_servi.php?id_serv_cliente=<?php echo $id_serv_cliente ?>&cod_servicio=<?php echo $datos1['cod_servicio'] ?>&cod_cliente=<?php echo $datos1['cod_cliente'] ?>" class='edicion'>Nueva actividad</a></div>
    </div>
  </div>
  
 <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse16">
     Soporte técnico</a>
      </h4>
    </div>
    <div id="collapse16" class="panel-collapse collapse">
      <div class="panel-body"><div id='history_revi5' align="center">                           </div>
    <p><a href="../../includes/php/solicitud.php?cod_cliente=<?php echo $datos1['cod_cliente'] ?>&id_serv_cliente=<?php echo $datos1['id_serv_cliente'] ?>" class='edicion'>Reportar problema</a></p></div>
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