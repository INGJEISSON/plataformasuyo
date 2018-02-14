 <?php

/*$string="Jeisson_Ibarguen_Maturana_1077448820";
 //echo hash('sha256', $string );

 echo 'SHA-256:      ' . crypt('rasmuslerdorf', '$5$rounds=5000$usesomesillystringforsalt$') . "\n";*/
 //echo crypt_sha512("$Jei", "Jeisson_Ibarguen_Maturana_1077448820");

 if($_POST['b_archivo']){

 	$ruta='procesados/'.$_POST['id_fasfield']

 }
//include('/procesados/14e68af9-268b-44d9-b9e0-3b77f9d66ec9/');
   $ficheros  = scandir($ruta,1);  // Listar archivos y los insertamos...

   	include('visualizar.php');

 ?>