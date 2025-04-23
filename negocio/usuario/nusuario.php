<?php

namespace negocio\usuario;

use datos\usuario\DUsuario;
require_once("../../proyectoiglesia/datos/usuario/dusuario.php");


class NUsuario
{
    private DUsuario $dusuario;
    public function __construct(){
        $this->dusuario = new DUsuario();
    }

    public function getAll(){
        try {
            return $this->dusuario->getAll();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function cambiarCargo($id, $idCargo){
        try {
            $result = $this->dusuario->cambiarCargo($id, $idCargo);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function verHistorial($id){
        try {
            $result = $this->dusuario->verHistorial($id);
            return $result;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function getInfoPropiaById($id){
        try {
            $idUser = ['id'=> $id];
            $result = $this->dusuario->getInfoPropiaById($id);
            return $result;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function editarMiInformacionActualizar(array $userData){
        $userData = $this->formatArray($userData);
//        $_SESSION['msgUser'] = $userData;

        try {
            if($this->verificarContrasenaEnBlanco($userData)){
                $nuevaData = $this->quitarCamposContrasenas($userData);
//                $_SESSION['msgUser'] = $nuevaData;
                return $result = $this->dusuario->editarMiInformacionActualizar($nuevaData);
            }else{
                if($this->verificarLongitudContrasena($userData)){
                    if($userData['nuevaContrasena'] === $userData['confirmarContrasena'] ){
                        if(password_verify($userData['actualContrasena'], $_SESSION['user_signin']['pwd'])){
                            $hashPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
                            $userData['nuevaContrasena'] = $hashPassword;
                            return $result = $this->dusuario->editarMiInformacionActualizar($userData);
                        }else{
                            Throw new \Exception("Verifique su contrasena actual");
                        }
                    }else{
                        Throw new \Exception("Debe escribir la misma contrasena en ambos campos");
                    }
                }else{
                    Throw new \Exception("Verificar longitud de las contrasenas");
                }


            }

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function verificarLongitudContrasena(array $userData){
        return (
            strlen($userData['actualContrasena']) > 7 &&
            strlen($userData['nuevaContrasena'])  > 7 &&
            strlen($userData['confirmarContrasena'])>7
        );
    }

    public function formatArray($userData){
        return [
            'id'                    =>$userData[0],
            'nombres'               =>$userData[1],
            'apellidos'             =>$userData[2],
            'email'                 =>$userData[3],
            'actualContrasena'      =>$userData[4],
            'nuevaContrasena'       =>$userData[5],
            'confirmarContrasena'   =>$userData[6],
        ];
    }

    public function existUser($email){
        try {
            return $this->dusuario->getUserByEmail($email);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function quitarCamposContrasenas($userData){
        unset($userData['actualContrasena'], $userData['nuevaContrasena'], $userData['confirmarContrasena']);
        return $userData;
    }
    public function verificarContrasenaEnBlanco(array $userData){
        return (
            empty($userData['actualContrasena']) &&
            empty($userData['nuevaContrasena'])  &&
            empty($userData['confirmarContrasena']) );
    }
}