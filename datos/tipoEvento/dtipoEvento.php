<?php

namespace datos\tipoEvento;

use config\Connection;
use PDO;

class DTipoEvento
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
        $sql = 'SELECT * FROM tipoevento';
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

    public function agregarTipoEvento(array $data){
        $sql    = 'INSERT INTO tipoevento (nombre,frecuencia, descripcion) VALUES ( :nombre, :frecuencia, :descripcion)';
        try {
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($data);
            $this->pdo->commit();
            if($statement->rowCount() > 0){
                return $result;
            }else{
                throw new \Exception("Error al registrar la informacion");
            }
        }catch (\Exception $e){
            return "DTipoEvento: ". $e->getMessage();
        }
    }

    public function eliminarTipoEvento($id){
        $result = false;
        $sql = 'delete from tipoevento where id = :id';

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $statement->execute();
            if($result){
                return $result;
            }else{
                throw new \Exception("Error al eliminar la informacion");
            }
        }catch (\Exception $e){
            return "DTipoEvento: ". $e->getMessage();
        }
    }

    public function actualizarTipoEvento(array $data){
        $sql    = 'UPDATE tipoevento SET nombre = :nombre, frecuencia= :frecuencia,descripcion= :descripcion  WHERE id= :id';

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':frecuencia', $data['frecuencia'], PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
            $result = $stmt->execute();
            $this->pdo->commit();
            if($result){
                return $result;
            }else{
                throw new \Exception("No se pudo editar la informacion");
            }
        }catch (\Exception $e){
            return "DTipoEvento: ". $e->getMessage();
        }
    }
}