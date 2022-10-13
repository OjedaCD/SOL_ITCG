<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="ProcesarSolicitudes">
    <section class="w80">
        <h1>Procesar Solicitudes Menu</h1>
        <div class="PS">
            <a href="/admin/Procesar Solicitudes/CrearNuevaSolicitud.php">
                <ion-icon name="document-outline"></ion-icon>
                Crear Nueva Solicitud
            </a>
            <a href="/admin/Procesar Solicitudes/VerEstadoSolicitud.php">
                <ion-icon name="copy-outline"></ion-icon>
                Ver Estado de solicitudes enviadas
            </a>
            <a href="/admin/Procesar Solicitudes/ModificarSolicitud.php">
                <ion-icon name="newspaper-outline"></ion-icon>
                Modificar Solicitud
            </a>
            <a href="/admin/Procesar Solicitudes/CancelarSolicitudPendiente.php">
                <ion-icon name="close-circle-outline"></ion-icon>
                Cancelar Solicitud Pendiente 
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>