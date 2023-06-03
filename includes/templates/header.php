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
    <link rel="stylesheet" href="/sol_itcg/build/css/app.css">
    <title>SOL_ITCG</title>
</head>

<header>   
    <div class="logos">
        <div class="logosin">
            <img class="sep" src="/sol_itcg/build/img/sep.webp" alt="Logo SEP">
            <div class="v-line1"></div>
            <img class="tecnm" src="/sol_itcg/build/img/tecnm.webp" alt="Logo Tecnm">
            <div class="v-line2"></div>
            <img class="itcg" src="/sol_itcg/build/img/itcg.webp" alt="Logo ITCG">
        </div>
    </div>
    <div class="text_header">
        <h1>Sistema de Solicitudes de Mantenimiento</31>
    </div>
    
</header>
<?php 
    $rol = $_SESSION['idRole'] ?? null;
    $dpto = $_SESSION['idDpto'] ?? null;
?>
<div class="header">

    <div class="usuario" >
    <a href="/sol_itcg/admin/Opciones/VerCuenta.php">
        <span title="<?php echo $_SESSION['nombre'] ?? null;?>">
            <ion-icon name="person-circle"></ion-icon>
        </span>
    </a>    
    </div>
    <ul class="nav">
        <li><a href="/sol_itcg/admin/index.php">Inicio</a></li>
        <?php if($rol == 1 && $dpto == 20|| $rol == 2|| $rol == 4):?>
        <li><a href="/sol_itcg/admin/Gestionar Usuarios/GestionarUsuarios.php">Gestionar Usuarios</a>
            <ul>
                <?php if($rol == 1 && $dpto == 20):?>
                <li><a href="/sol_itcg/admin/Gestionar Usuarios/RegistrarUsuarios.php">Registrar Usuarios</a></li>
                <?php endif;?>
                <?php if($rol == 1 && $dpto == 20 || $rol == 2|| $rol == 4):?>
                <li><a href="/sol_itcg/admin/Gestionar Usuarios/ConsultarUsuarios.php">Consultar Usuarios</a></li>
                <?php endif;?>
                <?php if($rol == 1 && $dpto == 20):?>
                <li><a href="/sol_itcg/admin/Gestionar Usuarios/ModificarUsuarios.php">Modificar Usuarios</a></li>
                <li><a href="/sol_itcg/admin/Gestionar Usuarios/CambiarEstado.php">Cambiar Estado de Usuarios</a></li>
                <li><a href="/sol_itcg/admin/Gestionar Usuarios/RestablecerCon.php">Restablecer Contraseña</a></li>
                <?php endif;?>
            </ul>
        </li>
        <?php endif;?>
        <?php if($rol == 3 ):?>
        <li><a href="/sol_itcg/admin/Procesar Solicitudes/ProcesarSolicitudes.php">Procesar Solicitudes</a>
            <ul>
                <li><a href="/sol_itcg/admin/Procesar Solicitudes/CrearNuevaSolicitud.php">Crear Nueva Solicitud</a></li>
                <li><a href="/sol_itcg/admin/Procesar Solicitudes/SolicitudesCC.php">Solicitudes Centro de Cómputo</a></li>    
                <li><a href="/sol_itcg/admin/Procesar Solicitudes/SolicitudesME.php">Solicitudes Mantenimiento de Equipo</a></li> 
            </ul>
        </li>
        <?php endif;?>
        <?php if($rol == 1 && $dpto == 20|| $rol == 2 || $rol == 4):?>
        <li><a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/GestionarSE.php">Gestionar Solicitudes Entrantes</a>
            <ul>
                <li><a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/SolicitudesPendientes.php">Solicitudes Pendientes</a></li>
                <li><a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/SolicitudesEnProceso.php">Solicitudes En Proceso</a></li>
                <li><a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/SolicitudesFinalizadas.php">Solicitudes Finalizadas </a></li>
                <li><a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/TableroDeSolicitudes.php">Tablero De Solicitudes</a></li>
            </ul>
        </li>
        <li><a href="/sol_itcg/admin/Estadisticas De Solicitudes/EstadisticasDS.php">Estadísticas De Solicitudes</a>
            <ul>
                <li><a href="/sol_itcg/admin/Estadisticas De Solicitudes/ReportesDeSolicitudes.php">Reportes de Solicitudes</a></li>
                <li><a href="/sol_itcg/admin/Estadisticas De Solicitudes/ExportarDatos.php">Exportar Datos</a></li>
                <li><a href="/sol_itcg/admin/Estadisticas De Solicitudes/ImprimirSolicitudFinalizada.php">Imprimir Solicitud Finalizada</a></li>
            </ul>
        </li>
        <?php endif;?>

        <?php if($rol == 5):?>
        <li><a href="/sol_itcg/admin/Atender Solicitudes/Atender Solicitudes.php">Atender Solicitudes</a>
            <ul>
                <li><a href="/sol_itcg/admin/Atender Solicitudes/SolicitudesMenu.php">Solicitudes Menú</a></li>
            </ul>
        </li>
        <?php endif;?>

        <li><a href="">Opciones</a>
            <ul>
                <li><?php if ($auth): ?>
                            <a href="/sol_itcg/cerrar-sesion.php">Cerrar Sesión</a>
                    <?php endif;?>
                </li>
                <?php if($rol == 1 && $dpto == 20):?>
                <li><a href="/sol_itcg/admin/Opciones/RespaldoBDD.php">Respaldar Base de Datos</a></a></li>
                <li><a href="/sol_itcg/admin/Opciones/NuevoProceso.php">Iniciar nuevo proceso</a></a></li>
                <?php endif;?>
                <li><a href="/sol_itcg/admin/Opciones/VerCuenta.php">Ver Cuenta</a></li>
            </ul>
        </li>
    </ul>
</div>