<?php

$vec = array("H","O","L","A");

echo "Array";
var_dump($vec);

function invert($vec){
    $aux = array();
    $j = 0;
    for ($i = (count($vec) -1); $i > -1 ; $i--) {
        $aux[$j] = $vec[$i];
        $j++;
    }
    
    return $aux;
}

echo "Array Invertido";
var_dump(invert($vec));


