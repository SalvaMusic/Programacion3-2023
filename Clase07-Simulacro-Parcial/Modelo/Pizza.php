<?php
define("JSON_PATH", "Pizza.json");

class Pizza {
    public $_id;
    public $_sabor;
    public $_precio;
    public $_tipo;
    public $_cantidad;

    function __construct($_sabor, $_precio, $_tipo, $_cantidad) {
        $this->_sabor = $_sabor;
        $this->_precio = $_precio;
        $this->_tipo = $_tipo;
        if (is_numeric($_cantidad)) {
            $this->_cantidad = intval($_cantidad);      
        }
        if (is_numeric($_precio)) {
            $this->_precio = floatval($_precio);      
        }
    }

    function guardarPizza(){
        $array = Pizza::getJsonList();
        $nextID = Pizza::nextID($array);
        $ar = fopen(JSON_PATH, "w");
        if ($ar !=NULL) {
            foreach($array as $pizza){                
                if ($this->equals($pizza)){
                    $pizza->_precio = $this->_precio;
                    $pizza->_cantidad += $this->_cantidad;
                    $this->_id = $pizza->_id;
                    break;
                }
            }
            
            if ($this->_id == null){
                $this->_id = $nextID;
                array_push($array, $this);
            }
            
            for ($i = 0; $i < count($array) ; $i++) {
                echo $array[$i] . "  /  ";
            }  
            fwrite($ar, json_encode($array));
        }

        fclose($ar);
    }

    function equals($_pizza){
        return $_pizza != null 
                && (($this->_sabor != null && $_pizza->_sabor != null && $this->_sabor == $_pizza->_sabor) 
                && ($this->_tipo != null && $_pizza->_tipo != null && $this->_tipo == $_pizza->_tipo));
    }

    private static function nextID($array) {
        $maxID = 0;
        $array = $array != null ? $array : Pizza::getJsonList();

        foreach($array as $pizza){
            if ($pizza != null && $pizza->_id > $maxID){
                $maxID = $pizza->_id;
            }
        }
        $nextID = $maxID + 1;
        return $nextID;
    }

    private static function getJsonList() {
        $data = file_get_contents("Pizza.json");
        $array = json_decode($data);

        for ($i = 0; $i < count($array) ; $i++) {
            $array[$i] = Pizza::newInstanceByObject($array[$i]);
        }  
     
        return $array != null ? $array : [];
    }

    public static function getStock($sabor, $tipo){
        $array = Pizza::getJsonList();
        foreach($array as $pizza){       
            if ($sabor == $pizza->_sabor && $tipo == $pizza->_tipo){
                return $pizza->_cantidad;
            }
        }

        return null;
    }

    static function restarStock($sabor, $tipo, $_cantidad){
        $array = Pizza::getJsonList();
        $ar = fopen(JSON_PATH, "w");
        if ($ar !=NULL) {
            foreach($array as $pizza){                
                if ($sabor == $pizza->_sabor && $tipo == $pizza->_tipo){
                    $pizza->_cantidad = $pizza->_cantidad - $_cantidad;
                    break;
                }                
            }
           
            fwrite($ar, json_encode($array));
        }

        fclose($ar);
    }

    public static function newInstanceByObject($object) {
        $p = new Pizza($object->_sabor, $object->_precio, $object->_tipo, $object->_cantidad);
        $p->_id = $object->_id;
        return $p;
    }

    public function __toString() {
        return "ID: " . $this->_id ." Sabor: " . $this->_sabor ." Tipo: ". $this->_tipo. " Cantidad: ".$this->_cantidad. " Precio: " . $this->_precio;
    }
}

?>