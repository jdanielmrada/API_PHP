<?php
require_once "class/conexion/conexion.php";
$conexion = new Conexion;

require_once "controller/index.php";
$controller = new Controller;

#listar las citas
// $tipoUser = 1;
// print_r($controller->Listar($conexion , $tipoUser));

#Pedir cita
// $tipoUser = 0;
// $detalle = 'descripcion';
    // ID del medico registrado
// $user = 1;

// print_r($controller->PedirCita($conexion , $tipoUser, $detalle,$user));

#Actualizar cita
$tipoUser = 1;

print_r($controller->ConfirmarCita($conexion , $tipoUser));