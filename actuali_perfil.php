<?php
//include('includes/dependencia/conexion.php');
date_default_timezone_set('America/Bogota');
//echo "valor: ".$_SESSION['cod_usuario'];
if(isset($_SESSION['cod_usuario'])){
      // Agregamos archivo....
date_default_timezone_set('America/Bogota');
$fecha_actual= date('Y-m-d');

$fecha_registro= date('d-m-Y H:m:s');

$sql="select * from usuarios where cod_usuario='".$_SESSION['cod_usuario']."' " ;
$query=pg_query($conexion, $sql);
$datos=pg_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="img/suyo_colombia_img.jpg">
    <title>Actualización de perfil</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/megna-dark.css" id="theme" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
     <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>


<script src="js/charts/js/highcharts.js"></script>
<script src="js/charts/js/modules/exporting.js"></script>
</head>

<body >       
<section id="wrapper">
  <div>
    <div class="white-box">

 <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ACTUALIZACIÓN DE PERFIL</h4> </div>
                </div>  
                 <div class="form-group">
                      <div class="col-xs-12 text-center">
                        <div class="user-thumb text-center"> <img alt="thumbnail" class="img-circle" width="100" src="<?php echo $_SESSION['imagen'] ?>">
                          <h3> <?php echo $_SESSION['email']  ?></h3>
                        </div>
                      </div>

                  <div class="col-xs-12 text-center">
                      <input type="button" name="button" id="actualizar" class="btn btn-primary" value="ACTUALIZAR">   
                  </div>

                <b>NOTA</b> LOS CAMPOS CON ASTERÍSCOS (*) SON OBLIGATORIOS

        </div>           
                 <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12">DATOS PERSONALES</label>
                                            <label class="col-sm-12"><hr></hr></label>
                                        </div>   

                                         <div class="form-group">
                                            <label class="col-sm-12">(*) IDENTIFICACIÓN</label>
                                              <div class="col-xs-12">          
                     <input class="form-control" type="number" value="<?php echo $datos['id_usuario'] ?>" id='id_usuario'  placeholder="Introduzca su identificación">
                                                          </div>
                                        </div>  

                                        <div class="form-group">
                                            <label class="col-sm-12">(*) NOMBRE</label>
                                              <div class="col-xs-12">          
                     <input class="form-control" type="text"  id='nombre' value="<?php echo $datos['nombre'] ?>"  placeholder="Introduzca su nombre completo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12">(*) APELLIDOS</label>
                                              <div class="col-xs-12">          
                     <input class="form-control" type="text" value="<?php echo $datos['apellidos'] ?>"  id='apellidos'  placeholder="Introduzca sus apellidos" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                                          </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12">PROFESIÓN</label>
                                              <div class="col-xs-12">          
                     <input class="form-control" type="text"  id='profesion' value="<?php echo $datos['profesion'] ?>"  placeholder="Introduzca profesion" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                                          </div>
                                        </div>
                                       
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-6">
                        <div class="white-box p-l-20 p-r-20">
                             <div class="row">
                                <div class="col-md-12">
                                    <form class="form-material form-horizontal">
                                        
                                         <div class="form-group">
                                            <label class="col-sm-12">DATOS DE CONTACTO</label>
                                            <label class="col-sm-12"><hr></hr></label>
                                         </div>   

                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">(*)DIRECCIÓN DE CASA</span></label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?php echo $datos['direccion_casa'] ?>"  placeholder="Introduzca direccion de casa" class="form-control form-control-line" id="direccion_casa" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"> </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-md-12"><span class="help">(*)CORREO ELECTRÓNICO ALTERNATIVO</span></label>
                                            <div class="col-md-12">
                                                <input type="email" required="required" value="<?php echo $datos['correo_alt'] ?>"  class="form-control form-control-line"  placeholder="Introduzca correo electrónico alternativo" id="correo_alt" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">(*) TELÉFONO DE CASA</span></label>
                                            <div class="col-md-12">
                                                <input type="number" value="<?php echo $datos['telefono_casa'] ?>"  placeholder="Introduzca telefono casa" class="form-control form-control-line" id="telefono_casa" > </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><span class="help">(*) TELÉFONO (MÓVIL)</span></label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?php echo $datos['telefono_1'] ?>"   placeholder="Introduzca teléfono móvil" class="form-control form-control-line" id="telefono_movil"> </div>
                                        </div>

                                          
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
  </div>
</section>

    <
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script> 

   <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
  

    <script type="text/javascript">
   
        $(document).ready(function(){

$("#id_usuario").focus();
            
          $("#actualizar").click(function(){

              var id_usuario=$("#id_usuario").val();
              var nombre=$("#nombre").val();
              var apellidos=$("#apellidos").val();
              var profesion=$("#profesion").val();
              var direccion_casa=$("#direccion_casa").val();
              var telefono_casa=$("#telefono_casa").val();
              var telefono_movil=$("#telefono_movil").val();
              var correo_alt=$("#correo_alt").val();

              var datos='g_user='+1+'&acuali_perfil='+1+'&id_usuario='+id_usuario+'&nombre='+nombre+'&apellidos='+apellidos+'&profesion='+profesion+'&direccion_casa='+direccion_casa+'&telefono_casa='+telefono_casa+'&telefono_1='+telefono_movil+'&correo_alt='+correo_alt;

                      if(id_usuario!="" && id_usuario!="" && nombre!="" && apellidos!="" && profesion!="" && direccion_casa!="" && telefono_movil!="" && telefono_casa!="" && correo_alt!="" ){

                            $.ajax({  
                              type: "POST",
                              url: "includes/php/g_procesos.php",
                              data: datos,
                              success: function(valor){
                                    if(valor==1)
                                       parent.location='portal.php';
                                  //  parent.location='doble_auth.php';
                                    else if(valor==2)
                                      alert("Ocurrió un problema interno, por favor comunícate con el administrador");
                              }
                            });

                      }else{
                      alert("Por favor completa todos los campos con asteríscos (*)");
                      $("#id_usuario").focus();
                    }

          });

          

        });
    </script>
</body>

</html>
<?php
}else
echo "Tu sesión ha cacudado por tiempo sin actividad, haga clic en el siguiente enlace para volver a iniciar sesión";

?>