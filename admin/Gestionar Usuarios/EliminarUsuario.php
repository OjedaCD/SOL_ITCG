

<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>

<main>
    <h1>Base</h1>
</main>
<?php 
    inlcuirTemplate('footer');
?>