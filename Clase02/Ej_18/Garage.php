<?php

class Garage {

    private $_razonSocial;
    private $_precioPorHora;
    private Auto $_autos [] ;

    function __construct($_razonSocial, $_precioPorHora = 0.00) {
        $this->_razonSocial = $_razonSocial; 
        $this->_precioPorHora = $_precioPorHora;
    }


    function mostrarGarage(){
        echo "Razon Social: ".$this->_razonSocial."<br>"; 
        echo "Precio por Hora: ".$this->_precioPorHora."<br>";
        echo "Autos: ".$auto->_precio."<br>";
    }

    static function add($autoA, $autoB){
        if($autoA->_marca == $autoB->_marca && $autoA->_color == $autoB->_color ){
            return $autoA->_precio + $autoB->_precio;
        } else {
            echo "Los autos no se pueden sumar.<br>";
            return 0;
        }
    }

    function equals(Auto $auto){
        foreach ($this->_autos as $value) {
            if($auto.equals($value)){
                $isValidWord = 1;
                break;
            }
        }
        if($this->_marca == $auto->_marca){
            return true;
        }

        return false;
    }

}