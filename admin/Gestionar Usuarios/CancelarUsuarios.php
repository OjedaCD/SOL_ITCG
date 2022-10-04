<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../../includes/PHPMailer/Exception.php';
    require '../../includes/PHPMailer/PHPMailer.php';
    require '../../includes/PHPMailer/SMTP.php';
    
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
    if ($_SESSION['idRole'] != '1') {
        header('location: /admin/index.php'); 
        die();
    }
    $db = conectarDB();
    
    $email ="";
    $ban = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){
        $razon = $_POST['razon'];
        $id = $_POST['tipoForm'];

        $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
        $resultadoLlave0 = mysqli_query($db, $query0);
        
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'L18290915@cdguzman.tecnm.mx';                     //SMTP username
            $mail->Password   = 'MaxBarrigon1';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('L18290915@cdguzman.tecnm.mx', 'David Ojeda');//correo del superAdmin
            $mail->addAddress('L18290915@cdguzman.tecnm.mx'); //correo a eliminar            //Name is optional

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Se ha eliminado tu cuenta del sistema de solicitudes SOL_ITCG';
            $mail->Body    = $razon;
            $mail->CharSet = 'UTF-8';
        
            $mail->send();
            $ban = true;
            $queryCancelar = "DELETE FROM `users` WHERE `users`.`idUser` = '{$id}'";
            $resultadoLlave0 = mysqli_query($db, $queryCancelar);
        } catch (Exception $e) {
            $ban = false;
        }
        $query1 = "SET FOREIGN_KEY_CHECKS=1";
        $resultadoLlave0 = mysqli_query($db, $query1);
    }

?>
<main class="CancelarUsuario">
    <section class="w80">
        <h1>Cancelar Usuarios</h1>
        <form method="GET" >
            <div class="btnBCU">
                <input type="submit" value="Buscar Usuario">
            </div>
            <div class="emailS">
                <label for="emailS">Email</label>
                <input required type="text" name="emailS" id="emailS" pattern="[A-Za-z 0-9]+">           
           </div>
           <div class="emailD">
                <input disabled type="text" name="emailD" id="emailD"  placeholder="@cdguzman.tecnm.mx" value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
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
                            $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, r.nomRole FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole WHERE u.email = '$email'";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $queryId = "SELECT u.idUser FROM users as u WHERE u.email = '{$email}'";//se necesita el id del usuario para relacionarlo con accesos
                            $resultadoId = mysqli_query($db, $queryId);
                            
                            foreach ($resultadoId as $value) {
                                foreach ($value as $key) {
                                    $queryDpto = "SELECT  d.nomDpto FROM departamentos as d INNER JOIN accesos as ac ON ac.idDpto = d.idDpto WHERE ac.idUser = '{$key}'";
                                    $resultadoDpto = mysqli_query($db, $queryDpto);
                                    echo ('<input type="hidden" name="tipoForm" value="'.$key.'">');
                                }
                            }
                            $row = mysqli_fetch_assoc($resultadoDatos);//Toma los datos de usuarios y roles
                            $row2 = mysqli_fetch_assoc($resultadoDpto);//Toma los datos de accesos y departamentos
                            echo ('
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value = "'.$row["email"].'" disabled>           
                            </div>');
                            echo('
                            <div class="nombreUser">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"]." ".$row["apellidoUsuario"].'" disabled>           
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
                            <div class="razon">
                                <textarea name ="razon" placeholder="Ingresa las razones de la cancelación del usuario para notificarle en su correo institucional una vez eliminado del sistema -Las solicitudes generadas por él no se eliminarán-"></textarea>
                            </div>');
                            echo('
                            <div class="btnCU">
                                <input type="submit" value="Cancelar Usuario">
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
        echo "<script>advertencia('El usuario se ha cancelado');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false){
        echo "<script>fracaso('No se ha podido cancelar el usuario');</script>";
    }
?>