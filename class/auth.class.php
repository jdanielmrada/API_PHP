<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Auth extends Conexion{
    #
    public function login($json)
    {
        $_respuesta = new Respuestas;
        $datos = json_decode($json, true);

        if(!isset($datos['usuario']) || !isset($datos['password']))
        {
            // Error datos no existen
            return $_respuesta->error400();
        }
        else
        {
            //Datos si existen
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $_password = parent::encriptar($password);

            $datos = $this->obtenerDatosUsuarios($usuario);
            if($datos)
            {
                //Si existe el usuario
                    // Verificar password
                    if($_password == $datos[0]['Password'])
                    {
                        //Password correcto
                            // Verificar estado
                            if($datos[0]['Estado'] == 'Activo')
                            {
                                //Estado Activo
                                    // Verificar token
                                    $verificar = $this->insertToken($datos[0]['UsuarioId']);
                                    if($verificar)
                                    {
                                        // Si se guardo
                                        $result = $_respuesta->response;
                                        $result['result'] = array(
                                            "token" => $verificar
                                        );
                                        return $result;
                                    }
                                    else
                                    {
                                        // No se guardo
                                            //token no generado
                                            return $_respuesta->error500("Estado interno, token no generado");
                                    }
                            }
                            else
                            {
                                //Estado inactivo
                                return $_respuesta->error200("Estado inactivo");
                            }
                    }
                    else
                    {
                        //Password no coinciden
                        return $_respuesta->error200("Password no coinciden");
                    }
            }
            else
            {
                // No existe el usuario
                return $_respuesta->error200("El usuario $usuario no exixte");
            }
        }
    }
    #
    private function obtenerDatosUsuarios($email)
    {
        $query = "SELECT UsuarioId,Password,Estado FROM usuarios WHERE Usuario = '$email' ";
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]['UsuarioId']))
        {
            return $datos;
        }
        else
        {
            return 0;
        }
    }
    #Generador de token
    private function insertToken($usuarioId)
    {
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date = date("Y-m-d H:i");
        $estado = 'Activo';
        $query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha)values('$usuarioId','$token','$estado','$date')";
        $verificar = parent::nonQuery($query);
        if($verificar)
        {
            //Fila afectada con exito
            return $token;
        }
        else
        {
            // Fila no afectada transmision fallida
            return 0;
        }
    }

}