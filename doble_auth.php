<?php
include('includes/dependencia/conexion.php');
date_default_timezone_set('America/Bogota');
//echo "valor: ".$_SESSION['cod_usuario'];
if(isset($_SESSION['cod_usuario'])){
      // Agregamos archivo....
date_default_timezone_set('America/Bogota');
$fecha_actual= date('Y-m-d');

$fecha_registro= date('d-m-Y H:m:s');

function generar_clave(){
    $an = "0123456789";
    $su = strlen($an) - 1;
    return substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1);
}

  // Generamos la clave de doble autotenticación.

                             $sql2 ="select * from doble_auth where cod_usuario='".$_SESSION['cod_usuario']."' and fecha_filtro='".$fecha_actual."' and cod_estado=3 ";
                                   $query2=pg_query($conexion, $sql2);
                                   $rows2=pg_num_rows($query2);
                                            
                                        if($rows2==0){ // Si no ha encontrado entonces genere clave

                                          for ($i = 0; $i < 4; $i++)
                                            $clave=generar_clave();

                                                $insert="insert into doble_auth (cod_usuario, fecha_gene, fecha_filtro, ip, peticion, clave, cod_estado) values('".$_SESSION['cod_usuario']."', '".$fecha_registro."', '".$fecha_actual."', '".$_SERVER["REMOTE_ADDR"]."','sms', '".$clave."', 3) ";
                                                $query_insert=pg_query($conexion, $insert);

                                                    if($query_insert){ // Enviamos sms al celular..
                                                           

                                                                $telefono="57".$_SESSION['telefono'];                       
                                                                $mensaje=$_SESSION['nombre'].", su token de seguridad es: ".$clave;
                                                                $curl = curl_init();
                                                                $from="Suyo Colombia";
                                                                $number=$telefono;
                                                                $msg=$mensaje;
                                                                $_SESSION['clave_auth2']=$clave;


                                                                curl_setopt_array($curl, array(
                                                                  CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
                                                                  CURLOPT_RETURNTRANSFER => true,
                                                                  CURLOPT_ENCODING => "",
                                                                  CURLOPT_MAXREDIRS => 10,
                                                                  CURLOPT_TIMEOUT => 30,
                                                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                                  CURLOPT_CUSTOMREQUEST => "POST",
                                                                  CURLOPT_POSTFIELDS => "{ \"from\":\"$from\", \"to\":\"$number\", \"text\":\"$msg\" }",
                                                                  CURLOPT_HTTPHEADER => array(
                                                                    "accept: application/json",
                                                                    "authorization: Basic c3V5bzpKZWlzc29uMTk5MQ==",
                                                                    "content-type: application/json"
                                                                  ),
                                                                ));

                                                                $response = curl_exec($curl);
                                                                $err = curl_error($curl);

                                                                curl_close($curl);

                                                                if ($err) {
                                                               //   echo "cURL Error #:" . $err;
                                                                } else {
                                                                //  echo $response;
                                                                }

                                                              /*$url = 'https://api.hablame.co/sms/envio/';
                                                              $data = array(
                                                                'cliente' => 10010646, //Numero de cliente
                                                                'api' => 'IlHFpX4NJNt2UOOluEHC8oseMCmvKD', //Clave API suministrada
                                                                'numero' => $telefono, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
                                                                'sms' => $mensaje, //Mensaje de texto a enviar
                                                                'fecha' => '', //(campo opcional) Fecha de envio, si se envia vacio se envia inmediatamente (Ejemplo: 2017-12-31 23:59:59)
                                                                'referencia' => 'Suyo Colombia', //(campo opcional) Numero de referencio ó nombre de campaña
                                                              );

                                                              $options = array(
                                                                  'http' => array(
                                                                      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                                                      'method'  => 'POST',
                                                                      'content' => http_build_query($data)
                                                                  )
                                                              );
                                                              |$context  = stream_context_create($options);
                                                              $result = json_decode((file_get_contents($url, false, $context)), true);

                                                              if ($result["resultado"]===0) {
                                                               // $access=1; // Acceso permitido..

                                                                //print 'Se ha enviado el SMS exitosamente';

                                                              } else {
                                                                print 'ha ocurrido un error!!';
                                                              }*/

                                                    }
                                        }



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
      <div class="form-horizontal form-material" action="">
        
        <div class="form-group">
          <div class="col-xs-12 text-center">
            <div class="user-thumb text-center"> <img alt="thumbnail" class="img-circle" width="100" src="<?php echo $_SESSION['imagen'] ?>">
              <h3><?php echo $_SESSION['nombre'] ?><br> <?php echo $_SESSION['email']  ?></h3>
            </div>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
          Se ha enviado un token de seguridad de doble factor a su número de celular, por favor confirma en tu celular<br><br>
          
           <div class="col-xs-12" align="center">
        Esperando confirmación desde el dispostivo móvil<br><br>
          
          </div>
          </div>
        </div>

        <div class="form-group text-center">
          <div class="col-xs-12">           
            <button class="btn btn-warning  btn-block text-uppercase waves-effect waves-light" id="r_sms">Re-enviar token</button>
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
                               parent.location='index2.php';
                               else
                               alert("No se pudo cerrar sesi杌妌, contacte con el administrador");
                        }
                  });


            });

            $("#r_sms").click(function(){ 

                var datos='r_sms='+1;

                  $.ajax({
            
                        type: "POST",
                        data: datos,
                        url: 'includes/php/g_procesos.php',
                        success: function(valor){
                             alert("Clave ha sido reenviada a su número de teléfono");
                        }
                  });

             
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