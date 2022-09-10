<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="lista">
    <section class="w80">
        <h1>Generar Listas Menu</h1>
        <div class="buttLista">
            <a href="/admin/Generar Listas/ListaExamen.php">
                <ion-icon name="document-text-outline"></ion-icon>
                Listas Examen Ceneval
            </a>
            <a href="/admin/Generar Listas/ListaCursoIntro.php">
                <ion-icon name="document-text-outline"></ion-icon>
                Listas del Curso de Introducción
            </a>
            <a href="/admin/Generar Listas/ListaPromMen.php">
                <ion-icon name="document-text-outline"></ion-icon>
                Lista de Aspirantes cuyo promedio de Bachillerato es menor a 60
            </a>
            <a href="/admin/Generar Listas/ListaAceptados.php">
                <ion-icon name="document-text-outline"></ion-icon>
                Listas de Aceptados
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>