<?php
require 'includes/config/database.php';
$db = conectarDB();

$errores=[];
//Autentificaccion de usuario
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
    $email = mysqli_real_escape_string($db,filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db,$_POST['pass']);

    if (!$email) {
        $errores[0] = "El Correo  es obligatorio o no es valido";
    }
    if (!$password) {
        $errores[0] = "La contraseña es obligatoria";
    }

    if (empty($errores)) {
        //revisar si el usuario existe
        $query = "SELECT * FROM users";
        $resultado = mysqli_query($db, $query);
        if ($resultado->num_rows) {//Si tiene n filas dentro de la tabla
            //revisar el password
            while($usuario = mysqli_fetch_assoc($resultado)){
            //verificar si el password es correcto o no 
                if( $email == $usuario['email'] && $usuario['edoUser'] == "HABILITADO") {
                    # code...
                    $auth = password_verify($password, $usuario['token']);//Compara la contraseña en la BD
                    if ($auth) {
                        //Usuario Autentificado
                        session_start();
                        // //llenar arreglo de sesion
                        $_SESSION['usuario'] = $usuario['email'];//Se identifica al usario en el sistema 
                        $_SESSION['login'] = true;
                        $_SESSION['idRole'] = $usuario['idRole'];
                        $_SESSION['idDpto'] = $usuario['idDpto'];
                        $_SESSION['idUser'] = $usuario['idUser'];//Aquí será el id
                        header('location: ./admin');//Accede a los modulos
                    }
                    else {
                        $errores[0] = 'La contraseña es incorrecta';
                    }
                    break;
                }else{
                    $errores[0] ="El ususario no existe";  
                }
            }
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./build/css/app.css">
    <title>SOL_ITCG</title>
</head>
<body class="bg-Azul">
    <main>
        <section>
            <h1>Iniciar Sesión</h1>
            <?php foreach($errores as $error): ?>
                <div class="alerta error">
                    <?php  echo $error; ?>
                </div>
            <?php    endforeach;?>
            <form method="POST">
                <div class="email">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">
                </div>
                <div class="pass">
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña" maxlength="20" >
                </div>
                <div class="iniciar">
                    <button>
                        <ion-icon name="enter-outline" class="size3"></ion-icon>
                        <input type="submit" value="Iniciar Sesión">
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>

<!--Como aquí aún no llamamos a los templates necesitamos llamar a las funciones Script
y SCSS desde este archivo-->
<script src="./build/css/app.css"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>