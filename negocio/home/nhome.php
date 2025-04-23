<?php
    namespace negocio\home;
    use presentacion\login\PLogin;

    class Nhome
    {
        private $plogin ;
        public function __construct(){
            session_start();
            $this->plogin = new PLogin();
        }
        public function index(){
            if(isset($_SESSION['signin_user'])){
                require dirname($_SERVER['DOCUMENT_ROOT'])."/prueba.php";
            }else{
                require dirname($_SERVER['DOCUMENT_ROOT'])."/presentacion/home/index.php";
            }
        }

    }