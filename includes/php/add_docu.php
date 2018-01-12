<?php
include('../dependencia/conexion.php');
            $sql="select * from categorias_docu";
            $query=pg_query($conexion, $sql);

            $sql2="select * from documentacion where cod_cliente='".$_GET['id_cliente']."' ";
            $query2=pg_query($sql2);
            $datos2=pg_fetch_assoc($query2);
?>

  <script src="../../plugins/bower_components/jquery/dist/jquery.min.js"></script>
   <link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../js/colorbox-master/example1/colorbox.css" />
<script src="../../js/colorbox-master/jquery.colorbox-min.js"></script>



<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">REGISTRO DE DOCUMENTOS - CLIENTE: <?php echo $datos2['nombres']." ".$datos2['apellidos']  ?> </h4> </div>
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
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6" id="ane_archivo">
                                             <label class="col-sm-6" >ANEXAR ARCHIVO</label>
                                             <input type="button" name="button" id="registrar2" class="btn btn-primary" value="Anexar">
                                           
                                             </div>
                                               
                                        </div>                                      
                                       
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                 <div id='repor21'>
            
                </div>

                <!-- /.row -->
<script type="text/javascript">
      /*global $, document*/
$(document).ready(function(){

      $("#ane_archivo").hide();

    $("#id_cate_docu").change(function(){
            

            var id_cate_docu=$("#id_cate_docu").val();

                    if(id_cate_docu!=0){

                            $("#ane_archivo").show();
                    }else
                    $("#ane_archivo").hide();


     });
    $("#registrar2").click(function(){
          var id_cate_docu=$("#id_cate_docu").val();
          var cod_cliente="<?php echo $_GET['id_cliente'] ?>";
          var datos='id_cate_docu='+id_cate_docu+'&cod_cliente='+cod_cliente;

        $.colorbox({
          iframe:true, 
          width:"50%", 
          height:"50%",
          overlayClose:false,
          href: 'upload_docu.php?'+datos,
          //escKey:
          });


    });    
  var cod_cliente="<?php echo $_GET['id_cliente'] ?>";
                                var datos='g_add_docu='+1+'&cod_cliente='+cod_cliente+'&listar_documentos='+1;
                                          $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'g_procesos.php',
                                                     success: function(valor){
                                                            $("#repor21").html(valor);
                                                            
                                                     }

                                                });
});

  
</script>  