<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="ModificarMat">
    <section class="w80">
        <h1>Modificar Materia</h1>
        <form>
            <div class="Materia">
                <label for="materia">Seleccionar Matera</label>
                <select name="materia" id="materia">
                    <option value="" disabled selected>--Selecione Materia--</option>
                </select>
            </div>
            <div class="MateriaN">
                <label for="materia">Nuevo Nombre</label>
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