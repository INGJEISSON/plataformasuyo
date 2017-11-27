<?php
include('../dependencia/conexion.php');
	if($_SESSION['cod_usuario']==1)
  $sql="select * from usuarios where tipo_usuario=19 or tipo_usuario=6 or tipo_usuario=21";
  elseif($_SESSION['tipo_usuario']==6){
  $sql="select * from usuarios where tipo_usuario=21 or tipo_usuario=6";
  }
  else
  $sql="select * from usuarios where email='".$_SESSION['email']."' ";
	
	$query=mysqli_query($conexion, $sql); 
?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="../js/datepicker-master/dist/datepicker.js"></script>
   <link rel="stylesheet" href="../js/datepicker-master/dist/datepicker.css">
<link rel="stylesheet" href="js/colorbox-master/example1/colorbox.css" />
<script src="js/colorbox-master/jquery.colorbox-min.js"></script>

<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">MIS SERVICIOS</h4> </div>
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
                                                        <label>USUARIO</label>
                                                        <select name="select" id="email" class='form-control'>
                       <<?php while($datos=mysqli_fetch_assoc($query)){  ?><option value=<?= $datos['email'] ?>><?php echo $datos['email']  ?></option>             
              <?php  }  ?>                   </select> </div>
                                                </div>
                                            </div>                                           
                                            <input type="button" name="buscar"  value="Buscar" class='btn btn-primary' id="buscar">
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
  
      $("#buscar").click(function(){
            var email=$("#email").val();         

             var datos='mis_servicios='+1+'&email='+email;

                if(email!=""){
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

                    alert("Por favor seleccione asesor");
                } 


      });

});


  
</script>  