<?php //Metódo de header  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<div class="contenedor">
	<div class="enunciado">
        <p>Importar datos del Ceneval</p>
    </div>
	<br>
	<p>Importar Archivo: </p>
	<div class="funciones">
		<label for="importA">Seleccionar archivo</label>
		<input class = "archivo" type="file" name = "importA" id="importA">
		<h4 id="nombre"></h4>

		<div>
			<button id="btnImport">Importar datos</button>
		</div>
	</div>
</div>

<?php //Metódo de footer
    inlcuirTemplate('footer');
?>
