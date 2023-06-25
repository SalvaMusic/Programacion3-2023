<?php

include "Auto.php";

$renaultUno = new Auto("Renault", "Negro");
$renaultDos = new Auto("Renault", "Rojo");
$mercedesUno = new Auto("Mercedes", "Gris", 6500000.00);
$mercedesDos = new Auto("Mercedes", "Gris", 8500000.00);
$fiat = new Auto("Fiat", "Gris", 8500000.00, '2000-01-01');

$mercedesUno->agregarImpuestos(1500.00);
$mercedesDos->agregarImpuestos(1500.00);
$fiat->agregarImpuestos(1500.00);

$importeSumado = Auto::add($renaultUno, $renaultDos);

echo "Importe Sumado: ". $importeSumado."<br>";

if($renaultUno->equals($renaultDos)){
    echo "Renault Uno es igual a Renault Dos.<br>";
} else {
    echo "Renault Uno NO es igual a Renault Dos.<br>";
}

if($renaultUno->equals($fiat)){
    echo "Renault Uno es igual a Fiat.<br>";
} else {
    echo "Renault Uno NO es igual a Fiat.<br>";
}

Auto::MostrarAuto($renaultUno);
Auto::MostrarAuto($mercedesUno);
Auto::MostrarAuto($fiat);