<?php

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch($_GET['Operacion']){
            case 'ConsultarVentas': 
                require_once "./ConsultarVentas.php";
                break;
            default:
                require_once "./PizzaCarga.php";
                break;
        }
        break;
    case 'POST':
        switch($_POST['Operacion']){
            case 'Consulta': 
                require_once "./PizzaConsultar.php";
                break;
            case 'Venta':
                require_once "./AltaVenta.php";
                break;
        }
        break;
    default;
}

?>