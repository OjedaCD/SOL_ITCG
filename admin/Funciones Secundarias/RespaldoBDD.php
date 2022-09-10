<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="RespaldoBDD">
    <section class="w80">
        <h1>Respaldar Base de Datos</h1>
        <button>Crear Respaldo</button>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>