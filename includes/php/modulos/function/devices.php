<?php
include('../../../dependencia/conexion.php');
header('Access-Control-Allow-Origin: *'); 

// Registramos dispositivo 
	if(isset($_POST['regisid'])){

				if(isset($_POST['salvar'])){

						// Verificamos que no esté registrado en ningun otro usuario..
						$sql="select userid from device_user where userid='".$_POST['ids_userId']."' ";
						$query=pg_query($conexion, $sql);
						$rows=pg_num_rows($query);

								if($rows==0){
									// Insertamos dispostivo del usuario.
									$insert="insert into device_user (userid, telefono) values('".$_POST['ids_userId']."', '".$_POST['telefono']."') ";
									$query=pg_query($conexion, $insert);
											if($query)
												echo "1"; // Registro completo
											else
												echo "2";

								}else
								echo "3";

				}
				if(isset($_POST['update'])){ // Actualizamos dispostivo del usuario..


				}

	}