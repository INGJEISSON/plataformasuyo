<?php
include('includes/dependencia/conexion.php');
date_default_timezone_set('America/Bogota');
echo "valor: ".$_SESSION['cod_usuario'];
if(isset($_SESSION['cod_usuario'])){

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
    <title>Doble Autenticación</title>
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
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>   


<script src="js/charts/js/highcharts.js"></script>
<script src="js/charts/js/modules/exporting.js"></script>
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
   <div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
  <div class="login-box">
    <div class="white-box">
      <form class="form-horizontal form-material" id="loginform" action="index.html">
        
        <div class="form-group">
          <div class="col-xs-12 text-center">
            <div class="user-thumb text-center"> <img alt="thumbnail" class="img-circle" width="100" src="<?php echo $_SESSION['imagen'] ?>">
              <h3><?php echo $_SESSION['nombre'] ?><br> <?php echo $_SESSION['email']  ?></h3>
            </div>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
          Se ha enviado un código de doble autenticación a su número de celular, por favor digítelo a continuación<br><br>
            <input class="form-control" type="text"  id='clave_auth' required="" placeholder="Introduzca código">
          </div>
        </div>
        <div class="form-group text-center">
          <div class="col-xs-12">
            <button class="btn btn-info  btn-block text-uppercase waves-effect waves-light" type="submit" id="ingresar_auth">Ingresar</button> 
            <button class="btn btn-warning  btn-block text-uppercase waves-effect waves-light" id="r_sms">Re-enviar código</button>
          </div>
        </div>
      </form>
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

    <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
  

    <script type="text/javascript">
   
        $(document).ready(function(){

            $("#ingresar_auth").click(function(){
                var clave_auth=$("#clave_auth").val();
                var datos='ingresar_auth='+1+'&clave_auth='+clave_auth;

                  $.ajax({
            
                        type: "POST",
                        data: datos,
                        url: 'includes/php/g_procesos.php',
                        success: function(valor){
                           
                               if(valor==1)
                               parent.location='index.php';
                               else
                               alert("No se pudo cerrar sesi杌妌, contacte con el administrador");
                        }
                  });


            });

            $("#r_sms").click(function(){ 

             
            });

            $("#logout").click(function(){
                
                var datos='logout='+1;
                     $.ajax({
            
                        type: "POST",
                        data: datos,
                        url: 'includes/php/logout.php',
                        success: function(valor){
                           
                               if(valor==1)
                               parent.location='index.php';
                               else
                               alert("No se pudo cerrar sesi杌妌, contacte con el administrador");
                        }
                  });
                
            });



        });
    </script>
</body>

</html>
<?php
}else
echo "Tu sesión ha cacudado por tiempo sin actividad, haga clic en el siguiente enlace para volver a iniciar sesión";

?>