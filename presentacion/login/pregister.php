<?php

namespace presentacion\login;

use negocio\login\NRegister;
require_once('../../proyectoiglesia/negocio/login/nregister.php');


class PRegister
{
    private $name;
    private $lname;
    private $email;
    private $password;
    private $passwordConfirmation;
    private $nregister;

    public function __construct()
    {
        session_start();//
        $this->nregister = new NRegister();
    }

    public function registerForm($token){
        isset($_SESSION['errors_Register']) ? $errors = $_SESSION['errors_Register'] : $errors = "";
        $form =
            '<h1>Formulario para registrarse</h1>
    <p>'. $errors.'</p>
    <form action="/register" method="POST">
        <label>       
            Nombres:
            <input type="text" name="name" placeholder="Nombres" required>
        </label>
        <label>
            Apellidos:
            <input type="text" name="lname" placeholder="Apellidos" required>
        </label>
        <label>
            Email:
            <input type="text" name="email" placeholder="Email" required>
        </label>
        <label>
            Password:
            <input type="text" name="password" placeholder="coloque aqui su password" required>
        </label>
        <label>
            Password Confirmation:
            <input type="text" name="passwordConfirmation" placeholder="Repita su contraseña" required>
        </label>
       
        <input type="hidden" value="' .$token. '">

        <button type="submit" name="register">
            Registrarse
        </button>
        <a type="button" href="/">
            Volver al inicio
        </a>
    </form>';
        return $form;
    }

    public function renderRegisterForm($errors = ""){
        $csrf = $this->nregister->setToken();
        $form = $this->registerForm($csrf, $errors);
        include("registerForn.php");
        echo $form;
    }

    public function register($name, $lname, $email, $password, $passwordConfirmation ): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->name                 = $name;
            $this->lname                = $lname;
            $this->email                = $email;
            $this->password             = $password;
            $this->passwordConfirmation = $passwordConfirmation;
        }
        try {
            if($this->password === $this->passwordConfirmation){
                $this->nregister->register($this->getCredentialDataRegister());
                header('location: /login');
            }else{
                throw new \Exception("Las contrasenas no coinciden");
            }
        }catch (\Exception $e){
            $errors = $e->getMessage();
            $_SESSION['errors_Register'] = $errors;
            header('location: /register');
        }
    }
    public function getCredentialDataRegister(): array
    {
        return [
            'cargo_id'              => 1,
            'name'                  => $this->name,
            'lname'                 => $this->lname,
            'email'                 => $this->email,
            'password'              => $this->password,
        ];
    }

}