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
    $ban2 = null;
    if($_SERVER['REQUEST_METHOD']==="POST"){
        
        $folio = $_POST['tipoForm2'];
        $observacion = $_POST['observacion'];
        $btn= $_POST['btn'];
        $prioridad = $_POST['prioridad'];
        $tipo = $_POST['tipo'];

        if($btn == "Aceptar Solicitud"){
            $queryA = "UPDATE solicitudes SET `observacion`='$observacion', `tipo`='$tipo', `Prioridad`='$prioridad', `Estado`='ACEPTADO', `Etapa`='PROCESO' WHERE folio = '$folio'";
            $resultadoA=mysqli_query($db, $queryA);
            $ban = true;
        }elseif($btn == "Actualizar Comentario"){
            $queryAC = "UPDATE solicitudes SET `observacion`='$observacion', `tipo`='$tipo', `Prioridad`='$prioridad', `Estado`='ESPERA', `Etapa`='PENDIENTE' WHERE folio = '$folio'";
            $resultadoAC=mysqli_query($db, $queryAC);
            $ban2 = true;
        }elseif($btn == "Rechazar Solicitud"){
            $queryR = "UPDATE solicitudes SET `observacion`='$observacion', `tipo`='$tipo', `Prioridad`='$prioridad', `Estado`='RECHAZADO', `Etapa`='PENDIENTE' WHERE folio = '$folio'";
            $resultadoR=mysqli_query($db, $queryR);
            $ban = false;
        }
    }

    
?>
<main class="VerSolicitudesEntrantes">
    <section class="w80">
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Ver Solicitudes Entrantes Centro de Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Ver Solicitudes Entrantes Mantenimiento de Equipo</h1>');
            }
        ?>
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

                echo('<form method="GET" action ="VerSolicitudFormato.php">
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
    
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true ) {
        echo "<script>exito('Solicitud Aceptada');</script>";
    }
    if($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false ){
        echo "<script>fracaso('Solicitud Rechazada');</script>";
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $ban2 == true ) {
        echo "<script>exito('Comentario Actualizado');</script>";
    }
?>

