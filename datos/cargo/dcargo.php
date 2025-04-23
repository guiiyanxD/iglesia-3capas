<?php

namespace datos\cargo;

use config\Connection;
use PDO;

class DCargo
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

    public function getAll(){
        $result = [];
        $sql = 'SELECT * FROM cargo';
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            if($statement->rowCount() > 0){
                 return $result;
            }else{
                 throw new \Exception("No se encontraron registros");
             }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function eliminarCargo($id){
        $result = [];
        $sql = 'delete from cargo where id = :id';
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $statement->execute();
            if($result){
                return $result;
            }else{
                throw new \Exception("No se encontraron registros");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function agregarCargo(array $dataCargo){
        $result = [];
        $sql    = 'INSERT INTO cargo ( nombre, descripcion) VALUES ( :nombre, :descripcion)';

        try {
            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($dataCargo);
            $this->pdo->commit();
            if($result){
                return $result;
            }else{
                throw new \Exception("No se agregar el cargo");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function actualizarCargo(array $dataCargo){
        $sql    = 'UPDATE cargo SET nombre = :nombre, descripcion= :descripcion  WHERE id= :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $dataCargo['id'], PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $dataCargo['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $dataCargo['descripcion'], PDO::PARAM_STR);
            $result = $stmt->execute();
            $this->pdo->commit();
            if($result){
                return $result;
            }else{
                throw new \Exception("No se pudo editar el cargo");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

}