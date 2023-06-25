<?php
require_once './Modelo/Pizza.php';

$sabor = $_GET['Sabor'];
$precio = $_GET['Precio'];
$tipo = $_GET['Tipo'];
$cantidad = $_GET['Cantidad'];

$pizza = new Pizza($sabor, $precio, $tipo, $cantidad);
$pizza->guardarPizza();