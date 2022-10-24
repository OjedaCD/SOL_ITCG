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
            <a href="/admin/Gestionar Solicitudes Entrantes/VerSolicitudesEntrantes.php">
                <ion-icon name="eye-outline"></ion-icon>
                Ver Solicitudes Entrantes
            </a>
            <a href="/admin/Gestionar Solicitudes Entrantes/TableroKanban.php">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
                Tablero Kanban
            </a>
            <a href="/admin/Gestionar Solicitudes Entrantes/CancelarSolicitudes.php">
                <ion-icon name="close-circle-outline"></ion-icon>
                Cancelar Solicitud
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>