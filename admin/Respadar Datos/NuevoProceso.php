<?php

use function PHPSTORM_META\map;

    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }

    if ($_SERVER['REQUEST_METHOD']==="POST") {
        $db = conectarDB();
        $queryDet= "DELETE FROM detalles;";
        $querySol= "DELETE FROM solicitudes;";
        $resultadoDet= mysqli_query($db,$queryDet); 
        $resultadoSol = mysqli_query($db,$querySol); 

        if ($resultadoSol  && $resultadoDet) {
            header('location: /admin/index.php'); 
            die();
        }
    }
    inlcuirTemplate('header');
?>
<main class="nuevoProceso">
    <section class="w80">
        <form method="post" id="nuevoProc">
            <h1>Nuevo Proceso</h1>
            <input type="button" value="Iniciar Nuevo Proceso" onclick="borrarDatos('#nuevoProc');">
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>