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
        <form method="POST">
            <div class="email">
                <label for="email">Email</label>
                <input required type="email" name="email" id="email">           
            </div>
            <div class="nombreUser">
                <label for="nombre">Nombre</label>
                <input required type="text" name="nombre" id="nombre"onkeypress="return checkLetters(event);">           
            </div>
            <div class="apellidoP">
                <label for="apellido">Apellido Paterno</label>
                <input required type="text" name="apellidoP" id="apellido"onkeypress="return checkLetters(event);">           
            </div>
            <div class="apellidoM">
                <label for="apellido">Apellido Materno</label>
                <input required type="text" name="apellidoM" id="apellido"onkeypress="return checkLetters(event);">           
            </div>
            <div class="tipoUsuario">
                <label for="tipoUsuario">Tipo de Usuario</label>
                <select name="tipoUsuario" id="tipoUsuario" required>
                    <option disabled selected>--Seleccione--</option>
                    <option value="admin">Administrador</option>
                    <option value="maestro">Docente</option>
                </select>           
            </div>
            <div class="RFC">
                <label for="rfc">RFC</label>
                <input required type="text" name="rfc" minlength="13" id="rfc"onkeypress="return checkLetters(event);">           
            </div>
            <div class="password">
                <label for="password">Contraseña</label>
                <input required type="password" name="password" id="password">           
            </div>
            <div class="passwordCon">
                <label for="passwordCon">Confirmar Contraseña</label>
                <input required type="password" name="passwordCon" id="passwordCon">           
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