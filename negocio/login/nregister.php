<?php

namespace negocio\login;

use datos\login\DRegister;
use Random\RandomException;
require_once('../../proyectoiglesia/datos/login/dregister.php');


class NRegister
{
    private $name;
    private $lname;
    private $email;
    private $password;
    private $cargo;
    private $passwordConfirmation;
    private $dregister;

    public function __construct(){
        $this->dregister = new DRegister(null);
    }

    public function register(array $userData){
        try {
            $hashPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
            $userData['password'] = $hashPassword;
            return $this->dregister->register($userData);
        }catch (\Exception $e){
            $errors = $e->getMessage();
            echo  $errors;
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
}