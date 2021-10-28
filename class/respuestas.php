<?php
class Respuesta{
    private $response = [
        'status' => 'ok',
        'result' => array()
    ];

    public function error405()
    {
        $this->response["status"] = "error";
        $this->response["result"] = array(
            "error_id"  => "405",
            "error_msg" => "metodo no permitido"
        );

        return $this->response;
    }
}