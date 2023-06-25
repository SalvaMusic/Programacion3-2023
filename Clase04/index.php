<?php


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch($_POST['caso']) {  
        case ('alta'):
            require_once "./Ej_23/registro.php";
            break;
        default:
            echo "caso erroneo";
    }        
}



?>