<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="c_grupos">
    <h1>Grupos</h1>
    <form action="">
        <div class="buscarC">
            <label for="sel">Seleccionar Carrera</label>
            <select name="" id="">
                <option value="" disabled selected>--Seleccione Carrera--</option>
            </select>
            <input type="button" value="Buscar">
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>