<?php
include('../dependencia/conexion.php');
            $sql="select * from tipo_terminacion";
            $query=pg_query($conexion, $sql);
            // Listado de proyectos..

            $sql3="select * from proyectos_tar";
            $query3=pg_query($conexion, $sql3);

            $sql4="select * from usuarios where cod_usuario<>83";
            $query4=pg_query($conexion, $sql4);

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="js/datepicker-master/dist/datepicker.js"></script><
   <link rel="stylesheet" href="js/datepicker-master/dist/datepicker.css">
<link rel="stylesheet" href="js/colorbox-master/example1/colorbox.css" />
<script src="js/colorbox-master/jquery.colorbox-min.js"></script>
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ASIGNACIÓN DE TAREAS </h4> </div>
                </div>
                <!-- .row -->

                 <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                       <div class="form-group">
                                            <label class="col-sm-12">CONFIG. DE LA TAREA</label>
                                            <label class="col-sm-12"><hr></hr></label>
                                        </div>     

                                        <div class="form-group">
                                            <label class="col-sm-12">PROYECTO</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="cod_proyecto">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query3)){

                                                           ?>

                                                           <option value="<?= $datos['cod_proyecto']?>"><?php echo ($datos['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12">PRIORIDAD</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="prioridad">
                                                   <option value="0">Seleccione</option>
                                                   <option value="1">Alta</option>
                                                   <option value="2">Media</option>
                                                   <option value="3">Baja</option>                         
                                                </select>
                                            </div>
                                        </div>   

                                        <div class="form-group">
                                            <label class="col-sm-12">REPETICIONES</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="n_repet">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                  for($i=1;$i<=30;$i++){
                                                           ?>

                                                           <option value="<?= $i ?>"><?php echo $i ?></option>
                                                            <?php 
                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>   
                                         <div class="form-group">
                                            <label class="col-sm-12">TÉRMINACIÓN</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="tipo_termino">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query)){

                                                           ?>

                                                           <option value="<?= $datos['tipo_termino']?>"><?php echo ($datos['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>   
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-6">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                        
                                         <div class="form-group">
                                            <label class="col-sm-12">DATOS DE LA TAREA</label>
                                            <label class="col-sm-12"><hr></hr></label>
                                        </div>   

                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">NOMBRE DE LA TAREA</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="nombre"> </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">DESCRIPCIÓN</span></label>
                                            <div class="col-md-12">
                                                <input type="textarea" class="form-control form-control-line" id="descripcion"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">FECHA DE INICIO</span></label>
                                            <div class="col-md-12">
                                                <input type="text" readonly="readonly" class="form-control form-control-line" id="fecha_inicio"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">FECHA DE VENCIMIENTO</span></label>
                                            <div class="col-md-12">
                                                <input type="text" readonly="readonly" class="form-control form-control-line" id="fecha_venci"> </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">ASIGNADO A </span></label>
                                             <select class="form-control" id="cod_usu_asignado">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query4)){

                                                           ?>

                                                           <option value="<?= $datos['cod_usuario']?>"><?php echo ($datos['nombre']." ".$datos['apellidos'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                        </div>
                                          <input type="button" name="button" id="registrar2" class="btn btn-primary" value="Registrar">     
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                 <div id='repor2'>   
            
                </div>

                <!-- /.row -->
<script type="text/javascript">
      /*global $, document*/
$(document).ready(function () {

$('#fecha_inicio').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });

$('#fecha_venci').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });

$("#cargando2").hide(); 
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });      

        
                $("#registrar2").click(function(){

                        var nombre = $("#nombre").val();
                        var cod_proyecto=$("#cod_proyecto").val();
                        var cod_usu_asignado=$("#cod_usu_asignado").val();
                        var tipo_termino=$("#tipo_termino").val();
                        var n_repet=$("#n_repet").val();
                        var prioridad=$("#prioridad").val();
                        var descripcion=$("#descripcion").val();
                        var fecha_venci=$("#fecha_venci").val();
                        var fecha_ini=$("#fecha_inicio").val();

                        if(nombre!="" && cod_proyecto!="" && cod_usu_asignado!="" && tipo_termino!="" && n_repet!="" && prioridad!="" && descripcion!=""){


                                var datos ='g_tareas='+1+'&create='+1+'&nombre='+nombre+'&cod_proyecto='+cod_proyecto+'&cod_usu_asignado='+cod_usu_asignado+'&tipo_termino='+tipo_termino+'&n_repet='+n_repet+'&prioridad='+prioridad+'&descripcion='+descripcion+'&fecha_venci='+fecha_venci+'&fecha_ini='+fecha_ini+'&vistas='+5;

                                                $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){

                                                                if(valor!=2 || valor!=3){

                                                                    alert("Registro realizado correctamente");
                                                                     $("#repor2").html(valor);

                                                                }else if(valor==2){
                                                                    alert("Ocurrió un problema al registrar el usuario");
                                                                }
                                                                else if(valor==3){
                                                                    alert("Existe un nombre igual en sus tareas, por favor intenta con otro nombre");
                                                                }
                                                     }

                                                });
                        }else
                        alert("Por favor complete los campos con asterícos son obligatorios");

                });

var datos='vistas='+5;
                    $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){
                                                            $("#repor2").html(valor);
                                                            
                                                     }

                                                });
            
});

  
</script>  