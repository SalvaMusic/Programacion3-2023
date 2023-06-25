<?php
define("JSON_PATH", "Heladeria.json");

class Heladeria {
    public $_id;
    public $_sabor;
    public $_precio;
    public $_tipo;
    public $_vaso;
    public $_stock;

    function __construct($_sabor, $_precio, $_tipo, $_vaso, $_stock) {
        $this->_sabor = $_sabor;
        $this->_precio = $_precio;
        $this->_tipo = $_tipo;
        $this->_vaso = $_vaso;
        if (is_numeric($_stock)) {
            $this->_stock = intval($_stock);      
        }
        if (is_numeric($_precio)) {
            $this->_precio = floatval($_precio);      
        }
    }

    function guardarHeladeria(){
        $array = Heladeria::getPersistedList();
        $nextID = Heladeria::nextID($array);
        $ar = fopen(JSON_PATH, "w");
        if ($ar !=NULL) {
            foreach($array as $h){                
                if ($this->equals($h)){
                    $h->_precio = $this->_precio;
                    $h->_stock += $this->_stock;
                    $this->_id = $h->_id;
                    break;
                }
            }
            
            if ($this->_id == null){
                $this->_id = $nextID;
                array_push($array, $this);
            }
            
            fwrite($ar, json_encode($array));
        }

        fclose($ar);
    }

    public function guardarImagen($imagen){        
        $nombre = $this->_sabor. "-" . $this->_tipo;
        $tempName = $imagen["tmp_name"];
        $extension = (explode(".", $imagen["name"]))[1];
        $destino = Heladeria::getDir() . $nombre . "." . $extension;
        move_uploaded_file($tempName, $destino);

        print("La imagen se guardo en " . $destino.".");
    }

    function equals($h){
        return $h != null 
                && (($this->_sabor != null && $h->_sabor != null && $this->_sabor == $h->_sabor) 
                && ($this->_tipo != null && $h->_tipo != null && $this->_tipo == $h->_tipo));
    }

    private static function nextID($array) {
        $maxID = 0;
        $array = $array != null ? $array : Heladeria::getPersistedList();

        foreach($array as $h){
            if ($h != null && $h->_id > $maxID){
                $maxID = $h->_id;
            }
        }
        $nextID = $maxID + 1;
        return $nextID;
    }

    private static function getPersistedList() {
        if(!is_file("Heladeria.json")){
            return [];
        }

        $data = file_get_contents("Heladeria.json");
        $array = json_decode($data);

        for ($i = 0; $i < count($array) ; $i++) {
            $array[$i] = Heladeria::newInstanceByObject($array[$i]);
        }  
     
        return $array != null ? $array : [];
    }

    

    public static function getStock($sabor, $tipo){
        $array = Heladeria::getPersistedList();
        foreach($array as $h){       
            if ($sabor == $h->_sabor && $tipo == $h->_tipo){
                return $h->_stock;
            }
        }

        return null;
    }

    static function restarStock($sabor, $tipo, $_stock){
        $array = Heladeria::getPersistedList();
        $ar = fopen(JSON_PATH, "w");
        if ($ar !=NULL) {
            foreach($array as $h){                
                if ($sabor == $h->_sabor && $tipo == $h->_tipo){
                    $h->_stock = $h->_stock - $_stock;
                    break;
                }                
            }
           
            fwrite($ar, json_encode($array));
        }

        fclose($ar);
    }

    public static function newInstanceByObject($object) {
        $h = new Heladeria($object->_sabor, $object->_precio, $object->_tipo, $object->_vaso, $object->_stock);
        $h->_id = $object->_id;
        return $h;
    }

    private static function getDir(){
        $dir = './ImagenesDeHelados/2023/';
        if (is_dir($dir) === false){
            mkdir($dir, 0777, true);
        }

        return $dir ;
    }

    public function __toString() {
        return "ID: " . $this->_id ." Sabor: " . $this->_sabor ." Tipo: ". $this->_tipo. " Vaso: ".$this->_vaso." Stock: ".$this->_stock. " Precio: " . $this->_precio;
    }
}

?>