<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="ProcesarSolicitudes">
    <section class="w80">
        <h1>Procesar Solicitudes Menú</h1>
        <div class="PS">
            <a href="/admin/Procesar Solicitudes/CrearNuevaSolicitud.php">
                <ion-icon name="document-outline"></ion-icon>
                Crear Nueva Solicitud
            </a>
            <a href="/admin/Procesar Solicitudes/SolicitudesCC.php">
                <ion-icon name="globe-outline"></ion-icon>
                Solicitudes Centro de Cómputo
            </a>
            <a href="/admin/Procesar Solicitudes/SolicitudesME.php">
                <ion-icon name="hammer-outline"></ion-icon>
                Solicitudes Mantenimiento de Equipo
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>