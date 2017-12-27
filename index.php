<?php
require_once __DIR__.'/authgoogle/vendor/autoload.php';
const CLIENT_ID = '449674911638-afs89gdh2nf1aqoetb29g64n7ju61vrr.apps.googleusercontent.com';
const CLIENT_SECRET = 'wGp9d1IFsW4EIZ_pTkJ6Q0Nz';
const REDIRECT_URI = 'http://platform.suyo.io/index.php';
include('includes/dependencia/conexion.php');

date_default_timezone_set('America/Bogota');
$fecha_registro=date('Y-m-d H:mm:ss');
$fecha_filtro=date('Y-m-d');
//include('browser_class_inc.php');

/*$br = new browser();
$br->whatBrowser();
$version = $br->version;
$navegador = $br->browsertype;
$platform = $br->platform;*/


$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setScopes('email');

$plus = new Google_Service_Plus($client);

if (isset($_REQUEST['logout'])) {
   session_unset();
}
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if(isset($_SESSION['cod_usuario'])){

}
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $me = $plus->people->get('me');
  // Get User data
  $id = $me['id'];
  $name =  $me['displayName'];
  $email =  $me['emails'][0]['value'];
  $profile_image_url = $me['image']['url'];
  $cover_image_url = $me['cover']['coverPhoto']['url'];
  $profile_url = $me['url'];


  function generar_clave(){
    $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $su = strlen($an) - 1;
    return substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1);
}
                          
                          $sql="Select usuarios.telefono_1, usuarios.email,tipo_usuario.tipo_usuario, usuarios.cod_estado, usuarios.cod_usuario, tipo_usuario.cod_grupo from usuarios, tipo_usuario where usuarios.tipo_usuario=tipo_usuario.tipo_usuario and  usuarios.email='".$email."' ";
                        $query=pg_query($conexion, $sql);
                        $rows=pg_num_rows($query);
                        $datos=pg_fetch_assoc($query);
                                if(isset($rows)){

                                $_SESSION['nombre']=$name;
                                $_SESSION['email']=$email;
                                $_SESSION['tipo_usuario']=$datos['tipo_usuario']; 
                                $_SESSION['imagen']=$profile_image_url;
                                $_SESSION['cod_usuario']=$datos['cod_usuario'];                                
                                $_SESSION['cod_grupo']=$datos['cod_grupo'];
                                $_SESSION['telefono']=$datos['telefono_1'];

                                      // Generamos la clave de doble autotenticación.

                                 /* $sql2 ="select * from doble_auth where cod_usuario='".$_SESSION['cod_usuario']."' and fecha_filtro='".$fecha_filtro."' and cod_estado=3 ";
                                   $query2=pg_query($conexion, $sql2);
                                   $rows2=pg_num_rows($query2);
                                            
                                        if($rows2==0){ // Si no ha encontrado entonces genere clave

                                          for ($i = 0; $i < 100; $i++)
                                            $clave=generar_clave();

                                                $insert="insert into doble_auth (cod_usuario, fecha_gene, fecha_filtro, ip, peticion, clave, cod_estado) values('".$_SESSION['cod_usuario']."', '".$fecha_registro."', '".$fecha_filtro."', '".$_SERVER["REMOTE_ADDR"]."','sms', '".$clave."', 3) ";
                                                $query_insert=pg_query($conexion, $insert);

                                                    if($query_insert){ // Enviamos sms al celular..
                                                           

                                                              $telefono="57".$_SESSION['telefono'];                       
                                                              $mensaje="Su código de doble autenticación es: ".$clave;

                                                              $url = 'https://api.hablame.co/sms/envio/';
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
                                                              $context  = stream_context_create($options);
                                                              $result = json_decode((file_get_contents($url, false, $context)), true);

                                                              if ($result["resultado"]===0) {
                                                               // $access=1; // Acceso permitido..

                                                                //print 'Se ha enviado el SMS exitosamente';

                                                              } else {
                                                                print 'ha ocurrido un error!!';
                                                              }

                                                    }
                                        }*/
                                 
                                    $access=1; // Acceso permitido..
                               
                                }else
                                $access=2; // Acceso denegado*/
                                
                                

} else {
  $authUrl = $client->createAuthUrl();
}

?>
    <?php
    if (isset($authUrl)) {
       include('includes/php/login.php');
    } else {
        //include('includes/php/login.php');
               if(isset($access)==1) // Si es un usuario habilitado..
                include('includes/php/redirect.php');
                else{
                     session_unset();
                     include('includes/php/login.php');
                
                    
                }
    }
?>