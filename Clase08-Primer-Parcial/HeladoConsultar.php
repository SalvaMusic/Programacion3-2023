<?php
require_once './Heladeria.php';

$sabor = $_POST['Sabor'];
$tipo = $_POST['Tipo'];

$stock = Heladeria::getStock($sabor, $tipo);

if($stock != null){
    echo "Existe";
} else {
    echo "No existe el tipo o el sabor";
}