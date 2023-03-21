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
            <a href="/admin/Atender Solicitudes/SolicitudesMenu.php">
                <ion-icon name="list-outline"></ion-icon>
                Solicitudes Menú
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>