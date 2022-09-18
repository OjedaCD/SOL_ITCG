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
            <a href="/admin/Gestionar Usuarios/RegistrarUsuarios.php">
                <ion-icon name="person-add-outline"></ion-icon>
                Registrar Usuarios
            </a>
            <a href="/admin/Gestionar Usuarios/ConsultarUsuarios.php">
                <ion-icon name="search-sharp"></ion-icon>
                Consultar Usuarios
            </a>
            <a href="/admin/Gestionar Usuarios/CancelarUsuarios.php">
                <ion-icon name="person-remove-outline"></ion-icon>
                Cancelar Usuarios
            </a>
            <a href="/admin/Gestionar Usuarios/ModificarUsuarios.php">
                <ion-icon name="people-outline"></ion-icon>
                Modificar Usuarios
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>