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
        <h1>Bienvenido a SOL_ITCG</h1>
        <div class="botones">
            <?php if($_SESSION['idRole'] == '1'|| $_SESSION['idRole'] == '2'|| $_SESSION['idRole'] == '4'):?>  
            <a href="/admin/Gestionar Usuarios/GestionarUsuarios.php">
                <ion-icon name="person-circle-sharp"></ion-icon>
                Gestionar Usuarios
            </a>
            <?php endif;?>
            <?php if($_SESSION['idRole'] == '3'):?> 
            <a href="/admin/Procesar Solicitudes/ProcesarSolicitudes.php">
                <ion-icon name="clipboard"></ion-icon>
                Procesar Solicitudes
            </a>
            <?php endif;?>
            <?php if($_SESSION['idRole'] == '1' || $_SESSION['idRole'] == '2'|| $_SESSION['idRole'] == '4' ):?> 
            <a href="/admin/Gestionar Solicitudes Entrantes/GestionarSE.php">
            <ion-icon name="git-compare-outline"></ion-icon>
                Gestionar Solicitudes Entrantes
            </a>
            <?php endif;?>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>