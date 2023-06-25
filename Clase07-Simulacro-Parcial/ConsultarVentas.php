<?php
require_once './Modelo/Venta.php';


$sabor = isset($_GET['Sabor']) ? $_GET['Sabor'] : null;
$usuario = isset($_GET['Email']) ? $_GET['Email'] : null;
$desde = isset($_GET['Desde']) ? $_GET['Desde'] : null;
$hasta = isset($_GET['Hasta']) ? $_GET['Hasta'] : null;

if($desde == null && $hasta == null && $usuario == null && $sabor == null){
    $cantidad = Venta::getCantidadPizzasVendidas();
    echo "Se vendieron " . $cantidad . " Pizass.";
} else {
    $array = Venta::getListaVentas(newDate($desde), newDate($hasta), $usuario, $sabor);
    if($desde != null || $hasta != null){
        $array = new ArrayObject($array);       
        $array->uasort('cmp');
    }
    foreach ($array as $v){
        echo $v . " |||||||||||||||||| " ;
    }
}

function cmp($a, $b) {
    if ($a->_sabor == $b->_sabor) {
        return 0;
    }
    return ($a->_sabor < $b->_sabor) ? -1 : 1;
}

function newDate($fecha){
    $date = DateTime::createFromFormat('d/m/Y', $fecha);
    return $date == false ? null : $date;
}