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
                        <h4 class="page-title">GESTION DOCUMENTAL</h4> </div>
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
                                                <input type="text" class="form-control form-control-line" id="nombre"> </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">APELLIDOS</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="apellidos"> </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">CORREO ELECTRÓNICO (SUYO)</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="email"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12">GRUPO DE USUARIO</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="id_grupo">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query)){

                                                           ?>

                                                           <option value="<?= $datos['cod_grupo']?>"><?php echo ($datos['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12">ROL O TIPO DE USUARIO</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="tipo_usuario">
                                                 
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

    
                $("#id_grupo").change(function(){

                                var id_grupo = $("#id_grupo").val();

                                        $('#cargando2').show();             
                                        $.ajax({
                                            type:"POST",                    
                                             url: 'includes/php/g_procesos.php',
                                            data:"id_grupo="+id_grupo+'&g_user='+1+'&bus_rol='+1+'&create='+1,
                                            success:function(msg){
                                                $('#cargando2').hide();
                                                $("#tipo_usuario").show();
                                                $("#tipo_usuario").empty().removeAttr("disabled").append(msg);      
                                                                                                        
                                                    
                                                }
                                            });



                });


        
                $("#registrar").click(function(){

                        var nombre = $("#nombre").val();
                        var apellidos = $("#apellidos").val();
                        var id_grupo = $("#id_grupo").val();
                        var tipo_usuario = $("#tipo_usuario").val();
                        var email = $("#email").val();

                        if(tipo_usuario!=0){


                                var datos ='g_user='+1+'&nombre='+nombre+'&apellidos='+apellidos+'&id_grupo='+id_grupo+'&tipo_usuario='+tipo_usuario+'&email='+email+'&create='+1;

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
                                                                    alert("El Usuario ya existe");
                                                                }
                                                     }

                                                });
                        }else
                        alert("Por favor seleccione a qué grupo de usuario va a pertenecer el usuario");

                });

var datos='g_user='+1+'&listar_usuarios='+1;
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