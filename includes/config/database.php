<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost:3307', 'root', '', 'sol_itcg');
    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    return $db;
}