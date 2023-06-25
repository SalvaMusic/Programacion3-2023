<?php

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch($_POST['Operacion']){
            case 'Alta': 
                require_once "./HeladeriaAlta.php";
                break;
            case 'Consulta': 
                require_once "./HeladoConsultar.php";
                break;
            case 'Alta Venta': 
                require_once "./AltaVenta.php";
                break;
            default:
                echo 'Operacion inválida';
        }
        
        break;
    case 'GET':
        switch($_GET['Operacion']){
            case 'ConsultasVentas':
                require_once "./ConsultarVentas.php";
                break;
        }
        break;
    case 'PUT':
        require_once "./ModificarVenta.php";
        break;
    default:
        echo 'Método no soportado.';
        break;


    
}

?>