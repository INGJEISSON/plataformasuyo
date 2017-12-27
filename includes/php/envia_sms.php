<?php 
$telefono="57".$_SESSION['telefono'];
$clave=$_SESSION['clave_auth'];
$mensaje="Su código de doble autenticación es: ".$clave;

$url = 'https://api.hablame.co/sms/envio/';
$data = array(
	'cliente' => 10010002, //Numero de cliente
	'api' => 'uhvw8MkY3oaIlRDeJxKjzWVKJcq', //Clave API suministrada
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

	echo $_SESSION['doble_auth']=1;

	//print 'Se ha enviado el SMS exitosamente';

} else {
	print 'ha ocurrido un error!!';
}

print '<pre>';
print_r ($result);		

?>