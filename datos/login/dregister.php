<?php

namespace datos\login;

use config\Connection;

class DRegister
{
    private $pdo;
    private $dbConnect;

    public function __construct($pdo = null){
        if ($pdo === null) {
            $this->dbConnect = new Connection();
            $this->pdo = $this->dbConnect->getPDO();
        } else {
            $this->pdo = $pdo;
        }
    }

    /**
     * @throws \Exception
     */
    public function register(array $userData):bool{
        $result = false;
        try{
            $result = $this->dbConnect->register($userData);
        }catch (\Exception $e){
            return $e->getMessage();
        }
        return $result;
    }
}