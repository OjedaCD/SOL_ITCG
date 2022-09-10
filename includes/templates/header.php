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
    <title>Siseni</title>
</head>

<header>   
    <img class="sep" src="/build/img/sep.webp" alt="Logo SEP">
    <div class="text_header">
        <h1>TECNOLÓGICO NACIONAL DE MÉXICO</h1>
        <h2>INSTITUTO TECNOLÓGICO DE CIUDAD GUZMÁN</h2>
        <H3>Sistema de Selección de Nuevo Ingreso</H3>
    </div>
    <img class="itcg" src="/build/img/itcg.webp" alt="Logo ITCG">
    <img class="tecnm" src="/build/img/tecnm.webp" alt="Logo Tecnm">
</header>
<div class="header">
    <ul class="nav">
        <li><a href="/admin/index.php">Inicio</a></li>
        <li><a href="/admin//Importar Datos/ImportarDatos.php">Importar Datos</a>
            <ul>
                <li><a href="/admin/Importar Datos/Aspirantes.php">Importar Datos de Aspirantes</a></li>
                <li><a href="/admin/Importar Datos/Registrados.php">Imporatr Registros Sustentables</a></li>
                <li><a href="/admin/Importar Datos/Ceneval.php">Importar Datos del Ceneval</a></li>
            </ul>
        </li>
        <li><a href="/admin/Gestionar Grupos/GestionarGrupos.php">Gestionar Grupos</a>
            <ul>
                <li><a href="/admin/Gestionar Grupos/GenerarGrupos.php">Generar Grupos Automáticamente</a></li>
                <li><a href="/admin/Gestionar Grupos/AsignarMaestros.php">Asignar Maestros para el curso de Introducción</a></li>
                <li><a href="/admin/Gestionar Grupos/ModificarMaestros.php">Modificar la asignación de maestros para el curso de introducción </a></li>
                <li><a href="/admin/Gestionar Grupos/VerGrupos.php">Ver grupos por carrera </a></li>
            </ul>
        </li>
        <li><a href="/admin/Generar Listas/GenerarListas.php">Generar Listas</a>
            <ul>
                <li><a href="/admin/Generar Listas/ListaExamen.php">Listas de examen Ceneval</a></li>
                <li><a href="/admin/Generar Listas/ListaCursoIntro.php">Listas del curso de introducción </a></li>
                <li><a href="/admin/Generar Listas/ListaPromMen.php">Lista cuyo promedio de bachillerato es menor a 60 </a></li>
                <li><a href="/admin/Generar Listas/ListaAceptados.php">Listas de aceptados </a></li>
            </ul>
        </li>
        <li><a href="/admin/Gestionar Calificaciones/GestionarCal.php">Gestionar Calificaciones</a>
            <ul>
                <li><a href="/admin/Gestionar Calificaciones/RegistrarCal.php">Registrar calificaciones</a></li>
                <li><a href="/admin/Gestionar Calificaciones/VerCalificaciones.php">Ver calificaciones </a></li>
                <li><a href="/admin/Gestionar Calificaciones/ModificarCal.php">Modificar calificaciones </a></li>
            </ul>
        </li>
        <li><a href="/admin/Gestionar Configuraciones/GestionarConfiguraciones.php">Gestionar Configuraciones</a>
            <ul>
                <li><a href="/admin/Gestionar Configuraciones/RegistrarConfig.php">Registrar configuración </a></li>
                <li><a href="/admin/Gestionar Configuraciones/VerConfig.php">Ver configuraciones </a></li>
                <li><a href="/admin/Gestionar Configuraciones/ModificarConfig.php">Modificar configuración </a></li>
            </ul>
        </li>
        <li><a href="/admin/Gestionar Materias/GestionarMat.php">Gestionar Materias</a>
            <ul>
                <li><a href="/admin/Gestionar Materias/RegistrarMat.php">Registrar una nueva Materia</a></li>
                <li><a href="/admin/Gestionar Materias/ModificarMat.php">Modificar materia</a></li>
            </ul>
        </li>
        <li><a href="/admin/Funciones Secundarias/FuncionesSec.php">Funciones Secundarias</a>
            <ul>
                <li><a href="/admin/Funciones Secundarias/ModifcarPromCeneval.php">Modificar promedio de examen Ceneval</a></li>
                <li><a href="/admin/Funciones Secundarias/ModificarPromAlum.php">Modificar promedio del aspirante</a></li>
                <li><a href="/admin//Funciones Secundarias/ModificarPromArchivo.php">Modificar promedios a partir de un archivo </a></li>
                <li><a href="/admin/Funciones Secundarias/RespaldoBDD.php">Crear respaldo de la Base de Datos</a></li>
                <li><a href="/admin/Funciones Secundarias/NuevoProceso.php">Nuevo proceso</a></li>
                <li><a href="/admin/Funciones Secundarias/RegistrarNewUser.php">Registrar un nuevo usuario</a></li>
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