<?php
include('../dependencia/conexion.php');
            $sql="select * from tipo_docu";
            $query=pg_query($conexion, $sql);

            $sql2="select * from bodegas";
            $query2=pg_query($sql2);
?>

<link rel="stylesheet" href="js/colorbox-master/example1/colorbox.css" />
<script src="js/colorbox-master/jquery.colorbox-min.js"></script>
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ASIGNACIÓN DE TAREAS </h4> </div>
                </div>
                <!-- .row -->

                 <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                           <div class="form-group">
                                            <label class="col-md-12"><span class="help">IDENTIFICACIÓN</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="id_cliente"> </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">APELLIDOS</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="apellidos"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">NOMBRE</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="nombre"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12">TIPO DE DOCUMENTACIÓN</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="tipo_docu">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query)){

                                                           ?>

                                                           <option value="<?= $datos['tipo_docu']?>"><?php echo ($datos['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>            

                                        <div class="form-group">
                                            <label class="col-sm-12">BOBEGA</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="cod_bodega">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    while($datos2=pg_fetch_assoc($query2)){

                                                           ?>

                                                           <option value="<?= $datos2['cod_bodega']?>"><?php echo ($datos2['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>          

                                         <div class="form-group">
                                            <label class="col-sm-12">ESTANTE</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="cod_estante">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    for($i=1;$i<=20;$i++){

                                                           ?>

                                                           <option value="<?= $i ?>"><?php echo ($i)  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>       

                                        <div class="form-group">
                                            <label class="col-sm-12">UBICACION</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="ubicacion">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    for($i=1;$i<=20;$i++){

                                                           ?>

                                                           <option value="<?= $i ?>"><?php echo ($i)  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>         


                                       <input type="button" name="button" id="registrar" class="btn btn-primary" value="Registar">
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                 <div id='repor'>   
            
                </div>

                <!-- /.row -->
<script type="text/javascript">
      /*global $, document*/
$(document).ready(function () {
    
$("#cargando2").hide(); 
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });      

        
                $("#registrar").click(function(){

                        var nombre = $("#nombre").val();
                        var apellidos = $("#apellidos").val();
                        var tipo_docu = $("#tipo_docu").val();
                        var id_cliente= $("#id_cliente").val();
                        var cod_bodega= $("#cod_bodega").val();
                        var cod_estante= $("#cod_estante").val();
                        var ubicacion =$("#ubicacion").val();

                        if(id_cliente!=0 && cod_bodega!=0 && cod_estante!=0 && ubicacion!=0 && tipo_docu!=0){


                                var datos ='g_add_docu='+1+'&nombre='+nombre+'&apellidos='+apellidos+'&tipo_docu='+tipo_docu+'&create='+1+'&id_cliente='+id_cliente+'&cod_bodega='+cod_bodega+'&cod_estante='+cod_estante+'&ubicacion='+ubicacion;

                                                $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){

                                                                if(valor==1){

                                                                    alert("Registro realizado correctamente");
                                                                  var datos='g_add_docu='+1+'&listar_usuarios='+1;
    $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){
                                                            $("#repor").html(valor);
                                                            
                                                     }

                                                });

                                                                }else if(valor==2){
                                                                    alert("Ocurrió un problema al registrar el usuario");
                                                                }
                                                                else if(valor==3){
                                                                    alert("El Cliente y/o empleado ya existe");
                                                                }
                                                     }

                                                });
                        }else
                        alert("Por favor complete los campos con asterícos son obligatorios");

                });

var datos='g_add_docu='+1+'&listar_usuarios='+1;
    $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){
                                                            $("#repor").html(valor);
                                                            
                                                     }

                                                });
            
});

  
</script>  