<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="nuevoProceso">
    <section class="w80">
        <h1>Nuevo Proceso</h1>
        <button>Iniciar Nuevo Proceso</button>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>