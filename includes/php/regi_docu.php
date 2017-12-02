<?php
include('../dependencia/conexion.php');
            $sql="select * from tipo_docu";
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
                        <h4 class="page-title">GESTION DOCUMENTAL - REGISTRO DE DOCUMENTOS</h4> </div>
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

                        if(id_cliente!=0){


                                var datos ='g_add_docu='+1+'&nombre='+nombre+'&apellidos='+apellidos+'&tipo_docu='+tipo_docu+'&create='+1+'&id_cliente='+id_cliente;

                                                $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){

                                                                if(valor!=2){

                                                                    alert("Registro realizado correctamente");
                                                                    $("#repor").html(valor);

                                                                }else if(valor==2){
                                                                    alert("Ocurrió un problema al registrar el usuario");
                                                                }
                                                                else if(valor==3){
                                                                    alert("El Cliente y/o empleado ya existe");
                                                                }
                                                     }

                                                });
                        }else
                        alert("Por favor seleccione a qué tipo de documentación va a pertenecer el usuario");

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