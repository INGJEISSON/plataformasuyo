<?php
include('../dependencia/conexion.php');
            $sql="select * from servicios where tipo=1";
            $query=pg_query($conexion, $sql);

            $sql2="select * from servicios where tipo=0 ";
            $query2=pg_query($conexion, $sql2);
?>
<link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
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
                        <h4 class="page-title">GESTION DE SERVICIOS Y DEPEDENCIAS</h4> </div>
                </div>
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                        <div class="form-group">
                                            NOMBRE DEL SERVICIO
                                            <div class="col-sm-12">
                                                <select class="form-control" id="cod_servicio">                                              
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query)){

                                                           ?>

                                                           <option value="<?= $datos['cod_servicio']?>"><?php echo ($datos['nom_servicio'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                            DEPENDENCIA
                                             <div class="col-sm-12">
                                                <select class="form-control" id="cod_servicio2">                                              
                                                           <?php
                                                                    while($datos2=pg_fetch_assoc($query2)){

                                                           ?>

                                                           <option value="<?= $datos2['cod_servicio']?>"><?php echo ($datos2['nom_servicio'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                                </div>
                                            </div>
                                         
                                       <input type="button" name="button" id="registrar" class="btn btn-primary" value="Registrar">
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <div id='repor'>
            
                </div>

<script type="text/javascript">
$(document).ready(function () {

    
    
$("#cargando2").hide(); 
                    $("#registrar").click(function(){

                         
                       var cod_servicio=$("#cod_servicio").val();  
                       var cod_servicio2=$("#cod_servicio2").val();   
                      
                                var datos ='g_servicios='+1+'&cod_servicio='+cod_servicio+'&dependencias='+1+'&vistas='+10+'&cod_servicio2='+cod_servicio2;

                                                $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){

                                                                if(valor==1){

                                                                    alert("Registro realizado correctamente");
                                                                  //  $("#repor").html(valor);

                                                                }else if(valor==2){
                                                                    alert("Ocurrió un problema al registrar el usuario");
                                                                }
                                                                else if(valor==3){
                                                                    alert("El servicio dependiente ya existe");
                                                                }
                                                     }

                                                });
                     

                });

                        var datos='vistas='+10;
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