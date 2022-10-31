<?php
//importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

//crear un email y password
$email ="L18290910@cdguzman.tecnm.mx";
$password = "12345678";

$passwordhash = password_hash($password, PASSWORD_DEFAULT);
//Query para crear el usuario 
$query ="INSERT INTO users(idUser, email, token, nomUsuario, apellidoUsuario, telefono,edoUser, idRole,idDpto) VALUES ('1','{$email}','{$passwordhash}','Gerardo','Montelongo Contreras','3121430063','HABILITADO','1','20')";
echo $query;

//exit;
//agregar a base de datos 
$resultado =mysqli_query($db, $query);
var_dump($resultado);


$queryAcc = "INSERT INTO accesos(idUser, idRole, idDpto) VALUES ('1','1','20')";
$resultadoA =mysqli_query($db, $queryAcc);
var_dump($resultadoA);

