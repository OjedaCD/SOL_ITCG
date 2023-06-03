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
            <a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/SolicitudesPendientes.php">
                <ion-icon name="eye-outline"></ion-icon>
                Solicitudes Pendientes
            </a>
            <a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/SolicitudesEnProceso.php">
                <ion-icon name="checkmark-done-outline"></ion-icon>
                Solicitudes En Proceso
            </a>
            <a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/SolicitudesFinalizadas.php">
                <ion-icon name="document-attach-outline"></ion-icon>
                Solicitudes Finalizadas 
            </a>
            <a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/TableroDeSolicitudes.php">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
                Tablero De Solicitudes
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>