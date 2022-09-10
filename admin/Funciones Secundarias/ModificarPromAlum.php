<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="modPromCen">
    <section class="w80">
        <h1>Modificar Promedio Alumno</h1>
        <form>
            <div class="numFicha">
                <label for="numFicha">Número de Ficha: </label>
                <input type="number" name="numFicha" id="numFicha">
            </div>
            <div class="nomAlumno">
                <label for="nomAlumno">Nombre: </label>
                <input type="text" name="nomAlumno" id="nomAlumno" disabled>
            </div>
            <div class="prom">
                <label for="prom">Promedio: </label>
                <input type="number" name="prom" id="prom">
            </div>
            <div class="but">
                <input type="submit" value="Enviar">
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>