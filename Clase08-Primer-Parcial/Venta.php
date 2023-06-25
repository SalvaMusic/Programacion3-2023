<?php
define("VENTA_JSON_PATH", "Venta.json");

class Venta {
    public $_id;
    public $_email;
    public $_sabor;
    public $_tipo;
    public $_stock;
    public $_vaso;
    public $_fecha;
    public $_nroPedido;

    function __construct($_email, $_sabor, $_tipo, $_vaso, $_stock, $_fecha) {
        $this->_sabor = $_sabor;
        $this->_email = $_email;
        $this->_tipo = $_tipo;
        $this->_vaso = $_vaso;
        $this->_fecha = $_fecha;
        if (is_numeric($_stock)) {
            $this->_stock = intval($_stock);      
        }
    }

    static function getVenta($nroPedido){
        $array = Venta::getJsonList();
        for ($i=0; $i < count($array) ; $i++) {
            if($nroPedido == $array[$i]->_nroPedido){
                return $array[$i];
            }
        }
        return null;
    }
    
    function guardarVenta(){
        $array = Venta::getJsonList();
        $nextID = Venta::nextID($array);
        $ar = fopen(VENTA_JSON_PATH, "w");
        $guardado = false;
        if ($ar !=NULL) {
            if($this->_nroPedido != null){                
                for ($i=0; $i < count($array) ; $i++) {
                    if($this->_nroPedido == $array[$i]->_nroPedido){
                        $array[$i]->_email = $this->_email;
                        $array[$i]->_sabor = $this->_sabor;
                        $array[$i]->_tipo = $this->_tipo;
                        $array[$i]->_stock = $this->_stock;
                        $array[$i]->_vaso = $this->_vaso;
                        fwrite($ar, json_encode($array));
                        $guardado = true;
                        break;
                    }
                } 
            } else {
                $this->_id = $nextID;
                $this->_nroPedido = $nextID + 1000;
                array_push($array, $this);           
                fwrite($ar, json_encode($array));
                $guardado = true;
            }
        }
        fclose($ar);

        return $guardado;
    }

    public function guardarFoto($imagen){        
        $nombre = $this->_sabor. "-" .$this->_tipo. "-" .$this->_vaso. "-" .explode("@", $this->_email)[0];
        $tempName = $imagen["tmp_name"];
        $extension = (explode(".", $imagen["name"]))[1];
        $destino = Venta::getDir() . $nombre . "." . $extension;
        move_uploaded_file($tempName, $destino);

        print("La imagen se guardo en " . $destino.".");
    }

    private static function getDir(){
        $dir = './ImagenesDeLaVenta/2023/';
        if (is_dir($dir) === false){
            mkdir($dir, 0777, true);
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

    public static function newInstanceByObject($object) {
        $v = new Venta($object->_email, $object->_sabor, $object->_tipo, $object->_vaso, $object->_stock, $object->_fecha);
        $v->_id = $object->_id;
        $v->_nroPedido = $object->_nroPedido;
        return $v;
    }

    public function __toString() {
        return "ID: " . $this->_id . " - Email: " .$this->_email. " - Sabor: " . $this->_sabor ." - Tipo: ". $this->_tipo. " - Vaso: ". $this->_vaso. " - Cantidad: ".
        $this->_stock. " - Nro Pedido: " . $this->_nroPedido . 
        " - Fecha: " . Venta::getStrDate($this->_fecha);
    }

    private static function getStrDate($_fecha){
       return  explode(" ",$_fecha->date)[0];
    }

    public static function getCantidadHeladosVendidos($_fecha) {
        $array = Venta::getJsonList();
        $cantVentida = 0;

        if ($_fecha == null){
            $_fecha = new DateTime();
            $_fecha->sub(new DateInterval('P1D'));
        } 

        foreach($array as $v){
            if($_fecha ==  $v->getDate()){
                $cantVentida += $v->_stock;            
            }
        }
     
        return $cantVentida;
    }

    public static function getListaVentas($_desde, $_hasta, $_usuario, $_sabor, $_vaso) {
        $array = [];
        foreach(Venta::getJsonList() as $v){
            $_fecha = $v->getDate();

            if ((($_desde == null || $_fecha >= $_desde) && ($_hasta == null || $_fecha <= $_hasta))
                &&  ($_usuario == null || $v->_email == $_usuario)
                &&  ($_sabor == null || $v->_sabor == $_sabor)
                &&  ($_vaso == null || $v->_vaso == $_vaso)){
                    array_push($array, $v);
            }

        }
     
        return $array;
    }

    function getDate(){
        $date = DateTime::createFromFormat('Y-m-d', Venta::getStrDate($this->_fecha));
        return $date == false ? null : $date;
    }

    private function cmp($a, $b) {
        if ($a->_sabor == $b->_sabor) {
            return 0;
        }
        return ($a->_sabor < $b->_sabor) ? -1 : 1;
    }
}

?>