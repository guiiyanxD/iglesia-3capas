<?php

namespace config;

use PDO;
use PDOException;

Class Connection{
    private $host = "localhost";
    private $user   = "root";
    private $pass   = '';
    private $db_name= "proyectoiglesia";
    private $pdo;
    public $userData = [];
    public function __construct(){
        $this->pdo = $this->connect();

    }

    public function connect(){
        $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * Returns the PDO instance.
     *
     * @return PDO The PDO instance.
     */
    public function getPDO() {
        return $this->pdo;
    }

    public function getUserByEmail($email){
        $sql = 'SELECT * FROM usuario WHERE email = ?';
        $arr = [];
        $arr[] = $email;

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($arr);
            $user = $statement->fetch();
            return $user;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function register(array $userData)
    {
        $sql = 'INSERT INTO usuario (idCargo, nombres, apellidos, email, pwd ) VALUES (:cargo_id, :name, :lname, :email, :password)';
        $result = false;
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($userData);
            $this->pdo->commit();
            $result = true;
        } catch (\Exception $e) {
            throw new \Exception("BD: Error al registrar el usuario");
        }

        return $result;
    }


}



