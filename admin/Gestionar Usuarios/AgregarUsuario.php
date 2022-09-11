<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    if ($_SESSION['role']!="admin") {
        header('location: /admin/index.php'); 
        die();
    }
    inlcuirTemplate('header');
    $db = conectarDB();

    $email ="";
    $rfc="";
    $nombre="";
    $apellidoP="";
    $apellidoM="";
    $tipoUser="";
    $password ="";
    $passwordCon="";
    $errores =[];
    $ban = true;
    if ($_SERVER['REQUEST_METHOD']==="POST") {
        $email =mysqli_real_escape_string($db, $_POST['email']);
        $nombre=mysqli_real_escape_string($db, $_POST['nombre']);
        $apellidoP=mysqli_real_escape_string($db, $_POST['apellidoP']);
        $apellidoM=mysqli_real_escape_string($db, $_POST['apellidoM']);
        $rfc=mysqli_real_escape_string($db, $_POST['rfc']);
        $tipoUser=$_POST['tipoUsuario'];
        $password =mysqli_real_escape_string($db, $_POST['password']);
        $passwordCon=mysqli_real_escape_string($db, $_POST['passwordCon']);
        if ($password != $passwordCon) {
            $errores[] ="No Coincidaden las contraseñas";
        }
        if (empty($errores)) {
            $fecha = date('Y-m-d');
            if ($tipoUser ==="maestro") {
                $nombreMaestro = $nombre. " ".$apellidoP ." ".$apellidoM;
                $query = "INSERT INTO `maestros`(`nombreMaestro`, `rfc`) VALUES ('{$nombreMaestro}','{$rfc}')";
                $resultadoMaes = mysqli_query($db, $query);
            }
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query ="INSERT INTO users(`email`, `password`, `create`, `role`, 'rfc') VALUES ('{$email}','{$password}','{$fecha}','$tipoUser', '{$rfc}')";
            $resultado = mysqli_query($db, $query);
        }else{
            $ban = false;
        }
    }
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
    if ($ban && $_SERVER['REQUEST_METHOD']==="POST") {
        echo "<script>exito('Usuario Registrado');</script>";
    }
?>