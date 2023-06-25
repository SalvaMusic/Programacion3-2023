<?php
require_once './Venta.php';
require_once './Heladeria.php';


$pedido = $_GET['Pedido'] ;
$usuario = isset($_GET['Email']) ? $_GET['Email'] : null;
$sabor = isset($_GET['Sabor']) ? $_GET['Sabor'] : null;
$tipo = isset($_GET['Tipo']) ? $_GET['Tipo'] : null;
$cantidad = isset($_GET['Cantidad']) ? $_GET['Cantidad'] : null;
$vaso = isset($_GET['Vaso']) ? $_GET['Vaso'] : null;
$modificar = true;

if (is_numeric($cantidad)){
    $cantidad = intval($cantidad);
    $venta = Venta::getVenta($pedido);
    $restarStock = $cantidad - $venta->_stock;
    if($restarStock > 0){
        $stockRestante = Heladeria::getStock($sabor, $tipo);
        if($stockRestante == null || $restarStock > $stockRestante){
            echo "La cantidad solicitada supera al stock disponible (". $venta->_stock + $stockRestante . ").";
            $modificar = false;
        } 
    }
} else { 
    $modificar = false;
}


if ($modificar == true){
    $venta->_sabor = $sabor;
    $venta->_email = $usuario;
    $venta->_tipo = $tipo;
    $venta->_vaso = $vaso;
    $venta->_stock = $cantidad;
    $venta->guardarVenta();
    
    Heladeria::restarStock($sabor, $tipo, $restarStock);
    echo "Venta Modificada con Exito!.";
} else { 
    echo "No se puede modificar";
}
