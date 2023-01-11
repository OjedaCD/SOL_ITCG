<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
?>
<main class="GestionarUsuarios">
    <section class="w80">
        <h1>Gestionar Usuarios Menú</h1>
        <div class="GU">
            <?php if($_SESSION['idRole'] == '1'):?> 
            <a href="/admin/Gestionar Usuarios/RegistrarUsuarios.php">
                <ion-icon name="person-add-outline"></ion-icon>
                Registrar Usuarios
            </a>
            <?php endif;?>
            <?php if($_SESSION['idRole'] == '1' || $_SESSION['idRole'] == '2'|| $_SESSION['idRole'] == '4'):?> 
            <a href="/admin/Gestionar Usuarios/ConsultarUsuarios.php">
                <ion-icon name="search-sharp"></ion-icon>
                Consultar Usuarios
            </a>
            <?php endif;?>
            <?php if($_SESSION['idRole'] == '1'):?> 
            <a href="/admin/Gestionar Usuarios/ModificarUsuarios.php">
                <ion-icon name="people-outline"></ion-icon>
                Modificar Usuarios
            </a>
            <a href="/admin/Gestionar Usuarios/CambiarEstado.php">
                <ion-icon name="person-circle-outline"></ion-icon>
                Cambiar Estado de Usuarios
            </a>
            <a href="/admin/Gestionar Usuarios/RestablecerCon.php">
                <ion-icon name="refresh-circle-outline"></ion-icon>
                Restablecer Contraseña
            </a>
            <?php endif;?>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>