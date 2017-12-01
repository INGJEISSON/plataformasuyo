<?php
session_start();
//$remote_host="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
/*$remote_host="http://".$_SERVER['HTTP_HOST'];
//echo $_SERVER['HTTP_HOST'];
if($remote_host=='http://localhost')
$conexion=mysqli_connect("localhost","root","", "plataformasuyo");
elseif($remote_host=='http://platform.suyo.io')
$conexion=mysqli_connect("bdplatform.c7wzmctni82t.us-west-2.rds.amazonaws.com:3306","as_suyoplatf", "s.col2017qkuk", "suyoplataf");*/
$host="bdplataforma.c7wzmctni82t.us-west-2.rds.amazonaws.com";
$user="as_suyoplatf";
$pass="s.col2017qkuk";
$dbname="platfsuyo";
$conexion = pg_connect("host=$host dbname=$dbname user=$user password=$pass");

/*if(isset($conexion))
	echo "si";
else
	echo "no";
*/
$sql="select * from usuarios";
$query=pg_query($conexion, $sql);
$rows=pg_num_rows($query);
		
		if($rows){
			while($datos=pg_fetch_assoc($query)){
				echo $datos['nombre'];
			}
			echo $rows;
		}
/*
// INsertamos registro..

$sql2="insert into usuarios (cod_usuario, nombre, apellidos, tipo_usuario, email, cod_estado) values(83, 'Jeisson5', 'Maturana', 1, 'perrio@gmail.com', 1)";
$query=pg_query($conexion, $sql2);
if($query)
	echo "yes";
else
	echo "no";*/