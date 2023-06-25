<?php

class Auto {

    private $_marca;
    private $_color;
    private $_precio;
    private $_fecha;

    function __construct($_marca, $_color, $_precio = 0.00, $_fecha = null) {
        $this->_marca = $_marca; 
        $this->_color = $_color;
        $this->_precio = $_precio;
        if($_fecha != null){
            $this->_fecha = new DateTime($_fecha);
        } else {
            $this->_fecha = new DateTime();
        }
    }

    function agregarImpuestos($impuesto){
        $this->_precio += $impuesto;
    }

    static function MostrarAuto($auto){
        echo "Marca: ".$auto->_marca."<br>"; 
        echo "Color: ".$auto->_color."<br>";
        echo "Precio: ".$auto->_precio."<br>";
        echo "Fecha: ".date_format($auto->_fecha, 'Y-m-d')."<br>";
    }

    static function add($autoA, $autoB){
        if($autoA->_marca == $autoB->_marca && $autoA->_color == $autoB->_color ){
            return $autoA->_precio + $autoB->_precio;
        } else {
            echo "Los autos no se pueden sumar.<br>";
            return 0;
        }
    }

    function equals($auto){
        if($this->_marca == $auto->_marca){
            return true;
        }

        return false;
    }

}