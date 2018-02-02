<?php
include('../dependencia/conexion.php');
	if($_SESSION['cod_usuario']==1)
	$sql="select * from ciudad_asesor ";
	else
	$sql="select * from ciudad_asesor where asesor='".$_SESSION['email']."' ";
	
	$query=pg_query($conexion, $sql); 
?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="js/datepicker-master/dist/datepicker.js"></script><
   <link rel="stylesheet" href="js/datepicker-master/dist/datepicker.css">
<link rel="stylesheet" href="js/colorbox-master/example1/colorbox.css" />
<script src="js/colorbox-master/jquery.colorbox-min.js"></script>
<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">DASHBOARD (VENTAS)</h4> </div>
                </div>
          <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">                   
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="#">
                                        <div class="form-body">
                                        
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>CIUDAD</label>
                                                       <select name="select" id="ciudad" class='form-control'>
                            <?php if($_SESSION['tipo_usuario']==1 or  $_SESSION['tipo_usuario']==2 or  $_SESSION['tipo_usuario']==19 or  $_SESSION['tipo_usuario']==4  or $_SESSION['tipo_usuario']==15  or $_SESSION['tipo_usuario']==18){  ?><option value="Todos">Todos</option><?php  }  ?>
                            
                                                        <?php if($_SESSION['tipo_usuario']==1 or  $_SESSION['tipo_usuario']==2 or $_SESSION['tipo_usuario']==15  or $_SESSION['tipo_usuario']==18){  ?><option value="solbaq">Soledad y Barranquilla</option><?php  }  ?>
                            <?php if($_SESSION['tipo_usuario']==15 or $_SESSION['tipo_usuario']==1 or $_SESSION['tipo_usuario']==2  or $_SESSION['tipo_usuario']==11  or $_SESSION['tipo_usuario']==18){  ?><option value="Barranquilla">Barranquilla</option><?php  }  ?>
                            <?php if($_SESSION['tipo_usuario']==16 or $_SESSION['tipo_usuario']==15 or $_SESSION['tipo_usuario']==1 or $_SESSION['tipo_usuario']==2  or $_SESSION['tipo_usuario']==18 or $_SESSION['tipo_usuario']==11){  ?><option value="Bogotá">Bogotá</option><?php  }  ?>
                           <?php if($_SESSION['tipo_usuario']==14 or $_SESSION['tipo_usuario']==15 or $_SESSION['tipo_usuario']==1 or $_SESSION['tipo_usuario']==2  or $_SESSION['tipo_usuario']==18 or $_SESSION['tipo_usuario']==11 ){  ?> <option value="Cali">Cali</option><?php  }  ?>
                            <?php if($_SESSION['tipo_usuario']==17 or $_SESSION['tipo_usuario']==1 or $_SESSION['tipo_usuario']==15  or $_SESSION['tipo_usuario']==2  or $_SESSION['tipo_usuario']==18){  ?><option value="Medellin">Medellín</option><?php  }  ?>
                            <?php if($_SESSION['tipo_usuario']==15 or $_SESSION['tipo_usuario']==1  or $_SESSION['tipo_usuario']==2  or $_SESSION['tipo_usuario']==11  or $_SESSION['tipo_usuario']==18){  ?><option value="Soledad">Soledad</option><?php  }  ?>
                          </select> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fecha inicial</label>
                                                        <input type="text" name="textfield" readonly='readonly' class='form-control' id="fecha_1"></div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fecha final</label>
                                                        <input type="text" name="textfield" readonly='readonly' class='form-control' id="fecha_2"></div>
                                                </div>
                                                <input type="button" name="buscar"  value="Buscar" class='btn btn-primary' id="buscar">
                                                <!--/span-->
                                            </div>
                                        </div>
                                      
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>          
                  
                    <img src='img/preloader.gif' id='cargando2'>
          <div id='repor'>
          	
         </div>
<script type="text/javascript">
      /*global $, document*/
$(document).ready(function () {
  
$("#cargando2").hide();
  
  $('#fecha_1').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });
      
      $('#fecha_2').datepicker({
        autoHide: true,
        zIndex: 2048,
          format: 'yyyy-mm-dd'
      });
  
      $("#buscar").click(function(){


            var fecha_1=$("#fecha_1").val();
            var fecha_2=$("#fecha_2").val();
            var ciudad=$("#ciudad").val();
            var tipo_informe=1;

                var datos='repor_pagos='+1+'&fecha_1='+fecha_1+'&fecha_2='+fecha_2+'&ciudad='+ciudad+'&tipo_informe='+tipo_informe;

                if(fecha_1!="" && fecha_2!=""){
$("#cargando2").show();
                      $.ajax({

                              type: "POST",
                              data: datos,
                               url: 'includes/php/g_procesos.php',
                              success: function(valor){
                                  $("#cargando2").hide();
                                      $("#repor").html(valor);
                              }

                      });
                }else{

                    alert("Por favor seleccione las fechas en el cual quiere ver la información");
                }


      });

});


  
</script>  