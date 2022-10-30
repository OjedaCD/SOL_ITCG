<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

    $ban = null;


    if ($_SERVER['REQUEST_METHOD']==="POST" ){

        //idSolicitud con el folio
        $folio = $_POST['tipoForm2'];
        $falla =$_POST['checkbox'];
        $descripcion = $_POST['descripcion']; 
        date_default_timezone_set("America/Mexico_City");
        $fecha = date('Y-m-d');

        $queryIdSol = "SELECT s.idSolicitud FROM solicitudes as s WHERE s.folio = $folio";
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
                $ban = true;
            }else{
                $ban = false;
            }
        }
        
    }

?>
<main class="VerSolicitudesEntrantes">
    <section class="w80">
        <h1>Modificar Solicitud Rechazada</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idUser = $_SESSION[idUser] AND Estado = 'RECHAZADO' AND Etapa = 'PENDIENTE' ORDER BY fecha ASC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>DEPARTAMENTO</th>
                <th>SOLICITANTE</th>
                <th>FECHA DE ENVÍO</th>
                <th>ESTADO</th>
                <th>MODIFICAR SOLICITUD</th>
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

                    echo('<form method="GET" action ="ModificarSolicitudFormato.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.$row3['nomDpto'].'</th>
                            <th>'.$row2['nomUsuario']." ".$row2['apellidoUsuario'].'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.$row['Estado'].'</th>
                            <th><input type="submit" value="Modificar Solicitud"></th>
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
        echo "<script>exito('Solicitud Modificada');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false && isset($_POST['tipoForm2'])){
        echo "<script>fracaso('Error! Solicitud no Modificada');</script>";
    }
?>

