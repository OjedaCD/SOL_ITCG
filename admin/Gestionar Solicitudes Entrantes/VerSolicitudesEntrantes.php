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
    $ban = null;
    if($_SERVER['REQUEST_METHOD']==="GET"){
        
        $folio = $_GET['tipoForm2']?? null;;
        $observacion = $_GET['observacion']?? null;;
        $btn= $_GET['btn']?? null;;

        $queryOb = "UPDATE solicitudes SET  `observacion`='$observacion'WHERE folio = '$folio'";
        $resultadoOb=mysqli_query($db, $queryOb);
        if($resultadoOb){
            
            if($btn == "Aceptar Solicitud"){
                $queryA = "UPDATE solicitudes SET  `Estado`='ACEPTADO', `Etapa`='PROCESO' WHERE folio = '$folio'";
                $resultadoA=mysqli_query($db, $queryA);
                $ban = true;
            }elseif($btn == "Rechazar Solicitud"){
                $queryR = "UPDATE solicitudes SET  `Estado`='RECHAZADO', `Etapa`='PENDIENTE' WHERE folio = '$folio'";
                $resultadoR=mysqli_query($db, $queryR);
                $ban = false;
            }
            
        }
    }

    
?>
<main class="VerSolicitudesEntrantes">
    <section class="w80">
        <h1>Ver Solicitudes Entrantes</h1>
        <?php
            $query ="SELECT * FROM solicitudes WHERE (Estado = 'ESPERA' OR Estado = 'RECHAZADO') AND idDpto = $_SESSION[idDpto] AND Etapa = 'PENDIENTE' ORDER BY Estado ASC , fecha ASC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>DEPARTAMENTO</th>
                <th>NOMBRE</th>
                <th>FECHA DE ENVÍO</th>
                <th>ESTADO</th>
                <th>DETALLES</th>
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

                echo('<form method="POST" action ="VerSolicitud.php">
                    <input name = "'.$row['folio'].'" type="hidden">
                    <tr>
                        <th>'.$row3['nomDpto'].'</th>
                        <th>'.$row2['nomUsuario']." ".$row2['apellidoUsuario'].'</th>
                        <th>'.$row['fecha'].'</th>
                        <th>'.$row['Estado'].'</th>
                        
                        <th><input type="submit" value="Ver detalles"></th>
                        
                    </tr>
                </form>');
            }
            echo('</table>');
        ?>
    </section>
</main>

<?php 
    inlcuirTemplate('footer');
    
    if ($_SERVER['REQUEST_METHOD'] === "GET" && $ban == true && isset($_GET['tipoForm2'])) {
        echo "<script>exito('Solicitud Aceptada');</script>";
        
    }if($_SERVER['REQUEST_METHOD'] === "GET" && $ban == false && isset($_GET['tipoForm2'])){
        echo "<script>fracaso('Solicitud Rechazada');</script>";
    }
?>

