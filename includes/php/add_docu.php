<?php
include('../dependencia/conexion.php');
            $sql="select * from categorias_docu";
            $query=pg_query($conexion, $sql);
?>
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">GESTION DOCUMENTAL - REGISTRO DE DOCUMENTOS - CLIENTE:</h4> </div>
                </div>
                <!-- .row -->

                 <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                          <div class="form-group">
                                            <label class="col-sm-12">CATEGORIA</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="id_cate_docu">
                                                   <option value="0">Seleccione</option>
                                                           <?php
                                                                    while($datos=pg_fetch_assoc($query)){

                                                           ?>

                                                           <option value="<?= $datos['id_cate_docu']?>"><?php echo ($datos['descripcion'])  ?></option>

                                                            <?php 

                                                                    } 
                                                           ?>
                                                </select>
                                            </div>
                                        </div>                                      
                                       <input type="button" name="button" id="registrar2" class="btn btn-primary" value="Registar">
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
        
                $("#registrar2").click(function(){

                        var id_cate_docu = $("#id_cate_docu").val();
                        var id_cliente=<?php echo $_GET['id_cliente'] ?>;

                        if(id_cliente!=0){


                                var datos ='g_add_docu='+1+'&id_cate_docu='+id_cate_docu+'&id_cliente='+id_cliente+'&create_docu='+1;

                                                $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){

                                                                if(valor!=2){

                                                                    alert("Documento agregado correctamente");
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
                                                            $("#repor2").html(valor);
                                                            
                                                     }

                                                });
});

  
</script>  