<?php

$word = "Programacion";

function isValidWord($word, $max){
    $isValidWord = 0;
    $words = array("Recuperatorio", "Parcial", "Programacion");

    if(strlen($word) > $max){
        echo "La palabra excede la cantidad máxima de caracteres permitidos: ".$max."\n";
        return $isValidWord;
    }
        
    foreach ($words as $value) {
        if($value == $word){
            $isValidWord = 1;
            break;
        }
    }
    
    return $isValidWord;
}

echo $word."\n";

if(isValidWord($word, 10)){
      echo "Es una palabra Válida.";
} else {
    echo "No es una palabra Válida.";
}


