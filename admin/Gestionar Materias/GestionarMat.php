<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="gestionarMat">
    <section class="w80">
        <h1>Gestionar Materias Menu</h1>
        <div class="buttons">
            <a href="/admin/Gestionar Materias/RegistrarMat.php">
                <ion-icon name="document"></ion-icon>
                Registrar Materia
            </a>
            <a href="/admin/Gestionar Materias/ModificarMat.php">
                <ion-icon name="create"></ion-icon>
                Modificar Materia
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>