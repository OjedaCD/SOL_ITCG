<?php
require 'includes/config/database.php';
$db = conectarDB();

$errores=[];
//Autentificaccion de usuario
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
    $email = mysqli_real_escape_string($db,filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db,$_POST['pass']);

    if (!$email) {
        $errores[] = "El Correo  es obligatorio o no es valido";
    }

    if (!$password) {
        $errores[] = "La contraseña es obligatoria";
    }

    if (empty($errores)) {
        //revisar si el usuario existe
        $query = "SELECT * FROM users";
        $resultado = mysqli_query($db, $query);
        if ($resultado->num_rows) {
            //revisar el password
            $usuario = mysqli_fetch_assoc($resultado);   
            //var_dump($usuario); 

            //verificar si el password es correcto o no 
            $auth = password_verify($password, $usuario['password']);
            echo $usuario['password'];
            //var_dump($auth);
            if ($auth) {
                //Usuario Autentificado
                session_start();
                //llenar arreglo de sesion
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                header('location: /admin');
            }
            else {
                $errores[] = 'La contraseña es incorrecta';
            }
        }
        else {
            $errores[] ="El ususario no existe";
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
    <link rel="stylesheet" href="/build/css/app.css">
    <title>Siseni</title>
</head>
<body class="bg-Azul">
    <main>
        <section>
            <h1>Iniciar Sesión</h1>
            <form method="POST">
                <div class="email">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>
                <div class="pass">
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña">
                </div>
                <a href="/">Olvidaste Contraseña?</a>
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

<script src="/build/css/app.css"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>