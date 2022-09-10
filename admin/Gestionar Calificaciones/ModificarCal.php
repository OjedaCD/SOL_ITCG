<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="registrarCal">
    <section>
        <h1>Modificar Calificaciones</h1>
        <form>
            <div class="linea">
                <div class="carrera">
                    <label for="">Selecciona Carrera</label>
                    <select name="carreraS" id="carreraS">
                        <option value="" disabled selected>--Seleccione Carrera--</option>    
                    </select>
                </div>
                <div class="materia">
                    <label for="">Selecciona Materia</label>
                    <select name="materiaS" id="materiaS">
                        <option value="" disabled selected>--Seleccione Materia--</option>    
                    </select>
                </div>
                <div class="grupo">
                    <label for="">Grupo</label>
                    <select name="GrupoS" id="GrupoS">
                        <option value="" disabled selected>--Seleccione Grupo--</option>    
                    </select>
                </div>
                <input type="button" value="Buscar">
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>