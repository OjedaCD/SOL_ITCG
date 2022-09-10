<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="g_config">
    <h1>Ver Configuración</h1>
    <form action="">
    <table class="tabla">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Detalles</th>
        </tr>
        <tr>
            <th>1</th>
            <th>ACEPTADOS</th>
            <th>Cantidad de aspirantes aceptados</th>
            <th><button>Opciones</button></th>
        </tr>
        <tr>
            <th>2</th>
            <th>CURSO</th>
            <th>Cantidad maxima de aspirantes por grupo</th>
            <th><button>Opciones</button></th>
        </tr>
    </table>
    </form>
</main>
<?php 
    inlcuirTemplate('footer');
?>

