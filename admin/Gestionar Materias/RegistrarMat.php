<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="registrarMat">
    <section class="w80">
        <h1>Registrar Materia</h1>
        <form>
            <div class="Materia">
                <label for="materia">Nombre de Materia</label>
                <input type="text" name="materia" id="materia">
            </div>
            <div class="button">
                <input type="submit" value="Registrar">
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>