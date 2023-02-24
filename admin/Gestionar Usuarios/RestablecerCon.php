<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php"; 
    
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
    if ($_SESSION['idRole'] != '1') {
        header('location: /admin/index.php'); 
        die();
    }
    $db = conectarDB();
    $ban = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){
        
        $id = $_POST['tipoForm2'];

        function generateRandomString($length = 20) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ%!';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        } 
        $aux2 = generateRandomString();
        $passwordhash = password_hash($aux2, PASSWORD_DEFAULT);//Se encripta la contraseña con un costo elevado a la 10
        $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
        $resultadoLlave0 = mysqli_query($db, $query0);
        
        try {
            $para = $_POST['email'];
            $titulo = 'Se ha generado una nueva contraseña para tu cuenta del sistema de solicitudes SOL_ITCG';
            $mensaje = 'La nueva contraseña es: '.$aux2;
            $cabeceras = 'From: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                'Content-type: text/html; charset=UTF-8' . "\r\n".
                'Reply-To: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail($para, $titulo, $mensaje, $cabeceras);
            $ban = true;
            $queryModificar= "UPDATE users SET `token`='$passwordhash' WHERE idUser = '$id'";
            $resultadoModificar = mysqli_query($db, $queryModificar);
            //Aquí ira el código para enviar el email cuando se suba al servidor
        } catch (Exception $e) {
            $ban = false;
            echo $e;
        }

        $query1 = "SET FOREIGN_KEY_CHECKS=1";
        $resultadoLlave0 = mysqli_query($db, $query1);
    }
?>
<main class="RestablecerContraseña">
    <section class="w80">
        <h1>Restablecer Contraseña</h1>
        <form method="GET" class="buscarUs" >
            <div class="emailS">
                <label for="emailS">Email</label>
                <input type="text" name="emailS" id="emailS"required maxlength="25" pattern="[A-Za-z 0-9.]+" required>           
           </div>
           <div class="emailD">
                <input disabled type="text" name="emailD" id="emailD"  placeholder="@cdguzman.tecnm.mx" value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
           </div>
           <div class="btnBus">
                <input type="submit" value="Buscar Usuario">
            </div>
           <input type="hidden" name="tipoForm" value="bandera">
        </form>

        <form method="POST">
            <?php 
                if ($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['tipoForm'])) {
                    //Obtengo los datos del form
                    $email = $_GET['emailS']?? null;;
                    $email = "".trim($email)."@cdguzman.tecnm.mx";
                    $query = "SELECT * FROM users";
                    $resultado = mysqli_query($db, $query);
                    while($usuario = mysqli_fetch_assoc($resultado)){//Comprueba si existe el email en la BD
                        if( $email == $usuario['email']) {
                            $ban = true;
                            //Aquí va el envia el codigo a los inputs
                            $queryDatos= "SELECT u.idUser, u.email, u.nomUsuario, u.apellidoUsuario, u.edoUser, u.telefono, u.idDpto, r.nomRole FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole WHERE u.email = '$email'";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $row = mysqli_fetch_assoc($resultadoDatos);//Toma los datos de usuarios y roles

                            $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
                            $resultadoDpto = mysqli_query($db, $queryDpto);
                            $row2 = mysqli_fetch_assoc($resultadoDpto);//Toma los datos de accesos y departamentos

                            echo ('
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value = "'.$row["email"].'" disabled>
                                <input type="hidden" name="tipoForm2" value="'.$row["idUser"].'"> 
                                <input type="hidden" name="email" value="'.$row["email"].'">           
                            </div>');
                            echo('
                            <div class="nombreUser">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"]." ".$row["apellidoUsuario"].'" disabled>           
                            </div>');
                            echo('
                            <div class="telefono">
                                <label for="telefono">Teléfono de Usuario</label>
                                <input type="text" name="telefono" id="telefono" value = "'.$row["telefono"].'" disabled>           
                            </div>');
                            echo('
                            <div class="departamento">
                                <label for="departamento">Departamento</label>
                                    <input type="text" name="departamento" id="departamento" value = "'.$row2["nomDpto"].'" disabled>           
                            </div>');
                            echo('
                            <div class="rolUsuario">
                                <label for="rolUsuario">Rol de Usuario</label>
                                <input type="text" name="rolUsuario" id="rolUsuario" value = "'.$row["nomRole"].'" disabled>           
                            </div>');
                            echo('
                            <div class="btnRC">
                                <input type="submit" value="Generar Nueva Contraseña">
                            </div>');
                            break;
                        }else{
                            $ban = false;
                        }
                    }
                }
            ?>
            
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
    if ($_SERVER['REQUEST_METHOD'] === "GET" && $ban == true && isset($_GET['tipoForm'])) {
        echo "<script>exito('Usuario Encontrado');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "GET" && $ban == false && isset($_GET['tipoForm'])){
        echo "<script>fracaso('Error! El email no existe');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true){
        echo "<script>advertencia('Se ha cambiado la cantraseña');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false){
        echo "<script>fracaso('No se ha podido cambiar la contraseña');</script>";
    }
?>