<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="g_listas">
    <h1>Listas de Aceptados</h1>
    <form action="">
        <div id="elementos">
            <div class="fila">
                <label for="" class="izquierda">Fecha de inicio</label>
                <input type="date" value="Fecha de inicio" class="izqInput">
                <label for="" class="derecha">Intervalo de tiempo Atendiendo</label>
                <select name="" id="">
                    <option value="" disabled selected>--5 minutos--</option>
                </select>
            </div>
            <div class="fila">
                <label for="" class="izquierda">Hora de inicio</label>
                <input type="time" value="Fecha de inicio" class="izqInput">
                <label for="" class="derecha">Hora de Terminación</label>
                <input type="time" value="Intervalo de tiempo Atendiendo" class="derInput">
            </div>
            <div class="fila">
                <label for="" class="izquierda">Inicio de Hora de Descanso</label>
                <input type="time" value="Fecha de inicio" class="izqInput">
                <label for="" class="derecha">Terminación de Hora de Descanso</label>
                <input type="time" value="Intervalo de tiempo Atendiendo" class="derInput">
            </div>
        </div>
        
        <div class="carreras">
            <label>Selecciona una carrera</label>
            <select name="" id="">
                <option value="" disabled selected>--INGENIERÍA ELECTRÓNICA--</option>
            </select>
        </div>

        <div class="opciones">
            <label>Ligar Carreras</label>
            <ion-icon name="duplicate-sharp"></ion-icon>
            <select name="" id="">
                <option value="" disabled selected>--INGENIERÍA ELECTRÓNICA--</option>
            </select>
            
        </div>

        <div class="modal">
            <input type="button" value="Generar Lista">
        </div>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>
