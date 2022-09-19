<?php
//importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

//crear un email y password
$email ="L18290915@cdguzman.tecnm.mx";
$password = "12345678";

$passwordhash = password_hash($password, PASSWORD_DEFAULT);
//Query para crear el usuario 
$query ="INSERT INTO users(idUser, email, token, nomUsuario, apellidoUsuario, telefono, idRole) VALUES ('1','{$email}','{$passwordhash}','David','Ojeda Cortes','3421080534','1')";
echo $query;

//exit;
//agregar a base de datos 
$resultado =mysqli_query($db, $query);
var_dump($resultado);


$queryPer = "INSERT INTO pertenencias(idUser, idDpto) VALUES ('1','20')";
$resultadoP =mysqli_query($db, $queryPer);
var_dump($resultadoP);



$queryAcc = "INSERT INTO accesos(idUser, idRole) VALUES ('1','1')";
$resultadoA =mysqli_query($db, $queryAcc);
var_dump($resultadoA);