<?php
require_once './Heladeria.php';
require_once './Venta.php';

$email = $_POST['Email'];
$sabor = $_POST['Sabor'];
$tipo = $_POST['Tipo'];
$vaso = $_POST['Vaso'];
$cantidad = $_POST['Stock'];
$imagen = $_FILES['Imagen'];

$stock = Heladeria::getStock($sabor, $tipo);

if($stock == null){
    echo "No existe el tipo o el sabor";
} else if ($cantidad > $stock){
    echo "La cantidad solicitada supera al stock disponible (". $stock . ").";
} else {
    $venta = new Venta($email, $sabor, $tipo, $vaso, $cantidad, new DateTime());
    $venta->guardarVenta();
    $venta->guardarFoto($imagen);
    Heladeria::restarStock($sabor, $tipo, $cantidad);
    echo " Venta realizada con Exito!.";
}