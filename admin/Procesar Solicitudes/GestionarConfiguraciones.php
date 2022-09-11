<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="config">
    <section class="w80">
        <h1>Gestionar Configuraciones Menu</h1>
        <div class="buttConfig">
            <a href="/admin/Gestionar Configuraciones/RegistrarConfig.php">
                <ion-icon name="cog"></ion-icon>
                Registrar Configuraciones
            </a>
            <a href="/admin/Gestionar Configuraciones/VerConfig.php">
                <ion-icon name="cog"></ion-icon>
                Ver Configuraciones
            </a>
            <a href="/admin/Gestionar Configuraciones/ModificarConfig.php">
                <ion-icon name="cog"></ion-icon>
                Modificar Configuraciones
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>