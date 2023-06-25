<?php
define("USER_JSON_PATH", "usuarios.json");
define("USER_FILE_PATH", "Usuario/Fotos/");

class Usuario {
    public $_name;
    public $_pass;
    public $_email;
    public $_registrationDate;
    public $_id;
    public $_filePath; 

    function __construct($_name, $_pass, $_email, $_registrationDate, $_id, $_filePath) {
        $this->_name = $_name;
        $this->_pass = $_pass;
        $this->_email = $_email;
        $this->_registrationDate = $_registrationDate;
        $this->_id = $_id;        
        $this->_filePath = $_filePath;        
    }

    function guardarUsuario(){
        $ar = fopen(USER_JSON_PATH, "w");
        if ($ar !=NULL) {
            $array = Usuario::getUserArray();
            $userArray = $array != null ? $array : [];
            array_push($userArray, $this);
            $json = json_encode($userArray);
            fwrite($ar, $json);
        }

        fclose($ar);
    }

    public static function guardarFoto($tempName, $destino){
        //muevo el archivo $nombre al destino puesto
        move_uploaded_file($tempName, $destino);
        print("el archivo se guardo en " . $destino);
    }

    public static function getUserArray()
    {
        $file = fopen(USER_JSON_PATH, "r");
        if ($file !=NULL) {
            $contents = file_get_contents("/".USER_JSON_PATH, true);
            $json = json_decode($contents);        
        }

        fclose($file);
        return $json;
    }

}

?>