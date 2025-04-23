<?php

namespace datos\usuario;

use config\Connection;
use PDO;
use Random\Engine\Secure;

class DUsuario
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

    public function getAll(){ //Podria colocar un param para obtener diferentes usos mas adelante
        $sql = 'SELECT u.id, u.nombres, u.apellidos, u.email, c.nombre FROM usuario as u, cargo as c WHERE c.id = u.idCargo';
        $ministerios = $this->pdo->query($sql);
        if($ministerios->rowCount() > 0){
            return $ministerios->fetchAll();
        }else{
            return throw new \Exception("Alerta: No se puede seleccionar ningun usuario");
        }
    }

    public function cambiarCargo($id, $idCargo){

        $sql = 'UPDATE usuario SET idCargo = :idCargo WHERE id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':idCargo', $idCargo, PDO::PARAM_INT);
            $result = $stmt->execute();
            $this->pdo->commit();
            if($result){
                return $result;
            }else{
                Throw new \Exception("Error al cambiar el cargo");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function verHistorial($id){
        $datosUsuario = '
            SELECT
                u.id        as userId,
                u.nombres   as userNombres,
                u.apellidos as userApellidos,
                u.email     as userEmail, 
                c.nombre    as cargoNombre
            FROM usuario AS u 
            INNER JOIN cargo AS c ON c.id = u.idCargo
            WHERE u.id = :id 
            ';
        $datosMinisterio = '
            SELECT nombre FROM ministerio WHERE idLider = :id
        ';

        $datosMiembro = '
            SELECT m.nombre, mm.idRol, mm.fechaIncorpporacion 
            FROM ministerio as m
            LEFT JOIN miembro as mm ON mm.idUsuario = :id
            WHERE idLider = :id
        ';

        $statement = $this->pdo->prepare($datosUsuario);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $statement = $this->pdo->prepare($datosMinisterio);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result2 = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $statement = $this->pdo->prepare($datosMiembro);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result3 = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'datosUsuario'=> $result,
            'datosMinisterio'=> $result2,
            'datosMiembro'=>$result3
        ];
    }

    public function getInfoPropiaById( $id){
        $sql = 'SELECT * FROM usuario WHERE id = :id';

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        if($statement->rowCount() > 0){
            return $statement->fetchAll();
        }else{
            return throw new \Exception("Alerta: No existen registros ");
        }
    }

    public function editarMiInformacionActualizar(array $userData){

        if(isset($userData['nuevaContrasena'])){
            $sql = 'UPDATE usuario 
            SET nombres= :nombres, apellidos = :apellidos, pwd = :nuevaContrasena 
            WHERE id = :id';

            $statement = $this->pdo->prepare($sql);
            $statement->execute($userData);
            $this->pdo->commit();
            if($statement->rowCount() > 0){
                session_regenerate_id(true);
//                $_SESSION['signin_user'] = $userData;
                return $statement->fetchAll();
            }else{
                return throw new \Exception("Alerta: No existen registros de Ministerios");
            }
        }else{
            $sql = 'UPDATE usuario 
            SET nombres= :nombres, apellidos = :apellidos
            WHERE id = :id';

            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':id', $userData['id'], PDO::PARAM_INT);
            $statement->bindParam(':nombres', $userData['nombres'], PDO::PARAM_STR);
            $statement->bindParam(':apellidos', $userData['apellidos'], PDO::PARAM_STR);
            $statement->execute();
            if($statement->rowCount() > 0){
                session_regenerate_id(true);
                $_SESSION['signin_user'] = $userData;

                return $statement->fetchAll();
            }else{
                return throw new \Exception("Alerta: No existen registros de Ministerios");
            }
        }
    }

    public function getUserByEmail($email){
        $sql = 'SELECT * FROM usuario WHERE email = ?';
        $arr = [];
        $arr[] = $email;

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($arr);
            $user = $statement->fetch();
            if($user){
                return $user;
            }else{
                Throw new \Exception("No existe ese usuario");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
