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
        <h1>Bienvenido a Admin</h1>
        <div class="botones">
            <a href="/admin/Gestionar Usuarios/GestionarUsuarios.php">
                <ion-icon name="person-circle-sharp"></ion-icon>
                Gestionar Usuarios
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>