<?php

namespace presentacion\menu;

class PMenu
{
    public function __construct(){
        session_start();
    }

    public function renderMenu(){
        $menu = '';
    }
    public function index(){
        require ('menu.php');
    }
}