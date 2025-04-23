<?php

namespace datos\ministerio;

use config\Connection;
use negocio\ministerio\Ministerio;
use PDO;

require_once("../../proyectoiglesia/negocio/ministerio/ministerio.php");


class DMinisterio
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
        $sql = 'SELECT m.id, m.nombre, m.activo, m.fechaCreacion, u.nombres, u.apellidos  
            FROM ministerio as m
            LEFT JOIN usuario as u ON m.idLider = u.id';
        $ministerios = $this->pdo->query($sql);
        if($ministerios->rowCount() > 0){
            return $ministerios->fetchAll();
        }else{
            return throw new \Exception("Alerta: No existen registros de Ministerios");
        }
    }

    public function guardarNuevoMinisterio(array $ministerio){
        $sql = 'INSERT INTO ministerio (nombre, mision, vision, fechaCreacion, activo, idLider) 
                VALUES (:nombre, :mision, :vision, :fechaCreacion, :activo, :idLider)';
        try {
//            $test = $this->pdo->prepare($sql);
//            $_SESSION['msgMinisterio'] = $sql;
            $statement = $this->pdo->prepare($sql);
            $statement->execute($ministerio);
            $this->pdo->commit();
            if($statement->rowCount() > 0){
                return $statement->fetchAll();
            }else{
                return throw new \Exception("Alerta: No existen registros de Ministerios");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    public function eliminar($id){
        $sql = 'delete from ministerio where id = :id';

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            if($statement->rowCount() > 0){
                return true;
            }else{
                throw new \Exception("No se encontro ningun Ministerio con el ID proporcionado");
            }
        } catch (\Exception $e) {
            return "Error al eliminar el Cargo: ".$e->getMessage();
        }
    }
    public function getById($id){
        /*$sql = 'SELECT m.*, u.nombres, u.apellidos, ul.nombres, ul.apellidos
                FROM ministerio as m
                INNER JOIN miembro as p on p.idMinisterio = :id
                INNER JOIN usuario as u on u.id = p.idUsuario 
                where m.id = :id';*/
        $ministerioInfo = 'SELECT 
            m.id, m.nombre, m.fechaCreacion, m.mision, m.vision, m.activo, m.idLider, 
            ul.nombres as liderName, ul.apellidos as liderLastName 
            FROM ministerio AS m 
            LEFT JOIN usuario AS ul ON m.idLider = ul.id         
            WHERE m.id = :id';

        $miembroInfo = 'SELECT 
            u.id as miembroId, u.nombres as miembroName, u.apellidos as miembroLastName 
            FROM miembro AS p 
            INNER JOIN usuario AS u ON u.id = p.idUsuario         
            WHERE p.idMinisterio = :id';

        try {
            $statement = $this->pdo->prepare($ministerioInfo);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $statementP = $this->pdo->prepare($miembroInfo);
            $statementP->bindParam(':id', $id, PDO::PARAM_INT);
            $statementP->execute();
            $result2 = $statementP->fetchAll(\PDO::FETCH_ASSOC);

            $array = [
                'MinisterioInfo'    => $result,
                'MiembroInfo'       => $result2,
            ];
//            $_SESSION['msgMinisterio'] = $array;
            if($statement->rowCount() > 0){
                return $array;
            }else{
                throw new \Exception("NO HAY MINISTERIO");
            }
        } catch (\Exception $e) {
            return "BD: ".$e->getMessage();
        }
    }

    public function actualizarMinisterio(array $ministerio){
        $_SESSION['msgMinisterio'] = $ministerio;
        $sql = 'UPDATE ministerio SET nombre= :nombre, mision = :mision, vision= :vision, 
              fechaCreacion= :fechaCreacion, activo= :activo, idLider = :idLider WHERE id = :id ';
        $ministerio['activo'] = ($ministerio['activo'] == false ? "0" : "1");

        $statement = $this->pdo->prepare($sql);
        $statement->execute($ministerio);
        $this->pdo->commit();
        if($statement->rowCount() > 0){
            return $statement->fetchAll();
        }else{
            return throw new \Exception("Alerta: No existen registros de Ministerios");
        }
    }


}
