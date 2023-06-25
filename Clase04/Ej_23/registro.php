<?php

require_once 'Usuario.php';

$registrationDate = new DateTime();
$registrationDate->format('Y-m-d');
$fileName = $_FILES["foto"]["name"];
$tempFileName = $_FILES["foto"]["tmp_name"];
$userName = $_POST['nombre'];
$pass = $_POST['pass'];
$email = $_POST['email'];
$id = rand(0, 999999);
//creo el nombre del destino concatenando la extencion
$destino = "/Usuario/Fotos/" . $fileName;
$user = new Usuario($userName, $pass, $email, $registrationDate, $id, $destino);
$user->guardarUsuario();
$user->guardarFoto($tempFileName, $destino);