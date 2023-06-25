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
        echo $auto->__toString();
    }

    function __toString(){ 
        return $this->_marca.", ".$this->_color.", ".$this->_precio.", ".$this->_fecha;
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
        return $this->_marca == $auto->_marca;
    }

    static function altaAuto($auto){
        $archivo = fopen("autos.csv","a");
        fwrite($archivo, $auto->__toString());
        fclose($archivo);
    }

    public static function traerListado(){
        $archivo = fopen("autos.csv", "r");
        $autoSrt = null;
        $autosList[] = array();

        if ($archivo != NULL) {
            while(!feof($archivo)){
                $autoSrt = fgets($archivo, filesize("autos.csv"));
                $autoArray = explode(",", $autoSrt);
                $marca = trim($autoArray[0]);
                $color = trim($autoArray[1]);
                $precio = trim($autoArray[2]);
                $fecha = trim($autoArray[3]);
                $auto = new Auto ($marca, $color, $precio, $fecha);
                array_push($autosList, $auto);
            }
        }
        fclose($archivo);

        return $autosList;
    }

}