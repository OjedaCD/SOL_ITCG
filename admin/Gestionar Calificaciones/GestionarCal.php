<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="gestionarCal">
    <section class="w80">
        <h1>Gestionar Calificaciones Menu</h1>
        <div class="buttGes">
            <a href="/admin/Gestionar Calificaciones/RegistrarCal.php">
                <ion-icon name="document"></ion-icon>
                Registrar Calificaciones
            </a>
            <a href="/admin/Gestionar Calificaciones/VerCalificaciones.php">
                <ion-icon name="reader"></ion-icon>
                Ver Calificaciones
            </a>
            <a href="/admin/Gestionar Calificaciones/ModificarCal.php">
                <ion-icon name="document-text"></ion-icon>
                Modificar Calificaciones
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>