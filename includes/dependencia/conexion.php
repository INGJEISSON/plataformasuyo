<?php
session_start();
if($_SERVER['REMOTE_ADDR']=='http://localhost/plataformasuyo/index.php')
$conexion=mysqli_connect("localhost","root","", "plataformasuyo");
elseif($_SERVER['REMOTE_ADDR']=='http://platform.suyo.io/index.php')
$conexion=mysqli_connect("bdplatform.c7wzmctni82t.us-west-2.rds.amazonaws.com:3306","as_suyoplatf", "s.col2017qkuk", "suyoplataf");