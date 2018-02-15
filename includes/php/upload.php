<?php
include('../dependencia/conexion.php');

// COnsultamos el nombre de la carpeta
$sql="select * from categorias_docu where id_cate_docu='".$_GET['id_cate_docu']."' ";
$query=pg_query($conexion, $sql);
$datos=pg_fetch_assoc($query);

$sql2="select * from documentacion where cod_cliente='".$_GET['cod_cliente']."' ";
$query2=pg_query($conexion, $sql2);
$datos2=pg_fetch_assoc($query2);
$rows2=pg_num_rows($query2);


		if(isset($rows2)){
 $carpeta_cliente=$datos2['usr_codif'];
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php
// A list of permitted file extensions
$allowed = array('doc', 'docx', 'pdf', 'jpeg', 'jpg', 'png', 'mp4', '3gp');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
    $ruta=($_FILES['upl']['name']);

    $ruta1='../files/clientes/'.$carpeta_cliente.'/'.$datos['descripcion'].'/'.$ruta;
	if(move_uploaded_file($_FILES['upl']['tmp_name'], $ruta1)){

		echo '{"status":"success"}';
						
			$sql = "SELECT ruta FROM detalle_docu WHERE  ruta='".$ruta."'  and id_cate_docu='".$_GET['id_cate_docu']."' and cod_cliente='".$_GET['cod_cliente']."' ";
					$query=pg_query($conexion, $sql);
					$datos=pg_fetch_assoc($query);
					$reg=pg_num_rows($query);
				    
				      $ruta2=utf8_decode($_FILES['upl']['name']);
				 		//Eliminamos la foto anterior....
				 	if($reg){
				 		$archivo_original=($datos['ruta']);
				 	 $ruta1='../files/clientes/'.$carpeta_cliente.'/'.$datos['descripcion'].'/'.$archivo_original;
					$ruta_img=$ruta1;
					unlink($ruta_img); //borro la imagen
					
					 $qry = "UPDATE detalle_docu SET ruta='".$ruta."' where cod_cliente='".$_GET['cod_cliente']."' and id_cate_docu='".$_GET['id_cate_docu']."'  ";
					}else{
					  $qry = "insert into detalle_docu (id_cate_docu, cod_cliente, cod_usuario, cod_estado, ruta) values('".$_GET['id_cate_docu']."', '".$_GET['cod_cliente']."', '".$_SESSION['cod_usuario']."', 3, '".$ruta."')";
					}
					

									$sube=pg_query($conexion,  $qry);
									if(isset($sube)){
										echo $_SESSION['nom_archivo']=$ruta;
										echo "1";
									}
									
									else
									echo "2";
						
						exit;
	}
}

		echo '{"status":"error"}';
		exit;

}else
echo "Usuario NO identificado";