<?php
include('../dependencia/conexion.php');
    
     if($_SESSION['cod_usuario']==1)
    $sql="select * from ciudad_asesor ";
    else
    $sql="select * from ciudad_asesor where asesor='".$_SESSION['email']."' ";
    
    $query=mysqli_query($conexion, $sql); 
?>
<link rel="stylesheet" href="js/colorbox-master/example1/colorbox.css" />
<script src="js/colorbox-master/jquery.colorbox-min.js"></script>

<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">MIS AGENDAS</h4> </div>
                </div>
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                        
                                        <div class="form-group">
                                            <label class="col-sm-12">ASESOR</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="asesor">
                                                    <option value="">Seleccione</option>
                       <?php while($datos=mysqli_fetch_assoc($query)){  ?><option value=<?= $datos['asesor'] ?>><?php echo $datos['asesor']  ?></option>                         
                            <?php  }  ?>          

                                                </select>
                                            </div>
                                        </div>
                                       <input type="button" name="buscar"  value="Buscar "class='btn btn-primary' id="buscar">
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
            var asesor=$("#asesor").val();         

             var datos='gene_agend_asesor='+1+'&asesor='+asesor;

                if(asesor!=""){
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