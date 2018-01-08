<?php
include('../../../dependencia/conexion.php');
header('Access-Control-Allow-Origin: *'); 
date_default_timezone_set('America/Bogota');
$fecha_registro=date('Y-m-d H:m:s');
$fecha_filtro=date('Y-m-d');
// Registramos dispositivo 
	if(isset($_POST['regisid'])){

				if(isset($_POST['consultar'])){

							$sql="select * from device_user where suyo_key_mb='".$_POST['suyo_key_mb']."' and confir=0 ";
							$query=pg_query($conexion, $sql);
							$rows=pg_num_rows($query);

									if($rows==1){
									echo "1";							
									}	
									else
										echo "2";

				}

				if(isset($_POST['confirmar'])){

							 $sql="select * from device_user where suyo_key_mb='".$_POST['suyo_key_mb']."' and confir=0 ";
							$query=pg_query($conexion, $sql);
							$rows=pg_num_rows($query);


									if($rows==1){ // COnfirmarmos identidad
										$datos=pg_fetch_assoc($query);

												$update2="update device_user set confir=1, fecha_confir='".$fecha_registro."' where suyo_key_mb='".$_POST['suyo_key_mb']."' ";
												$queryw=pg_query($conexion, $update2);
														if($queryw){

															// Verificamos que el código generado sea el correcto
													                    $sql="select * from doble_auth where cod_usuario='".$datos['cod_usuario']."' and fecha_filtro='".$fecha_filtro."' and cod_estado=3  ";
													                    $query=pg_query($conexion, $sql);
													                    $rows=pg_num_rows($query);

													                        if(isset($rows)){
													                         // $_SESSION['doble_auth']=$_POST['clave_auth'];
													                         echo  "1";
													                            $sql="update  doble_auth set cod_estado=4 where cod_usuario='".$datos['cod_usuario']."' and fecha_filtro='".$fecha_filtro."'  ";
													                          $query=pg_query($conexion, $sql);
													                          $rows=pg_num_rows($query);
													                        }
														}
														else
															echo "2";
									}	
									else
										echo "22";

				}
				if(isset($_POST['matricular'])){

							if(isset($_POST['token_security'])){ // si encuentra el token de securidad	
										
									if(is_numeric($_POST['token_security'])){ // verificamos que sea un número

											// Consultamos el token a qué usuario pertenece..
										 	 $sql="select cod_usuario from doble_auth where clave='".$_POST['token_security']."' and cod_estado=3 limit 1 ";
											$query=pg_query($conexion, $sql);
											$rows=pg_num_rows($query);
													if($rows==1){
														$datos=pg_fetch_assoc($query);
																// Consultamos que no haya registrado dispostivo..
														 $sql="select * from device_user where cod_usuario='".$datos['cod_usuario']."' ";
														 $query=pg_query($conexion, $sql);
														 $rows=pg_num_rows($query);
														 		if($rows==0){	
														 			// INsertamos dispostivo del usuario
														 			  $insert="insert into device_user (cod_usuario, suyo_key_mb, platform, version, model, fecha_registro, confir, fecha_solic) values('".$datos['cod_usuario']."', '".$_POST['suyo_key_mb']."','".$_POST['platform']."', '".$_POST['version']."', '".$_POST['model']."','".$fecha_registro."', 0, '".$fecha_registro."') ";
														 				$query_insert=pg_query($conexion, $insert);

														 					if($query_insert)
														 						echo "exito";
														 					else
														 						echo "error"; // Problema técnico..
														 		}else
														 		echo "Usted ya tiene un dispostivo de celular registrado, por favor ingrese con su dispostivo original para autenticarse ";


													}
									}


							}

				}

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