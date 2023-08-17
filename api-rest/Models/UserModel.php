<?php

namespace Models;

use PDO;
use PDOException;

class UserModel extends Database
{

    public function verifyCredentials($correo, $contrasena)
    {
        return $this->consultarCorreo($correo, $contrasena);
    }
    
    public function isEmailTaken($correo) {
        try {
            $query = "SELECT correo FROM usuarios WHERE correo = :correo";
            $result = $this->emailTaken($correo, $query);
            //echo $result;
            return ($result !== false); // Retorna true si el correo ya está registrado, o false si no lo está
        } catch (PDOException $e) {
            return false; // En caso de error, se asume que el correo no está registrado
        }
    }

    public function createUser($nombre, $apellido, $correo, $contrasena, $rol) {
        try {
                return $this->registrar($nombre, $apellido, $correo, $contrasena, $rol);
         } catch (PDOException $e) {
        //     echo $e;
        //     return false; // En caso de error, retorna false
         }
    }
}
