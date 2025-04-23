<?php
namespace presentacion\login;

use negocio\login\NLogin;

class PLogin
{
    private $email;
    private $password;
    private $nlogin;
    public function __construct(){
        session_start();
        $this->nlogin = new NLogin();
    }

    public function loginForm($token){
        isset($_SESSION['errors_Login']) ? $errors = $_SESSION['errors_Login'] : $errors = "";

        $form =
            '
        <p>'. $errors.'</p>
        <form action="/login" method="POST">
            <div class="form-group" >
                <label for="nombre">Email:</label><br>
                <input class="form-control" type="email" name="email" style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" placeholder="coloque aqui su email" required>
            </div>
            <div class="form-group" >
                <label for="nombre">Email:</label><br>
                <input class="form-control" type="password" name="password" style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" placeholder="coloque aqui su password" required>
            </div>
           
           
            <input type="hidden" value="'.$token.'">
    
            <button type="submit" name="login">
                Iniciar Sesion
            </button>
        </form>';
        return $form;
    }
    public function renderLoginForm(){
        $csrf = $this->nlogin->setToken();
        $form = $this->loginForm($csrf);
        include("loginForm.php");
        echo $form;
    }

    public function login($email, $password){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->email        = $email;
            $this->password     = $password;
        }
        try {
            $result = $this->nlogin->login($this->getCredentialDataLogin());
            if($result){
//                require dirname($_SERVER['DOCUMENT_ROOT'])."/prueba.php";
                header('location: /menu');
            }
        }catch (\Exception $e){
            $errors = $e->getMessage();
            $_SESSION['errors_Login'] = $errors;
            header('location: /login');
        }

    }

    public function getCredentialDataLogin():array{
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function checkSignIn():bool{
        return $this->nlogin->checkSignIn();
    }

    public function logout(){

        session_start();

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location: /");
        exit();


    }
}