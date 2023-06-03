<?php

require 'app.php';

function inlcuirTemplate (string $nombre, bool $inicio=false){
    include TEMPLATES_URL . "/${nombre}.php"; 
}// Aqui se manda a llamar el template con la  funcion 

function estaAutenticado() : bool{
    session_start();
    $auth = $_SESSION['login']?? null;
    if ($auth) {
        return true;
    }
    return false;
}