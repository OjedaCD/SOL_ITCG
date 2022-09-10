<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="c_grupos">
    <h1>Asignar Maestros
    </h1>
    <form action="">
        <div class="buscar">
            <label for="sel">Seleccionar Materia</label>
            <select name="" id="">
                <option value="" disabled selected>--Seleccione Materia--</option>
            </select>
            <input type="button" value="Buscar">
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>