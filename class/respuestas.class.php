<?php

class Respuestas{
    public $response = [
        "status"=> "ok",
        "result"=> "array()"
    ];

    public function error405()
    {
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "errorId" => "405",
            "errorMsg" => "Metodo no permitido"
        );
        return $this->response;
    }

    public function error200($value = 'Datos Incorrectos')
    {
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "errorId" => "200",
            "errorMsg" => $value
        );
        return $this->response;
    }

    public function error400()
    {
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "errorId" => "400",
            "errorMsg" => "Datos enviados incompletos o con formato incorrecto"
        );
        return $this->response;
    }

    public function error401($value = 'No autorizado, token invalido')
    {
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "errorId" => "401",
            "errorMsg" => $value
        );
        return $this->response;
    }

    public function error500($value = 'Error interno del servidor')
    {
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "errorId" => "500",
            "errorMsg" => $value
        );
        return $this->response;
    }
}