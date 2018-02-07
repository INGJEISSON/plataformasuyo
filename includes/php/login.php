<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="img/suyo_colombia_img.jpg">
<title>Plataforma Suyo (Beta)</title>
<!-- Bootstrap Core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="css/colors/blue.css" id="theme"  rel="stylesheet">
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">

  <div class="login-box login-sidebar">
     <br> <br> 
    <div class="white-box">
      <form class="form-horizontal form-material" id="loginform" action="index.html">
        <a href="javascript:void(0)" class="text-center db"><img src="img/suyo_colombia_img.jpg" width="264" height="164" alt="Home" /></a>  
        
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
          <a class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" href='<?php echo $authUrl  ?>'>Log In</a>
          </div>
        </div>

        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
          <a class="btn btn-blue btn-lg btn-block text-uppercase waves-effect waves-light" id="acces_exter">Usuarios externos</a>
          </div>
        </div>
       
        <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
            <p>Descargue e instale Suyo Security</p>
            <a href='http://bit.ly/2EATvMJ'>DESCARGAR AQUÍ</a>
             <img src='img/qr_suyosecurity.png'>
          </div>
        </div>
      </form>


       <form class="form-horizontal form-material" id="login_externo">
            <a href="javascript:void(0)" class="text-center db"><img src="img/suyo_colombia_img.jpg" width="264" height="164" alt="Home" /></a>
            <br><br><br>
            <div class="form-group text-center m-t-20">
                  <div class="col-xs-12">
                       <label>CORREO ELECTRÓNICO: </label>
                       <input type="text" class="form-control"  id="user" />
                  </div>
                  
            </div>   
            <div class="form-group text-center m-t-20">
                   <div class="col-xs-12">
                    <label>CONTRASEÑA: </label>
                        <input type="text"  id="clave" class="form-control" type="password" />
                  </div>                  
            </div>   

             <a class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" id="ingresar">Log In</a>

             <div class="col-xs-12">
          <a class="btn btn-blue btn-lg btn-block text-uppercase waves-effect waves-light" id="acces_suyo">Usuarios (SUYO)</a>
          </div>

      </form>
      
    </div>
  </div>
</section>
<!-- jQuery -->
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
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
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
<script type="text/javascript">
  
    $(document).ready(function(){

            $("#acces_exter").click(function(){

                  $("#loginform").hide();
                  $("#login_externo").show();

            });

             $("#acces_suyo").click(function(){

                  $("#loginform").show();
                  $("#login_externo").hide();

            });

            $("#ingresar").click(function(){

                    var clave=$("#clave").val();
                    var user=$("#user").val();
                    var datos='login='+1+'&calve='+clave+'&user='+user;
                    if(clave=!"" && user!=""){
                       $.ajax({    
                            type: "POST",
                            data: datos,
                            url: "includes/php/g_procesos.php",
                            success: function(valor){
                                  if(valor==1)
                                    parent.location='';
                                  else
                                    alert("Usuario y contrsaseña inválidos");
                            }

                          });

                    }else{
                      alert("Por favor ingrese correo electrónico y contraseña");
                    }
                         

            });

    });


</script>