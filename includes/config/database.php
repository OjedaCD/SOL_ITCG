<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost', 'sigacitc_sol_itcg', 'Solitcg2022', 'sigacitc_sol_itcg');
    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    return $db;
}