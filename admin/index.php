<?php  
    require "../includes/funciones.php";
    $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<?php
    $dpto = $_SESSION['idDpto'] ?? null;
    $rol = $_SESSION['idRole'] ?? null;
?>

<main class="admin">
    
    <section class="w80">
        <h1>Bienvenido a SOL_ITCG</h1>
        <div class="botones">
            <?php if($rol == 1 && $dpto == 20|| $rol == 2|| $rol== 4):?>  
            <a href="/sol_itcg/admin/Gestionar Usuarios/GestionarUsuarios.php">
                <ion-icon name="person-circle-sharp"></ion-icon>
                Gestionar Usuarios
            </a>
            <?php endif;?>
            <?php if($rol == 3):?> 
            <a href="/sol_itcg/admin/Procesar Solicitudes/ProcesarSolicitudes.php">
                <ion-icon name="clipboard"></ion-icon>
                Procesar Solicitudes
            </a>
            <?php endif;?>
            <?php if($rol == 1 && $dpto == 20|| $rol == 2|| $rol == 4 ):?> 
            <a href="/sol_itcg/admin/Gestionar Solicitudes Entrantes/GestionarSE.php">
            <ion-icon name="git-compare-outline"></ion-icon>
                Gestionar Solicitudes Entrantes
            </a>
            <a href="/sol_itcg/admin/Estadisticas De Solicitudes/EstadisticasDS.php">
            <ion-icon name="analytics-outline"></ion-icon>
                Estadísticas De Solicitudes
            </a>
            <?php endif;?>
            <?php if($rol == 5):?> 
            <a href="/sol_itcg/admin/Atender Solicitudes/Atender Solicitudes.php">
                <ion-icon name="clipboard"></ion-icon>
                Atender Solicitudes
            </a>
            <?php endif;?>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>