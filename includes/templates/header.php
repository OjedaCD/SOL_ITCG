<?php 
    if (!isset($_SESSION)) {
        session_start();
    }
    $auth = $_SESSION['login'] ?? false;
    ob_start();
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
<?php 
    $rol = $_SESSION['idRole'];
?>
<div class="header">
    <ul class="nav">
        <?php if($rol == 1 || $rol == 2):?>
        <li><a href="/admin/index.php">Inicio</a></li>
        <li><a href="/admin/Gestionar Usuarios/GestionarUsuarios.php">Gestionar Usuarios</a>
            <ul>
                <?php if($rol == 1 ):?>
                <li><a href="/admin/Gestionar Usuarios/RegistrarUsuarios.php">Registrar Usuarios</a></li>
                <?php endif;?>
                <?php if($rol == 1 || $rol == 2):?>
                <li><a href="/admin/Gestionar Usuarios/ConsultarUsuarios.php">Consultar Usuarios</a></li>
                <?php endif;?>
                <?php if($rol == 1 ):?>
                <li><a href="/admin/Gestionar Usuarios/ModificarUsuarios.php">Modificar Usuarios</a></li>
                <li><a href="/admin/Gestionar Usuarios/CambiarEstado.php">Cambiar Estado de Usuarios</a></li>
                <li><a href="/admin/Gestionar Usuarios/RestablecerContraseña.php">Restablecer Contraseña</a></li>
                <?php endif;?>
            </ul>
        </li>
        <?php endif;?>

        <li><a href="/admin/Procesar Solicitudes/ProcesarSolicitudes.php">Procesar Solicitudes</a>
            <ul>
                <li><a href="/admin/Procesar Solicitudes/CrearNuevaSolicitud.php">Crear Nueva Solicitud</a></li>
                <li><a href="/admin/Procesar Solicitudes/VerEstadoEtapaSolicitud.php">Ver Estado o Etapa de Solicitud</a></li>
                <li><a href="/admin/Procesar Solicitudes/ModificarSolicitudRechazada.php">Modificar Solicitud Rechazada</a></li>
                <li><a href="/admin/Procesar Solicitudes/CancelarSolicitudPendiente.php">Cancelar Solicitud Pendiente</a></li>
            </ul>
        </li>


        <li><a href="/admin/Gestionar Solicitudes Entrantes/GestionarSE.php">Gestionar Solicitudes Entrantes</a>
            <ul>
                <li><a href="/admin/Gestionar Solicitudes Entrantes/VerSolicitudesEntrantes.php">Ver Solicitudes Entrantes</a></li>
                <li><a href="/admin/Gestionar Solicitudes Entrantes/SolicitudesAceptadas.php">Solicitudes Aceptadas</a></li>
                <li><a href="/admin/Gestionar Solicitudes Entrantes/TableroKanban.php">Tablero Kanban</a></li>
                <li><a href="/admin/Gestionar Solicitudes Entrantes/Reportes.php">Reportes de Solicitudes</a></li>
            </ul>
        </li>


        <li><a href="">Opciones</a>
            <ul>
                <li><?php if ($auth): ?>
                            <a href="/cerrar-sesion.php">Cerrar Sesión</a>
                    <?php endif;?>
                </li>
                <li><a href="/admin/Respadar Datos/RespaldoBDD.php">Descargar BD</a></a></li>
                <li><a href="/admin/Respadar Datos/NuevoProceso.php">Iniciar nuevo proceso</a></a></li>
            
            </ul>
        </li>
    </ul>
</div>