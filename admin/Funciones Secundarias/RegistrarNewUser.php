<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
?>
<main class="RegistroNuevoUsuario">
    <section class="w80">
        <h1>Registrar Nuevo Usuario</h1>
        <form>
            <div class="email">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">           
            </div>
            <div class="nombre">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">           
            </div>
            <div class="apellido">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido">           
            </div>
            <div class="tipoUsuario">
                <label for="tipoUsuario">Tipo de Usuario</label>
                <select name="tipoUsuario" id="tipoUsuario">
                    <option disabled selected>--Seleccione--</option>
                    <option value="admin">Administrador</option>
                    <option value="docente">Docente</option>
                </select>           
            </div>
            <div class="password">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password">           
            </div>
            <div class="passwordCon">
                <label for="passwordCon">Confirmar Contraseña</label>
                <input type="password" name="passwordCon" id="passwordCon">           
            </div>
            <div class="but">
                <input type="submit" value="Registrar">
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>