<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');

?>
<main class="ModificarSolicitud">
    <section class="w80">
        <h1>Reportes</h1>
        
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>