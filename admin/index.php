<?php  
    require "../includes/funciones.php";
    $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="admin">
    
    <section class="w80">
        <h1>Bienvenido a Admin</h1>
        <div class="botones">
            <a href="/admin/Importar Datos/ImportarDatos.php">
                <ion-icon name="cloud-upload-outline"></ion-icon>
                Importar Datos
            </a>
            <a href="/admin/Gestionar Grupos/GestionarGrupos.php">
                <ion-icon name="people-outline"></ion-icon>
                Gestionar Grupos
            </a>
            <a href="/admin/Generar Listas/GenerarListas.php">
                <ion-icon name="document-text-outline"></ion-icon>
                Generar Listas
            </a>
            <a href="/admin/Gestionar Calificaciones/GestionarCal.php">
                <ion-icon name="clipboard-outline"></ion-icon>
                Gestionar Calificaciones
            </a>
            <a href="/admin/Gestionar Configuraciones/GestionarConfiguraciones.php">
                <ion-icon name="cog"></ion-icon>
                Gestionar Configuraciones
            </a>
            <a href="/admin/Funciones Secundarias/FuncionesSec.php">
                <ion-icon name="layers"></ion-icon>
                Funciones Secundarias
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>