<?php
    use PHPMailer\PHPMailer\PHPMailer;

    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php"; 
    
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
    $ban = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){

   
        $razon = $_POST['razon'];
        $id = $_POST['tipoForm2'];
        $edoUsuario = $_POST['edoUsuario'];
        $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
        $resultadoLlave0 = mysqli_query($db, $query0);
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'solicitudes.cc@cdguzman.tecnm.mx';                     //SMTP username
            $mail->Password   =                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('solicitudes.cc@cdguzman.tecnm.mx', 'Solicitudes Centro de Cómputo');//correo del superAdmin
            $mail->addAddress($_POST['email']); //correo a recibir

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'El estado de tu cuenta del sistema de solicitudes SOL_ITCG se encuetra '.$edoUsuario;
            $mail->Body    = $razon;
            $mail->CharSet = 'UTF-8';
        
            $mail->send();
            $ban = true;
            $queryCambiar= "UPDATE users SET `edoUser`='$edoUsuario' WHERE idUser = '$id'";
            $resultadoCambiar = mysqli_query($db, $queryCambiar);


            //Aquí ira el código para enviar el email cuando se suba al servidor
        } catch (Exception $e) {
            $ban = false;
        }
        $query1 = "SET FOREIGN_KEY_CHECKS=1";
        $resultadoLlave0 = mysqli_query($db, $query1);
    }
?>
<main class="CambiarEstado">
    <section class="w80">
        <h1>Cambiar Estado de Usuarios</h1>
        <form method="GET" class="buscarUs" >
            <div class="emailS">
                <label for="emailS">Email</label>
                <input type="text" name="emailS" id="emailS" required  maxlength="25" pattern="[A-Za-z 0-9.]+" required>           
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
                            $queryDatos= "SELECT * FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole WHERE u.email = '$email'";
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
                            <div class="edoUsuario">
                                <label for="edoUsuario">Estado de Usuario</label>
                                <select name="edoUsuario" id="edoUsuario" required>
                                <option value=""disabled selected>--Seleccione Estado--</option>
                                '); 
                                
                                if(!empty($row['edoUser'])){
                                    if($row['edoUser'] == "HABILITADO"){
                                        echo('                                
                                        <option selected="selected" value="'.$row['edoUser'].'" >HABILITADO</option>
                                        <option value="DESHABILITADO">DESHABILITADO</option>
                                        </select> 
                                        </div>
                                        ');
                                    }elseif($row['edoUser'] == "DESHABILITADO"){
                                        echo('                                
                                        <option value="HABILITADO">HABILITADO</option>
                                        <option selected="selected" value="'.$row['edoUser'].'">DESHABILITADO</option>
                                        </select></div>
                                        '); 
                                    }
                                }else{
                                    echo('                                
                                    <option value="HABILITADO">HABILITADO</option>
                                    <option value="DESHABILITADO">DESHABILITADO</option>
                                    </select> 
                                    </div>');
                                }
                            echo('</div>');
                                 
                            echo('
                            <div class="razon">
                                <label for="razon">Razón del cambio de estado del usuario</label>
                                <textarea name ="razon" maxlength="255" placeholder="Ingresa las razones del cambio de estado del usuario, para notificarle en su correo institucional una vez HABILITADO/DESHABILITADO del sistema -Las solicitudes generadas por él no se eliminarán-" required></textarea>
                            </div>');
                            echo('
                            <div class="btnCU">
                                <input type="submit" value="Cambiar Estado">
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
        echo "<script>advertencia('Se ha cambiado el estado del usuario');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false){
        echo "<script>fracaso('No se ha podido cambiar el estado del usuario');</script>";
    }
?>