<?php

namespace datos\login;

//use config\Connection;
use config\Connection;

require_once('../../proyectoiglesia/config/Connection.php');

class DLogin{
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

    public function login(array $data):bool{
        $result = false;
        try {
            $user_data = $this->dbConnect->getUserByEmail($data["email"]);

            if ($user_data) {
                if (password_verify($data['password'], $user_data['pwd'])) {
                    session_regenerate_id(true);
                    $_SESSION['signin_user'] = $user_data;
                    $result = true;
                    return $result;
                }else{
                    echo ("Verificar el correo o la contrasena");
                    exit();
                }
            }else{
                echo ("Verificar el correo o la contrasena");
                exit();
            }


        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Check if the user is signed in.
     *
     * @return bool $result True if signed in, false otherwise.
     */
    public function checkSign(): String {
        $result = "false";

        // True if there is 'signin_user' in the session
        if (isset($_SESSION['signin_user']) && $_SESSION['signin_user']['id'] > 0) {
            $result = "true";
        }
        return $result;
    }

    public function logout() {
//        unset($_SESSION);
        $_SESSION = [];
//        session_start();
        session_destroy();
    }
}