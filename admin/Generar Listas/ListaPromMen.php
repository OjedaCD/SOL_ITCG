<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="g_listas">
    <h1>Lista de Aspirantes cuyo promedio de Bachillerato es menor a 60</h1>
    <form action="">
        <div class="btnsLista">
            <input type="button" value="Generar" class="btnAllV">
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>



