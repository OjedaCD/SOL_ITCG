<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();
    $ban = null;
    $ban2 = null;
    if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['tipoForm3'])){
        
        $folio = $_POST['tipoForm2'];
        $btn= $_POST['btn'];
        $observacion = $_POST['observacion'];
        $prioridad = $_POST['prioridad'];
        $tipo = $_POST['tipo'];
        $encargadoS = $_POST['encargadoS']?? null;
        $trabajo = $_POST['trabajo']?? null;
        $materiales = $_POST['materiales']?? null;
        $asignado = $_POST['asignado'];
        $descripcion = $_POST['descripcion'];

        if ($_SESSION['idDpto'] == 20){
            $mantenimiento = $_POST['mantenimiento'];
            $lugar = $_POST['lugar'];
        }else{
            $mantenimiento = "";
            $lugar = "";
        }

        date_default_timezone_set("America/Mexico_City");
        $fechaFin = date('Y-m-d');

        if($btn == "Finalizar Solicitud"){
            $queryA = "UPDATE solicitudes SET `mantenimiento`='$mantenimiento', `lugar`='$lugar', `tipo`='$tipo', `Prioridad`='$prioridad', `observacion`='$observacion',`Estado`='FINALIZADO', Etapa = '3FINALIZADO' WHERE folio = '$folio'";
            $resultadoA=mysqli_query($db, $queryA);
            $ban = true;
        }elseif($btn == "Actualizar Comentario"){
            $queryA = "UPDATE solicitudes SET `mantenimiento`='$mantenimiento', `lugar`='$lugar', `tipo`='$tipo', `Prioridad`='$prioridad', `observacion`='$observacion', `Estado`='ACEPTADO', `Etapa`='2PROCESO' WHERE folio = '$folio'";
            $resultadoA=mysqli_query($db, $queryA);
            $ban2 = true;
        }elseif($btn == "Cancelar Solicitud"){
            $queryR = "UPDATE solicitudes SET fechaFin ='{$fechaFin}', `mantenimiento`='$mantenimiento', `lugar`='$lugar', `tipo`='$tipo', `Prioridad`='$prioridad', `observacion`='$observacion', validacion = 1, `Estado`='CANCELADO', Etapa = '3FINALIZADO' WHERE folio = '$folio'";
            $resultadoR=mysqli_query($db, $queryR);
            $ban = false;
        }elseif ($btn == "Asignar Personal"){
            try {
                $para = $asignado;
                $titulo = 'Se te ha asignado una solicitud de mantenimiento';
                $mensaje = 'El solicitante requiere de: '.$descripcion;
                $cabeceras = 'From: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                    'Content-type: text/html; charset=UTF-8' . "\r\n".
                    'Reply-To: centro.de.computo@cdguzman.tecnm.mx' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                mail($para, $titulo, $mensaje, $cabeceras);
                $ban = true;
                $queryA = "UPDATE solicitudes SET `mantenimiento`='$mantenimiento', `lugar`='$lugar', `observacion`='$observacion', `tipo`='$tipo', `Prioridad`='$prioridad', `Estado`='ACEPTADO', `Etapa`='2PROCESO', `encargadoS`='$asignado'WHERE folio = '$folio'";
                $resultadoA=mysqli_query($db, $queryA);
                //Aquí ira el código para enviar el email cuando se suba al servidor
            } catch (Exception $e) {
                $ban = false;
                echo $e;
            }
        }

    }

?>
<main class="SolicitudesEnProceso">
    <section class="w80">
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Solicitudes En Proceso Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Solicitudes En Proceso Mantenimiento  De Equipo</h1>');
            }
        ?>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ACEPTADO' AND Etapa = '2PROCESO'";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>NUM</th>
                <th>DEPARTAMENTO</th>
                <th>SOLICITANTE</th>
                <th>FECHA</th>
                <th>DESCRIPCIÓN</th>
                <th>PROCESO</th>
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
                    echo('<form method="GET" action ="SolicitudesEnProcesoFormato.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                    <tr>
                        <th>'.substr("$row[folio]", 8).'</th>
                        <th>'.substr("$row3[nomDpto]", 0,26).'</th>
                        <th>'.substr("$name", 0,15).'</th>
                        <th>'.$row['fecha'].'</th>
                        <th>'.substr("$row[descripcion]", 0,30).'</th>');
                        if($row['validacion'] == 1){
                            echo('<th><input class = "si"type="submit" value="Ver Solicitud"></th>');  
                        }if($row['validacion'] == 0){
                            echo('<th><input class = "no"type="submit" value="Ver Solicitud"></th>');  
                        }
                        echo('
                    </tr>
                    </form>');
                }
                echo('</table>');
            ?>
    </section>
</main>

<?php 
    inlcuirTemplate('footer');
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true && isset($_POST['tipoForm2']) && isset($_POST['tipoForm3'])) {
        echo "<script>exito('Solicitud Finalizada');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false && isset($_POST['tipoForm2']) && isset($_POST['tipoForm3'])){
        echo "<script>fracaso('Solicitud Cancelada');</script>";
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $ban2 == true && isset($_POST['tipoForm3'])) {
        echo "<script>exito('Comentario Actualizado');</script>";
    }
?>

