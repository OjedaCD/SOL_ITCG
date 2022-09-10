<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="funcionesSec">
    <section class="w80">
        <h1>Funciones Secundarias Menu</h1>
        <div class="butts">
            <a href="/admin/Funciones Secundarias/ModifcarPromCeneval.php">
                <ion-icon name="document"></ion-icon>
                Modificar Promedio Ceneval
            </a>
            <a href="/admin/Funciones Secundarias/ModificarPromAlum.php">
                <ion-icon name="document"></ion-icon>
                Modificar Promedio Alumno
            </a>
            <a href="/admin/Funciones Secundarias/ModificarPromArchivo.php">
                <ion-icon name="document-attach"></ion-icon>
                Modificar Promedio por Archivo
            </a>
            <a href="/admin/Funciones Secundarias/RespaldoBDD.php">
                <ion-icon name="layers"></ion-icon>
                Respaldar Base de Datos
            </a>
            <a href="/admin/Funciones Secundarias/NuevoProceso.php">
                <ion-icon name="sync"></ion-icon>
                Nuevo Proceso
            </a>
            <a href="/admin/Funciones Secundarias/RegistrarNewUser.php">
                <ion-icon name="person-add"></ion-icon>
                Registrar Nuevo Usuario
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>