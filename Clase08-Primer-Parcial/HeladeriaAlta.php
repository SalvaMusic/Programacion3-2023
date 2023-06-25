<?php
require_once './Heladeria.php';

$sabor = $_POST['Sabor'];
$precio = $_POST['Precio'];
$tipo = $_POST['Tipo'];
$vaso = $_POST['Vaso'];
$stock = $_POST['Stock'];
$imagen = $_FILES['Imagen'];

$heladeria = new Heladeria($sabor, $precio, $tipo, $vaso, $stock);
$heladeria->guardarHeladeria();
$heladeria->guardarImagen($imagen);