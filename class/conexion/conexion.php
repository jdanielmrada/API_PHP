<?php
class Conexion {
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    function __construct()
    {
        $listdatos = $this->datosConexion();

        #recorriendo el listado para establecerlo a la clase
        foreach($listdatos as $key => $value)
        {
            $this->server   =  $value["server"];
            $this->user     =  $value["user"];
            $this->password =  $value["password"];
            $this->database =  $value["database"];
            $this->port     =  $value["port"];
        }

        #Realizando conexion
        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);

        #verificando conexion
        if($this->conexion->connect_errno)
        {
            echo "al go esta mal con la conexion";
        }
    }

// Obteniendo datos de el archivo y pasarlos a un array
 
    private function datosConexion()
    {
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion. '/'. 'config');
        return json_decode($jsondata, true);
    }

    #verificar y trasformar valores al estandar utf8

    private function convertirUtf($array)
    {
        array_walk_recursive($array, function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8', true))
            {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    #listar
    public function obtenerDatos($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        $resultsArray = array();

        foreach($results as $key)
        {
            $resultsArray[] = $key;
        }

        return $this->convertirUtf($resultsArray);
    }

    #Guardar
    public function saveQuery($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;

    }

    public function saveQueryId($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        $fila = $this->conexion->affected_rows;

        if($fila >= 1)
        {
            return 0;
        }
        else
        {
            return $this->conexion->insert_id;
        }

    }


}