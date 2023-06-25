<?php
require_once './Modelo/Pizza.php';
require_once './Modelo/Venta.php';

$email = $_POST['Email'];
$sabor = $_POST['Sabor'];
$tipo = $_POST['Tipo'];
$cantidad = $_POST['Cantidad'];
$imagen = $_FILES['Imagen'];

$stock = Pizza::getStock($sabor, $tipo);

if($stock == null){
    echo "No existe el tipo o el sabor";
} else if ($cantidad > $stock){
    echo "La cantidad solicitada supera al stock disponible (". $stock . ").";
} else {
    $venta = new Venta($email, $sabor, $tipo, $cantidad, new DateTime());
    $venta->guardarVenta();
    $venta->guardarFoto($imagen);
    Pizza::restarStock($sabor, $tipo, $cantidad);
    echo " Venta realizaca con Exito!.";
}