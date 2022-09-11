<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
?>
<main class="gestionarCal">
    <section class="w80">
        <h1>Gestionar Calificaciones Menu</h1>
        <div class="buttGes">
            <a href="/admin/Gestionar Usuarios/AgregarUsuario.php">
                <ion-icon name="document"></ion-icon>
                Agregar Usuario
            </a>
            <a href="/admin/Gestionar Usuarios/ConsultarUsuarios.php">
                <ion-icon name="document"></ion-icon>
                Consultar Usuarios
            </a>
            <a href="/admin/Gestionar Usuarios/EliminarUsuario.php">
                <ion-icon name="document"></ion-icon>
                Eliminar Usuario
            </a>
            <a href="/admin/Gestionar Usuarios/ModificarUsuario.php">
                <ion-icon name="document"></ion-icon>
                Modificar Usuario
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>