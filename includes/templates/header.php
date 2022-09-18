<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;
?>


<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/app.css">
    <title>SOL_ITCG</title>
</head>

<header>   
    <img class="sep" src="/build/img/sep.webp" alt="Logo SEP">
    <div class="text_header">
        <h1>TECNOLÓGICO NACIONAL DE MÉXICO</h1>
        <h2>INSTITUTO TECNOLÓGICO DE CIUDAD GUZMÁN</h2>
        <H3>Sistema de Solicitudes de Mantenimiento</H3>
    </div>
    <img class="itcg" src="/build/img/itcg.webp" alt="Logo ITCG">
    <img class="tecnm" src="/build/img/tecnm.webp" alt="Logo Tecnm">
</header>
<div class="header">
    <ul class="nav">
        <li><a href="/admin/index.php">Inicio</a></li>
        <li><a href="/admin//Gestionar Usuarios/GestionarUsuarios.php">Gestionar Usuarios</a>
            <ul>
                <li><a href="/admin/Gestionar Usuarios/RegistrarUsuarios.php">Registrar Usuarios</a></li>
                <li><a href="/admin/Gestionar Usuarios/ConsultarUsuarios.php">Consultar Usuarios</a></li>
                <li><a href="/admin/Gestionar Usuarios/ModificarUsuarios.php">Modificar Usuarios</a></li>
                <li><a href="/admin/Gestionar Usuarios/CancelarUsuarios.php">Cancelar Usuarios</a></li>
            </ul>
        </li>
        
        <li><a href="">Opciones</a>
            <ul>
                <li><?php if ($auth): ?>
                            <a href="/cerrar-sesion.php">Cerrar Sesión</a>
                    <?php endif;?>
                </li>
            </ul>
        </li>
    </ul>
</div>