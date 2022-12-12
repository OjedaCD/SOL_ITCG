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
    $db =conectarDB();

    $ban = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){

        $folio = $_POST['tipoForm2'];
        $observacion = $_POST['observacion'];
        $nombre = $_POST['nombre'];
        $dpto = $_POST['dpto'];
        $descripcion = $_POST['descripcion'];
        $idDpto = $_POST['idDpto'];
        $queryIdSol = "SELECT s.idSolicitud FROM solicitudes as s WHERE s.folio = '{$folio}'";
        $resultadoIdSol =mysqli_query($db, $queryIdSol);
        $aux3 = mysqli_fetch_assoc($resultadoIdSol);//Guarda el id de la solicitud

        
        foreach ($aux3 as $key => $idSol) {
            $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
            $resultadoLlave0 = mysqli_query($db, $query0);

            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'pruebas_sol_itcg@cdguzman.tecnm.mx';                     //SMTP username
                $mail->Password   =                              //SMTP password
                $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('pruebas_sol_itcg@cdguzman.tecnm.mx', 'Solicitudes Centro de Cómputo');//correo del superAdmin
                
                if($idDpto == 20){
                    $mail->addAddress('solicitudes.cc@cdguzman.tecnm.mx');
                }elseif($idDpto == 21){
                    $mail->addAddress('solicitudes.mnto@cdguzman.tecnm.mx');
                }
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'La solicitud de '.$nombre.' del departamento de '.$dpto.' ha sido cancelada';
                $mail->Body    = 'Solicitud: '.'<br>'.$descripcion.'Razones de la cancelación '.'<br>'.$observacion;
                $mail->CharSet = 'UTF-8';
        
                
                $mail->send();
                $ban = true;
                $querySol = "UPDATE solicitudes SET Estado ='CANCELADO' , Etapa = 'FINALIZADO' WHERE idSolicitud = '$idSol'";
                $resultadoUs =mysqli_query($db, $querySol);
                //Aquí ira el código para enviar el email cuando se suba al servidor
            } catch (Exception $e) {
                $ban = false;
            }
            $query1 = "SET FOREIGN_KEY_CHECKS=1";
            $resultadoLlave0 = mysqli_query($db, $query1);
        }
    }
?>
<main class="CancelarSolicitudPendiente">
    <section class="w80">
        <h1>Cancelar Solicitud Pendiente</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idUser = $_SESSION[idUser] AND (Estado = 'ESPERA' OR Estado = 'RECHAZADO') AND Etapa = 'PENDIENTE' ORDER BY fecha ASC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>ÁREA SOLICITANTE</th>
                <th>SOLICITANTE</th>
                <th>FECHA DE ENVÍO</th>
                <th>ETAPA</th>
                <th>CANCELAR SOLICITUD</th>
                </tr>'); 
                while ($row = mysqli_fetch_array($resultado)){
                    $queryId ="SELECT u.nomUsuario, u.apellidoUsuario FROM users as u
                    INNER JOIN solicitudes as s ON u.idUser = s.idUser WHERE s.idUser = $row[idUser]";//Selecciono el id del usurio
                    $resultadoId = mysqli_query($db, $queryId);
                    $row2 = mysqli_fetch_array($resultadoId);

                    $queryDpto ="SELECT d.nomDpto FROM departamentos as d
                    INNER JOIN solicitudes as s ON s.idDpto = d.idDpto WHERE s.folio = '$row[folio]'";//Selecciono el id del usurio
                    $resultadoDpto = mysqli_query($db, $queryDpto);
                    $row3 = mysqli_fetch_array($resultadoDpto);

                    echo('<form method="GET" action ="CancelarSolicitudPendienteFormato.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.$row3['nomDpto'].'</th>

                            <th>'.$row2['nomUsuario']." ".$row2['apellidoUsuario'].'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.$row['Etapa'].'</th>
                            <th><input type="submit" value="Cancelar Solicitud"></th>
                        </tr>
                    </form>');
                }
                echo('</table>');
            ?>
    </section>
</main>

<?php 
    inlcuirTemplate('footer');
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true && isset($_POST['tipoForm2'])) {
        echo "<script>exito('Solicitud Cancelada');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false && isset($_POST['tipoForm2'])){
        echo "<script>fracaso('Error! Solicitud no Cancelada');</script>";
    }
?>

