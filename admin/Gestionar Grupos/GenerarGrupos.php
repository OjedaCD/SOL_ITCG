<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="c_grupos">
    <h1>Crear Grupos</h1>
    <button>
        Automáticamente
    </button>
</main>
<?php 
    inlcuirTemplate('footer');
?>