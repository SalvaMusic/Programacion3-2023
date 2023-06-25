<?php
require_once './Modelo/Pizza.php';

$sabor = $_POST['Sabor'];
$tipo = $_POST['Tipo'];

$stock = Pizza::getStock($sabor, $tipo);

if($stock != null){
    echo "Si Hay";
} else {
    echo "No existe el tipo o el sabor";
}