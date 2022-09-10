<?php

require 'app.php';

function inlcuirTemplate (string $nombre, bool $inicio=false){
    include TEMPLATES_URL . "/${nombre}.php"; 
}

function estaAutenticado() : bool{
    session_start();
    $auth = $_SESSION['login'];
    if ($auth) {
        return true;
    }
    return false;
}