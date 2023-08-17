<?php

namespace Models;

use PDO;
use PDOException;


class Database
{
    private $nameDb;
    private $userDb;
    private $passDb;

    private $pdo;
    public function __construct()
    {
        $envVars = parse_ini_file("../.ENV");
        $this->nameDb = $envVars['DB_DATABASE'];
        $this->userDb = $envVars['DB_USERNAME'];
        $this->passDb = $envVars['DB_PASSWORD'];
    }

    public function getConnection()
    {
        try {
            $this->pdo = new PDO("pgsql:dbname=$this->nameDb", $this->userDb, $this->passDb);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getClose()
    {
        $this->pdo = null;
    }

    public function setencia($sql)
    {
        $result = $this->pdo->query($sql);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function consultarCorreo($correo, $contrasena)
    {
        $this->getConnection();
        try {
            
            $query = "SELECT * FROM usuarios WHERE correo = :correo";
            $statement = $this->pdo->prepare($query);
            $statement->execute([':correo' => $correo]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            $this->getClose();
            if ($user && password_verify($contrasena, $user['contrasena'])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->getClose();
        }
       
    }

    public function registrar($nombre, $apellido, $correo, $contrasena, $rol){
        $this -> getConnection();
        try{
            $query = "INSERT INTO usuarios (nombre, apellido, correo, contrasena, rol) VALUES (:nombre, :apellido, :correo, :contrasena, :rol)";
            $statement = $this->pdo->prepare($query);
            $statement->execute(array(
                        ':nombre' => $nombre,
                         ':apellido' => $apellido,
                         ':correo' => $correo,
                         ':contrasena' => $contrasena,
                         ':rol' => $rol
                     ));
            
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            var_dump($resultado);
            return true;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function emailTaken($correo, $query){
            $this->getConnection();
        try {
            //code...
            $statement = $this->pdo->prepare($query);
            $statement->execute([':correo' => $correo]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            //throw $th;
            echo $e->getMessage();
        }
;
    }
}
