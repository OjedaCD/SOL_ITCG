<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";
    $resultadoDep= mysqli_query($db, $queryDep);
    $banAR = null;
    $banC = null;
    $banP = null;
    if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['tipoForm3'])){
        
        $folio = $_POST['tipoForm2'];
        $observacion = $_POST['observacion'];
        $btn= $_POST['btn'];
        $prioridad = $_POST['prioridad'];
        $tipo = $_POST['tipo'];
        $email = $_POST['email'];
        $descripcion = $_POST['descripcion'];
        
        if ($_SESSION['idDpto'] == 20){
            $mantenimiento = $_POST['mantenimiento'];
            $lugar = $_POST['lugar'];
            $asignado = $_POST['asignado'];
        }else{
            $mantenimiento = "";
            $lugar = "";
            $asignado = "";
        }
        $queryPer ="SELECT nomUsuario, apellidoUsuario FROM users WHERE email = '$asignado'";
        $resultadoPer= mysqli_query($db, $queryPer);
        $persona = mysqli_fetch_assoc($resultadoPer);

        if($btn == "Aceptar Solicitud"){
            try {
                if($_SESSION['idDpto'] == 20){
                    $para = $email;
                    $titulo = 'Tu solicitud de mantenimiento ha sido ACEPTADA'."\n".'FOLIO: '.$folio;
                    $mensaje = $persona['nomUsuario']." ".$persona['apellidoUsuario'].' dará servicio en breve a tu solicitud de : '."\n".$descripcion."\n".
                    'Este correo es generado automáticamente, no es necesario responder';
                    $cabeceras = 'From: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                    'Content-Type: text/plain; charset=UTF-8' . "\r\n" .
                    'Reply-To: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                    mail($para, $titulo, $mensaje, $cabeceras);
                }elseif($_SESSION['idDpto'] == 21){
                    $para = $email;
                    $titulo = 'Tu solicitud de mantenimiento ha sido ACEPTADA'."\n".'FOLIO: '.$folio ;
                    $mensaje = 'Se te dará servicio en breve a tu solicitud de : '."\n".$descripcion."\n".
                    'Este correo es generado automáticamente, no es necesario responder';
                    $cabeceras = 'From: mantto@cdguzman.tecnm.mx' . "\r\n" .
                        'Content-Type: text/plain; charset=UTF-8' . "\r\n" .
                        'Reply-To: mantto@cdguzman.tecnm.mx' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                    mail($para, $titulo, $mensaje, $cabeceras);
                }
                $banAR = true;
                $queryA = "UPDATE solicitudes SET `mantenimiento`='$mantenimiento', `lugar`='$lugar', `observacion`='$observacion', `tipo`='$tipo', `Prioridad`='$prioridad', `Estado`='ACEPTADO', `Etapa`='2PROCESO' WHERE folio = '$folio'";
                $resultadoA=mysqli_query($db, $queryA);
                //Aquí ira el código para enviar el email cuando se suba al servidor
            } catch (Exception $e) {
                $banAR = false;
                echo $e;
            }
    
        }elseif($btn == "Actualizar Comentario"){
            $queryAC = "UPDATE solicitudes SET `mantenimiento`='$mantenimiento', `lugar`='$lugar', `observacion`='$observacion', `tipo`='$tipo', `Prioridad`='$prioridad', `Etapa`='1PENDIENTE' WHERE folio = '$folio'";
            $resultadoAC=mysqli_query($db, $queryAC);
            $banC = true;
        }elseif($btn == "Rechazar Solicitud"){
            $queryR = "UPDATE solicitudes SET `mantenimiento`='$mantenimiento', `lugar`='$lugar', `observacion`='$observacion', `tipo`='$tipo', `Prioridad`='$prioridad', `Estado`='RECHAZADO', `Etapa`='1PENDIENTE' WHERE folio = '$folio'";
            $resultadoR=mysqli_query($db, $queryR);
            $banAR = false;
        }elseif ($btn == "Asignar Personal"){
            $banP = true;
            try {
                $para = $asignado;
                $titulo = 'Se te ha asignado una solicitud de mantenimiento'."\n".'FOLIO: '.$folio;
                $mensaje = 'El solicitante requiere de: '."\n".$descripcion."\n".
                'Este correo es generado automáticamente, no es necesario responder';
                $cabeceras = 'From: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                'Content-Type: text/plain; charset=UTF-8' . "\r\n" .
                'Reply-To: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
                mail($para, $titulo, $mensaje, $cabeceras);
                
                $queryA = "UPDATE solicitudes SET `encargadoS`='$asignado'WHERE folio = '$folio'";
                $resultadoA=mysqli_query($db, $queryA);
                //Aquí ira el código para enviar el email cuando se suba al servidor
            } catch (Exception $e) {
                $banP = false;
                echo $e;
            }
        }
    }elseif($_SERVER['REQUEST_METHOD']==="POST" ){
        $folio = $_POST['tipoForm2'];
        $descripcion = $_POST['descripcion'];
        $btn= $_POST['btn'];
        
        if ($_SESSION['idDpto'] == 20){
            $asignado = $_POST['asignado'];
        }else{
            $asignado = "";
        }
        if ($btn == "Asignar Personal"){ 
            $banP = true;
            try {
                $para = $asignado;
                $titulo = 'Se te ha asignado una solicitud de mantenimiento'."\n".'FOLIO: '.$folio ;
                $mensaje = 'El solicitante requiere de: '."\n".$descripcion."\n".
                'Este correo es generado automáticamente, no es necesario responder';
                $cabeceras = 'From: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                    'Content-Type: text/plain; charset=UTF-8' . "\r\n" .
                    'Reply-To: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                mail($para, $titulo, $mensaje, $cabeceras);
                
                $queryA = "UPDATE solicitudes SET `encargadoS`='$asignado'WHERE folio = '$folio'";
                $resultadoA=mysqli_query($db, $queryA);
                //Aquí ira el código para enviar el email cuando se suba al servidor
            } catch (Exception $e) {
                $banP = false;
                echo $e;
            }
        }
    }
 
?>
<main class="SolicitudesPendientes">
    <section class="w80">
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Solicitudes Pendientes Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Solicitudes Pendientes Mantenimiento de Equipo</h1>');
            }
        ?>
        <?php
            $query ="SELECT * FROM solicitudes WHERE (Estado = 'ESPERA' OR Estado = 'RECHAZADO') AND idDpto = $_SESSION[idDpto] AND Etapa = '1PENDIENTE' ORDER BY Estado ASC , fecha ASC, Prioridad ASC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>FOLIO</th>
                <th>DEPARTAMENTO</th>
                <th>SOLICITANTE</th>
                <th>FECHA</th>
                <th>DESCRIPCIÓN</th>
                <th>SOLICITUD</th>
            </tr>'); 
            while ($row = mysqli_fetch_array($resultado)){
                
                $queryId ="SELECT u.nomUsuario, u.apellidoUsuario FROM users as u
                INNER JOIN solicitudes as s ON u.idUser = s.idUser WHERE s.idUser = $row[idUser]";//Selecciono el id del usurio
                $resultadoId = mysqli_query($db, $queryId);
                $row2 = mysqli_fetch_array($resultadoId);

                $queryDpto ="SELECT d.nomDpto FROM departamentos as d
                INNER JOIN users as u ON u.idDpto = d.idDpto WHERE u.idUser = $row[idUser]";//Selecciono el id del usurio
                $resultadoDpto = mysqli_query($db, $queryDpto);
                $row3 = mysqli_fetch_array($resultadoDpto);
                $name = $row2['nomUsuario']." ".$row2['apellidoUsuario'];
                
                echo('<form method="GET" action ="SolicitudesPendientesFormato.php">
                    <input name = "'.$row['folio'].'" type="hidden">
                    <tr>
                        <th>'.substr("$row[folio]", 8).'</th>
                        <th>'.substr("$row3[nomDpto]", 0,26).'</th>
                        <th>'.substr("$name", 0,15).'</th>
                        <th>'.$row['fecha'].'</th>
                        <th>'.substr("$row[descripcion]", 0,30).'</th>
                        ');
                        if ($row['Estado'] != "RECHAZADO"){
                            if($_SESSION['idDpto'] == 21|| !empty($row['encargadoS']) && $_SESSION['idDpto'] == 20){
                                echo('<th><input class = "aceptado"type="submit" value="En Espera"></th>');
                            }elseif(empty($row['encargadoS']) && $_SESSION['idDpto'] == 20){
                                echo('<th><input class = "aceptado"type="submit" value="Asignar Personal"></th>');
                            }
                        }else{
                            echo('<th><input class = "rechazado"type="submit" value="En Correción"></th>');
                        }
                       echo('
                    </tr>
                </form>');
            }//El color del botón cambia a rojo si es rechazada  y se va al final con prioridad
            echo('</table>');
        ?>
    </section>
</main>

<?php 
    inlcuirTemplate('footer');

    if ($_SERVER['REQUEST_METHOD'] ==="POST" && $banAR && $banC == null && $banP == null  ) {
        echo "<script>exito('Solicitud Aceptada');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] ==="POST" && !$banAR && $banC == null && $banP == null ){
        echo "<script>fracaso('Solicitud Rechazada');</script>";
    }elseif ($_SERVER['REQUEST_METHOD'] === "POST" && $banC && $banAR == null && $banP == null ) {
        echo "<script>exito('Comentario Actualizado');</script>";
    }elseif ($_SERVER['REQUEST_METHOD'] === "POST" && $banP && $banC == null && $banAR == null) {
        echo "<script>exito('Personal Asignado');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && !$banP && $banC == null && $banAR == null){
        echo "<script>fracaso('Personal No Asignado');</script>";
    }
    
    
?>

