<?php
session_start();
$remote_host="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if($remote_host=='http://localhost/plataformasuyo/index2.php')
$conexion=mysqli_connect("localhost","root","", "plataformasuyo");
elseif($remote_host=='http://platform.suyo.io/index.php')
$conexion=mysqli_connect("bdplatform.c7wzmctni82t.us-west-2.rds.amazonaws.com:3306","as_suyoplatf", "s.col2017qkuk", "suyoplataf");