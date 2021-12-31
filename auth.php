<?php
require_once 'class/auth.class.php';
require_once 'class/respuestas.class.php';

// para no confundir las variables en instancia $_
$_auth = new Auth;
$_respuesta = new Respuestas;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // Recibir datos
    $postBody = file_get_contents("php://input");
    // Enviar datos que se manejan
    $datosArry = $_auth->login($postBody);
    // Devolvemos una respuesta
    header('content-type: application/json; charset=utf-8');
    if(isset($datosArry['result']['errorId']))
    {
        $responseCode = $datosArry['result']['errorId'];
        http_response_code($responseCode);
    }
    else
    {
        http_response_code(200);
    }
    echo json_encode($datosArry);
}
else
{
    header('content-type: application/json; charset=utf-8');
    $datosArry = $_respuesta->error405();
    echo json_encode($datosArry);
}