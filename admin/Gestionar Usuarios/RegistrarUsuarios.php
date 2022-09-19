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
                <input required type="email" name="email" id="email"  value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
            </div>
            <div class="nombreUser">
                <label for="nombre">Nombre</label>
                <input required type="text" name="nombre" id="nombre" maxlength="50" required pattern="[A-Za-z]+">           
            </div>
            <div class="apellidoP">
                <label for="apellido">Primer Apellido</label>
                <input required type="text" name="apellidoP" id="apellidoP"maxlength="50" required pattern="[A-Za-z]+">           
            </div>
            <div class="apellidoS">
                <label for="apellido">Segundo Apellido</label>
                <input required type="text" name="apellidoS" id="apellidoS"maxlength="50" required pattern="[A-Za-z]+">           
            </div>
            <div class="tel">
                <label for="tel">Teléfono</label>
                <input type="tel" name="telefono" placeholder="Introduce tú número de teléfono" minlength="0" maxlength="10">
            </div>
            <div class="rolUsuario">
                <label for="rolUsuario">Rol de Usuario</label>
                <select required name="rolUsuario" id="rolUsuario" >
                    <option disabled selected>--Seleccione un rol--</option>
                    <option value="administrador">Administrador</option>
                    <option value="solicitante">Solicitante</option>
                </select>           
            </div>
            <div class="departamento">
                <label for="departamento">Departamento</label>
                <select required name="departamento" id="departamento" >
                    <option disabled selected>--Seleccione un departamento--</option>
                    <option value="Centro de Cómputo">Centro de Cómputo</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                </select>           
            </div>
            <div class="eye">
                <label for="password">Contraseña</label>
                <input required type="password" name="password" id="password"> 
                <img src="/src/img/Show.png" alt="" class="icon" id="ojo">
            </div>
            <div class="btnRU">
                <input type="submit" value="Registrar Usuario">
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>