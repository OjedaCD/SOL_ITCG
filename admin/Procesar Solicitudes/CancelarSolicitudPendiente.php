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

        $folio = $_POST['tipoForm2'];


        $queryIdSol = "SELECT s.idSolicitud FROM solicitudes as s WHERE s.folio = $folio";
        $resultadoIdSol =mysqli_query($db, $queryIdSol);
        $aux3 = mysqli_fetch_assoc($resultadoIdSol);//Guarda el id de la solicitud

        
        foreach ($aux3 as $key => $idSol) {
            $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
            $resultadoLlave0 = mysqli_query($db, $query0);
        
            $querySol = "UPDATE solicitudes SET Estado ='CANCELADO' , Etapa = 'FINALIZADO' WHERE idSolicitud = '$idSol'";
            $resultadoUs =mysqli_query($db, $querySol);

            $query1 = "SET FOREIGN_KEY_CHECKS=1";
            $resultadoLlave0 = mysqli_query($db, $query1);

            if($resultadoUs){
                $ban = true;
            }else{
                $ban = false;
            }
        }
    }
?>
<main class="CancelarSolicitudPendiente">
    <section class="w80">
        <h1>Cancelar Solicitud Pendiente</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idUser = $_SESSION[idUser] AND Estado = 'ESPERA' AND Etapa = 'PENDIENTE' ORDER BY fecha ASC";
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
                    INNER JOIN solicitudes as s ON s.idDpto = d.idDpto WHERE s.folio = $row[folio]";//Selecciono el id del usurio
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

