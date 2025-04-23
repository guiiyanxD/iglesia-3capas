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
        <div class="form-group" >
                <label for="nombres">Nombres:</label><br>
                <input class="form-control" type="text" name="nombres" placeholder="coloque aqui sus nombres" required>
        </div>
        <div class="form-group" >
                <label for="apellidos">Apellidos:</label><br>
                <input class="form-control" type="text" name="apellidos" placeholder="coloque aqui sus apellidos" required>
        </div>
        <div class="form-group" >
                <label for="nombre">Email:</label><br>
                <input class="form-control" type="email" name="email" placeholder="coloque aqui su email" required>
        </div>
        <div class="form-group" >
                <label for="password">Contrasena:</label><br>
                <input class="form-control" type="password" name="password" placeholder="coloque aqui su Contrasena" required>
        </div>
        <div class="form-group" >
                <label for="passwordConfirmation">Confirmacion Contrasena:</label><br>
                <input class="form-control" type="password" name="passwordConfirmation" placeholder="repita la Contrasena" required>
        </div>
       
        <input type="hidden" value="' .$token. '">

        <button type="submit" name="register">
            Registrarse
        </button>
        <button onclick=window.location.href="/login" class="button button-danger" >Cancelar </button>
        
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