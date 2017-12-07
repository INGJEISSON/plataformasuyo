<?php
include('../dependencia/conexion.php');
            $sql="select * from grupo_usuarios";
            $query=pg_query($conexion, $sql);
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
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">GESTION DE MENUS</h4> </div>
                </div>
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">NOMBRE</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="descripcion"> </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">CAMPO</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="campo"> </div>
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

                       var descripcion=$("#descripcion").val();
                       var campo= $("#campo").val();
                       var ruta=$("#ruta").val();

                        if(descripcion!="" ){


                                var datos ='g_menus='+1+'&descripcion='+descripcion+'&campo='+campo+'&ruta='+ruta+'&create='+1+'&vistas='+2;

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
                                                                    alert("El Menú ya existe");
                                                                }
                                                     }

                                                });
                        }else
                        alert("Por favor seleccione a qué grupo de usuario va a pertenecer el usuario");

                });

var datos='vistas='+2;
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