<?php

class Controller{

    public function Listar($conexion, $tipoUser)
    {
        $date= date("y.m.d");

        if($tipoUser === 1)
        {
            $query = "SELECT * FROM `citas` WHERE date = '$date' ";

            return($conexion->obtenerDatos($query));
        }
        else
        {
            return 'Debe ser tipo medico';
        }
        
        
    }

    public function PedirCita($conexion, $tipoUser, $detalle, $user)
    {
        $date= date("y.m.d");
        $time= date("H:i:s");
        $confir= 0;

        if($tipoUser === 0)
        {
            $query = "INSERT INTO `citas` (`id`, `date`, `time`, `description`, `confir`, `iu_user`) VALUES (NULL, '$date', '$time', '$detalle', '$confir', '$user');";

            return($conexion->saveQuery($query));
        }
        else
        {
            return 'Debe ser tipo cliente';
        }
    }

    public function ConfirmarCita($conexion, $tipoUser)
    {

        if($tipoUser === 1)
        {
            $query = "UPDATE `citas` SET `confir` = '1' WHERE `citas`.`id` = 12;";

            return($conexion->saveQueryId($query));
        }
        else
        {
            return 'Debe ser tipo medico';
        }
    }
}