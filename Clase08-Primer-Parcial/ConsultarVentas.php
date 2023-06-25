<?php
require_once './Venta.php';


$sabor = isset($_GET['Sabor']) ? $_GET['Sabor'] : null;
$usuario = isset($_GET['Email']) ? $_GET['Email'] : null;
$desde = isset($_GET['Desde']) ? $_GET['Desde'] : null;
$hasta = isset($_GET['Hasta']) ? $_GET['Hasta'] : null;
$vaso = isset($_GET['Vaso']) ? $_GET['Vaso'] : null;
$array = [];

switch($_GET['Filtro']){
    case 'Cantidad Vendida':
        $cantidad = Venta::getCantidadHeladosVendidos(newDate($desde));
        echo "Se vendieron " . $cantidad . " Helados.";
        break;
    case 'Usuario':
        $array = Venta::getListaVentas(null, null, $usuario, null, null);
        break;
    case 'Fechas':
        $array = Venta::getListaVentas(newDate($desde), newDate($hasta), null, null, null);
        usort($array, 'cmp');
        break;
    case 'Sabor':
        $array = Venta::getListaVentas(null, null, null, $sabor, null);
        break;  
    case 'Vaso':
        $array = Venta::getListaVentas(null, null, null, null, $vaso);
        break;

}

foreach ($array as $v){
    echo "| ".$v . " |\n " ;
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