<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>

<main class="ModificarUsuario"> 
    <section class="w80">
        <h1>Modificar Usuarios</h1>
        <form method="GET">
            <div class="btnBCU">
                <input type="submit" value="Buscar Usuario">
            </div>
            <div class="email">
                <label for="email">Email</label>
                <input required type="email" name="email" id="email"  value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
           </div>
        </form>
        <form method="POST">

            <div class="email">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" disabled>           
            </div>
            <div class="nombreUser">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" disabled>           
            </div>
            <div class="departamento">
                <label for="departamento">Departamento</label>
                <input type="text" name="departamento" id="departamento" disabled>           
            </div>
            <div class="rolUsuario">
                <label for="rolUsuario">Rol de Usuario</label>
                <input type="text" name="rolUsuario" id="rolUsuario" disabled>           
            </div>
            
            <div class="btnCU">
                <input type="submit" value="Modificar">
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>