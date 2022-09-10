<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="g_config">
    <h1>Modificar Configuración</h1>
    <form action="">
        <div class="nombreCo">
            <label >Nombre de la configuración</label>
            <select>
                <option value="" disabled selected>--INGENIERÍA ELECTRÓNICA--</option>    
            </select>
            <input type="button" value="Buscar Datos">
        </div>

        <div class="modificarC">
            <div class="id">
                <label for="">Id Configuración</label>
                <input type="text">
            </div>
            <div class="nameConfig">
                <label>Cantidad Grupos </label>
                <input type="text">
            </div>
            <div class="des">
                <label>Descripción</label>
                <textarea name="" id="" cols="48" rows="5"></textarea>
            </div>
        </div>

        <div class="modificarConfig">
            <input type="submit" value="Modificar Configuración">
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>

