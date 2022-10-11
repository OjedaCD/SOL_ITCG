<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="config">
    <section class="w80">
        <h1>Procesar Solicitudes Menu</h1>
        <div class="PS">
            <a href="/admin/Procesar Solicitudes/CrearNuevaSolicitud.php">
                <ion-icon name="cog"></ion-icon>
                Crear Nueva Solicitud
            </a>
            <a href="/admin/Procesar Solicitudes/VerEstadoSolicitud.php">
                <ion-icon name="cog"></ion-icon>
                Ver Estado de solicitudes enviadas
            </a>
            <a href="/admin/Procesar Solicitudes/ModificarSolicitud.php">
                <ion-icon name="cog"></ion-icon>
                Modificar Solicitud
            </a>
            <a href="/admin/Procesar Solicitudes/CancelarSolicitudPendiente.php">
                <ion-icon name="cog"></ion-icon>
                Cancelar Solicitud Pendiente 
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>