<?php

class Conexion{
    private $server,
            $user,
            $password,
            $database,
            $port,
            $conexion;


    function __construct()
    {
        $listdato = $this->datosConexion();
        foreach($listdato as $key => $value)
        {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }

        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        if ($mysqli->connect_errno)
        {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
    }
    #coneccion y retorno en array
    private function datosConexion()
    {
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion ."/". "config");
        return json_decode($jsondata, true);
    }
    #Convertidor UTF8
    private function convertidorUtf8($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true))
            {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }
    #
    public function obtenerDatos($query)
    {
        $results = $this->conexion->query($query);
        $resultsArray = array();
        foreach($results as $key)
        {
            $resultsArray[] = $key;
        }

        return $this->convertidorUtf8($resultsArray);
    }
    #
    public function nonQuery($query)
    {
        $results = $this->conexion->query($query);
        return $this->conexion->affected_rows;
    }
    #Insert que devuelve el ultimo valor
    public function nonQueryId($query)
    {
        $results = $this->conexion->query($query);
        $filas = $this->conexion->affected_rows;
        if($filas >= 1)
        {
            return $this->conexion->insert_id;
        }
        else
        {
            return 0;
        }
    }
    #metodo de encriptacion
    protected function encriptar($string)
    {
        return md5($string);
    }
}
