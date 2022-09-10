<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="g_config">
    <h1>Registrar Configuración</h1>
    <form action="">
        <div class="nombre">
            <label >Nombre de la configuración</label>
            <input type="text" value="">
        </div>
        <div class="descripcion">
            <label >Descripción</label>
            <textarea name="" id="" cols="48" rows="5"></textarea>
        </div>
        <div class="parametros">
            <div class="carrera">
                <label for="">Carrera</label>
                <select>
                    <option value="" disabled selected>--INGENIERÍA ELECTRÓNICA--</option>    
                </select>
            </div>
            <div class="cantidadG">
                <label>Cantidad Grupos </label>
                <input type="number">
            </div>
            <div class="cantidadXG">
                <label>Cantidad por Grupo</label>
                <input type="number">
            </div>
            <div class="btnAgregar">
                <input type="submit" value="Agregar">
            </div>            
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>

