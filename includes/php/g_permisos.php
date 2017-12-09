<?php
include('../dependencia/conexion.php');
            $sql="select * from submenu ";
            $query=pg_query($conexion, $sql);

            $sql2="select * from usuarios";
            $query2=pg_query($conexion, $sql2);
?>
<link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="js/custom.min.js"></script>
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="js/colorbox-master/example1/colorbox.css" />
<script src="js/colorbox-master/jquery.colorbox-min.js"></script>
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">GESTIÓN DE PERMISOS DE USUARIOS</h4> </div>
                </div>
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                         
                                        <div class="form-group">
                                            <label class="col-sm-12">SELECCIONE USUARIO</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="cod_usuario">          
                                            <option value="0">Seleccione</option>                                    
                                                           <?php
                                                                    while($datos2=pg_fetch_assoc($query2)){

                                                           ?>

                                                           <option value="<?= $datos2['cod_usuario']?>"><?php echo ($datos2['nombre']. " ".$datos2['apellidos'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12">SELECCIONE SUBMENU</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="cod_submenu">        <option value="0">Seleccione</option>                                                    
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query)){

                                                           ?>

                                                           <option value="<?= $datos['cod_submenu']?>"><?php echo ($datos['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>

                                      
                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">ESTADO</span></label>
                                           <select class="form-control" id="cod_estado">       <option value="0">Seleccione</option>                                                     
                                                    <option value="0">Seleccione</option>           
                                                     <option value="5">Habilitado</option>  
                                                     <option value="6">Deshabilitado</option>                 
                                            </select>
                                        </div>

                                      
                                       <input type="button" name="button" id="registrar2" class="btn btn-primary" value="Actualizar">
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
    
$("#cargando2").hide(); 
   
     $("#cod_usuario").change(function(){

          var cod_usuario=$("#cod_usuario").val();


            var datos='vistas='+4+'&cod_usuario='+cod_usuario;
                    $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){
                                                            $("#repor2").html(valor);
                                                            
                                                     }

                                                });

     });
        
                $("#registrar2").click(function(){

                        var cod_estado=$("#cod_estado").val();
                        var cod_submenu=$("#cod_submenu").val();
                        var cod_usuario=$("#cod_usuario").val();
                        
                        if(cod_submenu!=0 && cod_usuario!=0 && cod_estado!=0){


                             var datos ='g_permisos='+1+'&cod_estado='+cod_estado+'&cod_submenu='+cod_submenu+'&cod_usuario='+cod_usuario+'&vistas='+4;

                                                $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){

                                                                if(valor!=2){

                                                                    alert("Registro realizado correctamente");
                                                                    $("#repor2").html(valor);

                                                                }else if(valor==2){
                                                                    alert("Ocurrió un problema al registrar el usuario");
                                                                }
                                                                else if(valor==3){
                                                                    alert("El submenu ya existe");
                                                                }
                                                     }

                                                });
                        }else
                        alert("Por favor complete los campos con asteríscos (*)");

                });


            
});


  
</script>  