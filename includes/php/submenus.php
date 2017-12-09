<?php
include('../dependencia/conexion.php');
            $sql="select * from menu where cod_menu='".$_GET['cod_menu']."' ";
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
                        <h4 class="page-title">GESTIÓN DE SUBMENUS</h4> </div>
                </div>
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                         <div class="form-group">
                                            <label class="col-sm-12">MENÚ</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="cod_menu">                                              
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query)){

                                                           ?>

                                                           <option value="<?= $datos['cod_menu']?>"><?php echo ($datos['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">NOMBRE DEL SUBMENU</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="descripcion2"> </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">RUTA</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="ruta2"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">ORDEN</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="m_order"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">COMENTARIO</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" id="comentario"> </div>
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
    
$("#cargando2").hide(); 
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });      

     var cod_menu=$("#cod_menu").val();
        
                $("#registrar2").click(function(){

                       
                        var descripcion=$("#descripcion2").val();
                        var ruta=$("#ruta2").val();
                        var m_order=$("#m_order").val();
                        var comentario=$("#comentario").val();

                        if(descripcion!="" && ruta!="" && m_order!=""){


                                var datos ='g_menus='+1+'&submenu='+1+'&cod_menu='+cod_menu+'&descripcion='+descripcion+'&ruta='+ruta+'&m_order='+m_order+'&comentario='+comentario+'&vistas='+3;

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

var datos='vistas='+3+'&cod_menu='+cod_menu;
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