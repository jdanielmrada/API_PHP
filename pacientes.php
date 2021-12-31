<?php
require_once 'class/pacientes.class.php';
require_once 'class/respuestas.class.php';

$_paciente = new Pacientes;
$_respuesta = new Respuestas;

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if(isset($_GET['page']))
    {
        $pagina = $_GET['page'];
        $listaPaciente = $_paciente->listaPacientes($pagina);
        // header("Content-Type: aplication/json"); ojo estabas escribiendo mal application
        header('content-type: application/json; charset=utf-8');
        echo json_encode($listaPaciente);
        http_response_code(200);
    }
    else if(isset($_GET['id']))
    {
        $pacienteId = $_GET['id'];
        $datosPaciente = $_paciente->obtenerPaciente($pacienteId);
        // header("Content-Type: aplication/json"); este formato da error en cabecera
        header('content-type: application/json; charset=utf-8');
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
    
}
else if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Recibimos datos enviados
    $postBody = file_get_contents("php://input");
    //Envio de datos al manejador
    $datosArry = $_paciente->registrar($postBody);
    //Devolvemos una respuesta
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
else if($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    // Recibimos datos enviados
    $postBody = file_get_contents("php://input");
    //Envio de datos al manejador
    $datosArry = $_paciente->editar($postBody);
    //Devolvemos una respuesta
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
else if($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
    // Recibimos datos enviados
    $postBody = file_get_contents("php://input");
    //Envio de datos al manejador
    $datosArry = $_paciente->eliminar($postBody);
    //Devolvemos una respuesta

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