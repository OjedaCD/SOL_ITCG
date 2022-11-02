<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

    $ban = null;
    if($_SERVER['REQUEST_METHOD']==="POST"){
        
        $folio = $_POST['tipoForm2'];
        $btn= $_POST['btn'];
        
        if($btn == "Finalizar Solicitud"){
            $queryA = "UPDATE solicitudes SET  Etapa = 'FINALIZADO' WHERE folio = '$folio'";
            $resultadoA=mysqli_query($db, $queryA);
            $ban = true;
        }elseif($btn == "Cancelar Solicitud"){
            $queryR = "UPDATE solicitudes SET  `Estado`='CANCELADO', Etapa = 'FINALIZADO' WHERE folio = '$folio'";
            $resultadoR=mysqli_query($db, $queryR);
            $ban = false;
        }
    }

?>
<main class="VerSolicitudesEntrantes">
    <section class="w80">
        <h1>Solicitudes Aceptadas</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ACEPTADO' AND Etapa = 'PROCESO'";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>DEPARTAMENTO</th>
                <th>SOLICITANTE</th>
                <th>FECHA DE ENVÍO</th>
                <th>ESTADO</th>
                <th>FINALIZAR/CANCELAR</th>
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

                    echo('<form method="GET" action ="FinalizarCancelar.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.$row3['nomDpto'].'</th>
                            <th>'.$row2['nomUsuario']." ".$row2['apellidoUsuario'].'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.$row['Estado'].'</th>
                            <th><input type="submit" value="Finalizar o Cancelar"></th>
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
        echo "<script>exito('Solicitud Finalizada');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false && isset($_POST['tipoForm2'])){
        echo "<script>fracaso('Solicitud Cancelada');</script>";
    }
?>

