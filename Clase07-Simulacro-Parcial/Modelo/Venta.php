<?php
define("VENTA_JSON_PATH", "Venta.json");

class Venta {
    public $_id;
    public $_email;
    public $_sabor;
    public $_tipo;
    public $_cantidad;
    public $_fecha;
    public $_nroPedido;

    function __construct($_email, $_sabor, $_tipo, $_cantidad, $_fecha) {
        $this->_sabor = $_sabor;
        $this->_email = $_email;
        $this->_tipo = $_tipo;
        $this->_fecha = $_fecha;
        if (is_numeric($_cantidad)) {
            $this->_cantidad = intval($_cantidad);      
        }
    }

    function guardarVenta(){
        $array = Venta::getJsonList();
        $nextID = Venta::nextID($array);
        $ar = fopen(VENTA_JSON_PATH, "w");
        if ($ar !=NULL) {            
            $this->_id = $nextID;
            $this->_nroPedido = $nextID + 1000;
            array_push($array, $this);            
            fwrite($ar, json_encode($array));
        }
        fclose($ar);
    }

    public function guardarFoto($imagen){        
        $nombre = $this->_tipo. "-" .$this->_sabor. "-" .explode("@", $this->_email)[0];
        $tempName = $imagen["tmp_name"];
        $extension = (explode(".", $imagen["name"]))[1];
        $destino = Venta::getDir() . $nombre . "." . $extension;
        move_uploaded_file($tempName, $destino);

        print("La imagen se guardo en " . $destino.".");
    }

    private static function getDir(){
        $dir = './ImagenesDeLaVenta/';
        if (is_dir($dir) === false){
            mkdir($dir);
        }

        return $dir ;
    }
    private static function nextID($array) {
        $maxID = 0;
        $array = $array != null ? $array : Venta::getJsonList();

        foreach($array as $v){
            if ($v->_id > $maxID){
                $maxID = $v->_id;
            }
        }
        $nextID = $maxID + 1;
        return $nextID;
    }

    private static function getJsonList() {
        if(!file_exists(VENTA_JSON_PATH)){
            return [];
        }

        $data = file_get_contents(VENTA_JSON_PATH);
        $array = json_decode($data);

        for ($i = 0; $i < count($array) ; $i++) {
            $array[$i] = Venta::newInstanceByObject($array[$i]);
        }  
     
        return $array != null ? $array : [];
    }

    public static function getCantidadPizzasVendidas() {
        $array = Venta::getJsonList();
        $cantVentida = 0;
        foreach($array as $v){
            $cantVentida += $v->_cantidad;            
        }
     
        return $cantVentida;
    }

    public static function getListaVentas($_desde, $_hasta, $_usuario, $_sabor) {
        $array = [];
        foreach(Venta::getJsonList() as $v){
            $_fecha = $v->getDate();

            if ((($_desde == null || $_fecha >= $_desde) && ($_hasta == null || $_fecha <= $_hasta))
                &&  ($_usuario == null || $v->_email == $_usuario)
                &&  ($_sabor == null || $v->_sabor == $_sabor)){
                    array_push($array, $v);
            }

        }
     
        return $array;
    }

    public static function newInstanceByObject($object) {
        $v = new Venta($object->_email, $object->_sabor, $object->_tipo, $object->_cantidad, $object->_fecha);
        $v->_id = $object->_id;
        $v->_nroPedido = $object->_nroPedido;
        return $v;
    }

    public function __toString() {
        return "ID: " . $this->_id . " Email: " .$this->_email. " Sabor: " . $this->_sabor ." Tipo: ". $this->_tipo. " Cantidad: ".
        $this->_cantidad. " Nro Pedido: " . $this->_nroPedido . 
        " Fecha: " . Venta::getStrDate($this->_fecha);
    }

    private static function getStrDate($_fecha){
       return  explode(" ",$_fecha->date)[0];
    }

    function getDate(){
        $date = DateTime::createFromFormat('Y-m-d', Venta::getStrDate($this->_fecha));
        return $date == false ? null : $date;
    }
}

?>