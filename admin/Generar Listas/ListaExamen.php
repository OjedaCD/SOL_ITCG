<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="g_listas">
    <h1>Listas Examen Ceneval</h1>
    <form action="">
        <div class="btnsLista">
            <input type="button" value="Generar todas las listas" class="btnAllV">
            <input type="button" onclick="mostrarContenido();" value="Especificar lista" class="btnChoseA" >
        </div>
        <div id="todas">
            <label>Seleccionar una Carrera</label>
            <select name="" id="">
                <option value="" disabled selected>--INGENIERÍA ELECTRÓNICA--</option>
            </select>
            <input type="button" value="Generar Lista">
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>



