<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost:8080', 'root', '', 'sigacitc_siseni');
    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    return $db;
}