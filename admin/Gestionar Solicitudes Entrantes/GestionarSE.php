<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
?>
<main class="GestionarSolicitudesEntrantes">
    <section class="w80">
        <h1>Gestionar Solicitudes Entrantes Menú</h1>
        <div class="GU">
            <a href="/admin/Gestionar Solicitudes Entrantes/SolicitudesPendientes.php">
                <ion-icon name="eye-outline"></ion-icon>
                Solicitudes Pendientes
            </a>
            <a href="/admin/Gestionar Solicitudes Entrantes/SolicitudesEnProceso.php">
                <ion-icon name="checkmark-done-outline"></ion-icon>
                Solicitudes En Proceso
            </a>
            <a href="/admin/Gestionar Solicitudes Entrantes/SolicitudesFinalizadas.php">
                <ion-icon name="document-attach-outline"></ion-icon>
                Solicitudes Finalizadas 
            </a>
            <a href="/admin/Gestionar Solicitudes Entrantes/TableroDeSolicitudes.php">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
                Tablero De Solicitudes
            </a>
            <a href="/admin/Gestionar Solicitudes Entrantes/ReportesDeSolicitudes.php">
                <ion-icon name="stats-chart-outline"></ion-icon>
                Reportes De Solicitudes
            </a>
            <a href="/admin/Gestionar Solicitudes Entrantes/ImprimirSolicitudFinalizada.php">
            <ion-icon name="print-outline"></ion-icon>
                Imprimir Solicitud Finalizada
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>