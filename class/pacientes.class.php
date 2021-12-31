<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Pacientes extends Conexion{

    private $tabla = 'pacientes',
            $pacienteId = "",
            $dni = "",
            $nombre = "",
            $direccion = "",
            $codigoPostal = "",
            $genero = "",
            $telefono = "",
            $fechaNacimiento = "0000-00-00",
            $correo = "",
            $token = "";


    #lista de todo los pacientes por orden de 100
    public function listaPacientes($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if($pagina > 1)
        {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
            
        }

        $query = "SELECT PacienteId,Nombre,DNI,Telefono,Correo FROM  $this->tabla limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;    
        
    }
    #Obtener paciente individual
    public function obtenerPaciente($id)
    {
        $query = "SELECT * FROM $this->tabla WHERE PacienteId = $id";
        return parent::obtenerDatos($query);
    }
    #Guardar pacientes o registrar
    public function registrar($json)
    {
        $_respuesta = new Respuestas;
        $datos = json_decode($json, true);

        if(!isset($datos['token']))
        {
            return $_respuesta->error401();
        }
        else
        {

        }
        if(!isset($datos['nombre']) || !isset($datos['dni']) || !isset($datos['correo']))
        {
            return $_respuesta->error400();
        }
        else
        {            
            $this->dni = $datos['dni'];
            $this->nombre = $datos['nombre'];
            $this->correo = $datos['correo'];

            if(isset($datos['direccion'])){$this->direccion = $datos['direccion'];}
            if(isset($datos['codigoPostal'])){$this->codigoPostal = $datos['codigoPostal'];}
            if(isset($datos['genero'])){$this->genero = $datos['genero'];}
            if(isset($datos['telefono'])){$this->telefono = $datos['telefono'];}
            if(isset($datos['fechaNacimineto'])){$this->fechaNacimiento = $datos['fechaNacimiento'];}
            $resp = $this->insertarPaciente();

            if($resp)
            {
                $respuestas = $_respuesta->response;
                $respuestas['result'] = array(
                    "pacienteId" => $resp
                );
                return $respuestas;
            }
            else
            {
                return $_respuesta->error500();
            }
        }
    }
    #Inyeccion de datos POST
    private function insertarPaciente()
    {
        $query = "INSERT INTO $this->tabla (DNI,Nombre,Direccion,CodigoPostal,Telefono,Genero,FechaNacimiento,Correo)VALUES('$this->dni','$this->nombre','$this->direccion','$this->codigoPostal','$this->telefono','$this->genero','$this->fechaNacimiento','$this->correo')";
        $respuesta = parent::nonQueryId($query);
        if($respuesta)
        {
            return $respuesta;
        }
        else
        {
            return 0;
        }
    }
    #Actualizar pacientes o editar
    public function editar($json)
    {
        $_respuesta = new Respuestas;
        $datos = json_decode($json, true);
        if(!isset($datos['pacienteId']))
        {
            return $_respuesta->error400();
        }
        else
        {            
            $this->pacienteId = $datos['pacienteId'];

            if(isset($datos['dni'])){$this->dni = $datos['dni'];}
            if(isset($datos['nombre'])){$this->nombre = $datos['nombre'];}
            if(isset($datos['correo'])){$this->correo = $datos['correo'];}
            if(isset($datos['direccion'])){$this->direccion = $datos['direccion'];}
            if(isset($datos['codigoPostal'])){$this->codigoPostal = $datos['codigoPostal'];}
            if(isset($datos['genero'])){$this->genero = $datos['genero'];}
            if(isset($datos['telefono'])){$this->telefono = $datos['telefono'];}
            if(isset($datos['fechaNacimineto'])){$this->fechaNacimiento = $datos['fechaNacimiento'];}
            $resp = $this->updatePaciente();

            if($resp)
            {
                $respuestas = $_respuesta->response;
                $respuestas['result'] = array(
                    "pacienteId" => $this->pacienteId
                );
                return $respuestas;
            }   
            else
            {
                return $_respuesta->error500();
            }
        }
    }
    #Inyeccion de datos PUT
    private function updatePaciente()
    {
        $query = "UPDATE $this->tabla SET DNI = '$this->dni', Nombre = '$this->nombre', Correo = '$this->correo', Direccion = '$this->direccion', CodigoPostal = '$this->codigoPostal', Genero = '$this->genero', Telefono = '$this->telefono', FechaNacimiento = '$this->fechaNacimiento' WHERE PacienteId = '$this->pacienteId' ";
        // print_r($query);
        $respuesta = parent::nonQuery($query);
        if($respuesta >= 1)
        {
            return $respuesta;
        }
        else
        {
            return 0;
        }
    }
     #Eliminar pacientes
     public function eliminar($json)
     {
         $_respuesta = new Respuestas;
         $datos = json_decode($json, true);
         if(!isset($datos['pacienteId']))
         {
             return $_respuesta->error400();
         }
         else
         {            
             $this->pacienteId = $datos['pacienteId'];
             $resp = $this->deletePaciente();
 
             if($resp)
             {
                 $respuestas = $_respuesta->response;
                 $respuestas['result'] = array(
                     "pacienteId" => $this->pacienteId
                 );
                 return $respuestas;
             }   
             else
             {
                 return $_respuesta->error500();
             }
         }
     }
     #Delete
     private function deletePaciente()
     {
         $query = "DELETE FROM $this->tabla WHERE PacienteId = '$this->pacienteId' ";
         // print_r($query);
         $respuesta = parent::nonQuery($query);
         if($respuesta >= 1)
         {
             return $respuesta;
         }
         else
         {
             return 0;
         }
     }
     #Verificar token
     private function buscarToken()
     {
         $query = "SELECT TokenId, UsuarioId, Estado FROM $this->tabla WHERE token = '$this->token' AND Estado ='Activo'";
         $respuesta = parent::obtenerDatos($query);
         
     }

}