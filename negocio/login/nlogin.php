<?php

namespace negocio\login;

require_once('../../proyectoiglesia/datos/login/dlogin.php');
//use datos\login\DLogin;
use datos\login\DLogin;
use Random\RandomException;

class NLogin
{
    private $email;
    private $password;
    private $dlogin;

    public function __construct(){
        $this->dlogin = new DLogin(null);
    }

    public function login(array $userData){
        try {
            if(str_contains($userData['email'], '@') == true
                && strlen($userData['password']) >= 8){
                return $result = $this->dlogin->login($userData);
            }else{
                Throw new \Exception("Revisa que el email sea valido y la contraseña tenga una longitud mayor a 8 caracteres");
            }
        }catch (\Exception $e){
            $errors = $e->getMessage();
            echo $errors;
        }

    }

    /**
     * @throws RandomException
     */
    function setToken() :string {
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;

        return $csrf_token;
    }

    public function logout(){
        $this->dlogin->logout();
    }

    public function checkSignIn(): bool
    {
        return $this->dlogin->checkSign();
    }

}