<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="g_listas">
    <h1>Listas del Curso de Introducción</h1>
    <form action="">
        <div class="btnsLista">
            <input type="button" onclick="mostrarContenido();" value="Generar todas las listas por materia" class="btnChoseV">
            <input type="button" onclick="mostrarContenido2();" value="Especificar lista" class="btnChoseA" >
        </div>
        <div id="todas">
            <label>Selecciona una Materia</label>
            <select name="" id="">
                <option value="" disabled selected>--MATEMÁTICAS--</option>
            </select>
            <input type="button" value="Generar" class="btnGenerar">
        </div>


        <div id="especifica">
            <div class="carrera">
                <label for="">Selecciona una Carrera</label>
                <select>
                    <option value="" disabled selected>--INGENIERÍA ELECTRÓNICA--</option>    
                </select>
            </div>
            <div class="materia">
                <label for="">Selecciona una Materia</label>
                <select>
                    <option value="" disabled selected>--MATEMÁTICAS--</option>    
                </select>
            </div>
            <div class="grupo">
                <label for="">Letra Grupo</label>
                <select>
                    <option value="" disabled selected>--A--</option>    
                </select>
            </div>
            <input type="button" value="Generar">
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>



