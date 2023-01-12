<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

    $banM = null;
    $banC = null;
    $banV = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['modificar']) ){

        //idSolicitud con el folio
        $folio = $_POST['tipoForm2'];
        $falla =$_POST['checkbox'];
        $descripcion = $_POST['descripcion']; 
        date_default_timezone_set("America/Mexico_City");
        $fecha = date('Y-m-d');

        $queryIdSol = "SELECT s.idSolicitud FROM solicitudes as s WHERE s.folio = '{$folio}'";
        $resultadoIdSol =mysqli_query($db, $queryIdSol);
        $aux3 = mysqli_fetch_assoc($resultadoIdSol);//Guarda el id de la solicitud

        foreach ($aux3 as $key => $idSol) {
            
            $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
            $resultadoLlave0 = mysqli_query($db, $query0);
    
            $queryBorrar ="DELETE FROM detalles WHERE idSolicitud = '{$idSol}' ";
            $resultadoBorrar= mysqli_query($db, $queryBorrar);

            $query1 = "SET FOREIGN_KEY_CHECKS=1";
            $resultadoLlave0 = mysqli_query($db, $query1);

            foreach ($falla as $key => $fallas) {
                $queryFalla = "INSERT INTO detalles (idSolicitud, idFalla) VALUES ('{$idSol}','{$fallas}')";
                $resultadoFalla =mysqli_query($db, $queryFalla);
            }
            $querySol = "UPDATE solicitudes SET `folio`='$folio', `fecha`='$fecha', `descripcion`='$descripcion'
            WHERE idSolicitud = '$idSol'";
            $resultadoUs =mysqli_query($db, $querySol);

            if($resultadoUs && $resultadoFalla && $resultadoBorrar){
                $banM = true;
            }else{
                $banM = false;
            }
        } 
    }

    if ($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['cancelar'])){

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

            //$mail = new PHPMailer(true);
            try {
                //Server settings
                // $mail->SMTPDebug = 0;                      //Enable verbose debug output
                // $mail->isSMTP();                                            //Send using SMTP
                // $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
                // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                // $mail->Username   = 'pruebas_sol_itcg@cdguzman.tecnm.mx';                     //SMTP username
                // $mail->Password   =                              //SMTP password
                // $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                // $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                // //Recipients
                // $mail->setFrom('pruebas_sol_itcg@cdguzman.tecnm.mx', 'Solicitudes Centro de Cómputo');//correo del superAdmin
                
                // if($idDpto == 20){
                //     $mail->addAddress('solicitudes.cc@cdguzman.tecnm.mx');
                // }elseif($idDpto == 21){
                //     $mail->addAddress('solicitudes.mnto@cdguzman.tecnm.mx');
                // }
                // //Content
                // $mail->isHTML(true);                                  //Set email format to HTML
                // $mail->Subject = 'La solicitud de '.$nombre.' del departamento de '.$dpto.' ha sido cancelada';
                // $mail->Body    = 'Solicitud: '.'<br>'.$descripcion.'Razones de la cancelación '.'<br>'.$observacion;
                // $mail->CharSet = 'UTF-8';
        
                
                // $mail->send();
                $banC = true;
                $querySol = "UPDATE solicitudes SET Estado ='CANCELADO' , Etapa = '3FINALIZADO', validacion = 1 WHERE idSolicitud = '$idSol'";
                $resultadoUs =mysqli_query($db, $querySol);
                //Aquí ira el código para enviar el email cuando se suba al servidor
            } catch (Exception $e) {
                $banC = false;
            }
            $query1 = "SET FOREIGN_KEY_CHECKS=1";
            $resultadoLlave0 = mysqli_query($db, $query1);
        }
    }
    if ($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['validar']) ){
        $folio = $_POST['tipoForm2'];
        $queryIdSol = "SELECT s.idSolicitud FROM solicitudes as s WHERE s.folio = '{$folio}'";
        $resultadoIdSol =mysqli_query($db, $queryIdSol);
        $aux3 = mysqli_fetch_assoc($resultadoIdSol);//Guarda el id de la solicitud
        foreach ($aux3 as $key => $idSol) {
            $querySol = "UPDATE solicitudes SET validacion = 1 WHERE idSolicitud = '$idSol'";
            $resultadoUs =mysqli_query($db, $querySol);
            if($resultadoUs){
                $banV = true;
            }else{
                $banV = False;
            }
        } 
    }

?>
<main class="VerEstadoEtapaSolicitud">
    <section class="w80">
        <h1>Solicitudes Mantenimiento de Equipo</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idUser = $_SESSION[idUser] AND idDpto = 21 ORDER BY Etapa ASC, Fecha DESC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>NUM</th>
                <th>FECHA</th>
                <th>DESCRIPCIÓN</th>
                <th>ESTADO</th>
                <th>OPCIONES</th>
            </tr>'); 
                
                while ($row = mysqli_fetch_array($resultado)){
                
                    $queryDpto ="SELECT d.nomDpto FROM departamentos as d
                    INNER JOIN solicitudes as s ON s.idDpto = d.idDpto WHERE s.folio = '$row[folio]'";//Selecciono el id del usurio
                    $resultadoDpto = mysqli_query($db, $queryDpto);
                    $row3 = mysqli_fetch_array($resultadoDpto);
                    if($row['Estado'] == "RECHAZADO"){
                        echo('<form method="GET" action ="ModificarSolicitudFormato.php">');
                    }elseif($row['Estado'] == "ESPERA"){
                        echo('<form method="GET" action ="CancelarSolicitudPendienteFormato.php">');
                    }elseif($row['Estado'] == "ACEPTADO"){
                        echo('<form method="GET" action ="ServicioSolicitudFormato.php">'); 
                    }else{
                        echo('<form method="GET" action ="DatosDeSolicitudFormato.php">'); 
                    }

                    echo('
                        <input name = "'.$row['folio'].'" type="hidden">');
                        if($row['Estado'] == "ESPERA" || $row['Estado'] == "FINALIZADO"|| $row['Estado'] == "CANCELADO" || intval($row['validacion']) == 0 && $row['Estado'] == "ACEPTADO"){
                            echo('
                        <tr class="espera">
                            <th>'.substr("$row[folio]", 4,-4).'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.substr("$row[descripcion]", 0,50).'</th>
                            <th>'.$row['Estado'].'</th>
                            ');
                        if ($row['Etapa'] == "1PENDIENTE"){
                                echo('<th><input class = "pen"type="submit" value="Cancelar Solicitud"></th>');        
                            }if($row['Etapa'] == "2PROCESO"){
                                echo('<th><input class = "pro"type="submit" value="Confirmar Servicio"></th>');  
                            }if($row['Etapa'] == "3FINALIZADO"){
                                echo('<th><input class = "fin"type="submit" value="Datos de Solicitud"></th>');  
                            }
                        echo('
                        </tr>');
                        }elseif($row['Estado'] == "RECHAZADO"){
                            echo('
                        <tr class="rechazado">
                            <th>'.substr("$row[folio]", 4,-4).'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.substr("$row[descripcion]", 0,50).'</th>
                            <th>'.$row['Estado'].'</th>
                            <th><input class = "pen"type="submit" value="Modificar Solicitud"></th>
                        </tr>');
                        }elseif(intval($row['validacion']) == 1 && $row['Estado'] == "ACEPTADO"){
                            echo('
                        <tr class="validado">
                            <th>'.substr("$row[folio]", 4,-4).'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.substr("$row[descripcion]", 0,50).'</th>
                            <th>'.$row['Estado'].'</th>
                            <th><input class = "pen"type="submit" value="Confirmar Servicio"></th>
                        </tr>');
                        }
                    echo('</form>');
                }
                echo('</table>');
            ?>
    </section>
</main>

<?php 
    inlcuirTemplate('footer');
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $banM == true && isset($_POST['modificar'])) {
        echo "<script>exito('Solicitud Modificada');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $banM == false && isset($_POST['modificar'])){
        echo "<script>fracaso('Error! Solicitud no Modificada');</script>";
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $banC == true && isset($_POST['cancelar'])) {
        echo "<script>exito('Solicitud Cancelada');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $banC == false && isset($_POST['cancelar'])){
        echo "<script>fracaso('Error! Solicitud no Cancelada');</script>";
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $banV == true && isset($_POST['validar'])) {
        echo "<script>exito('Servicio confirmado, el Administrador la Finalizará');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $banV == false && isset($_POST['validar'])){
        echo "<script>fracaso('Error! Solicitud no Validada');</script>";
    }
?>

