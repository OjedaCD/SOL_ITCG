<?php  
    require "../includes/funciones.php";
    $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="admin">
    
    <section class="w80">
        <h1>Bienvenido a SOL_ITCG</h1>
        <div class="botones">
            <a href="/admin/Gestionar Usuarios/GestionarUsuarios.php">
                <ion-icon name="person-circle-sharp"></ion-icon>
                Gestionar Usuarios
            </a>
            <a href="/admin/Procesar Solicitudes/ProcesarSolicitudes.php">
                <ion-icon name="clipboard"></ion-icon>
                Procesar Solicitudes
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>