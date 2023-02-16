<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
?>
<main class="EstadisticasDeSolicitudes">
    <section class="w80">
        <h1>Estadísticas De Solicitudes Menú</h1>
        <div class="GU">
            <a href="/admin/Estadisticas De Solicitudes/ReportesDeSolicitudes.php">
                <ion-icon name="stats-chart-outline"></ion-icon>
                Reportes De Solicitudes
            </a>
            <a href="/admin/Estadisticas De Solicitudes/ExportarDatos.php">
                <ion-icon name="download-outline"></ion-icon>
                Exportar Datos
            </a>
            <a href="/admin/Estadisticas De Solicitudes/ImprimirSolicitudFinalizada.php">
            <ion-icon name="print-outline"></ion-icon>
                Imprimir Solicitud Finalizada
            </a>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>