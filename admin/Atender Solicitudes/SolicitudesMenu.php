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

    }

?>
<main class="VerSolicitudMenu">
    <section class="w80">

        
        <?php 
            $query ="SELECT * FROM solicitudes as s INNER JOIN users as u ON s.encargadoS = u.email WHERE u.idUser = $_SESSION[idUser] AND s.idDpto = 20 ORDER BY s.Etapa ASC, s.Fecha DESC";
            $resultado = mysqli_query($db, $query);

            $queryName ="SELECT nomUsuario, apellidoUsuario FROM users WHERE idUser = $_SESSION[idUser]";
            $resultadoName = mysqli_query($db, $queryName);
            $aux = mysqli_fetch_assoc($resultadoName);

            echo ("<h1>Solicitudes asignadas a ".$aux["nomUsuario"]." ".$aux["apellidoUsuario"]."</h1>");
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
                    echo('<form method="GET" action ="SolicitudFormato.php">');

                    echo('
                        <input name = "folio"value = "'.$row['folio'].'" type="hidden">');
                        if($row['Estado'] == "ESPERA" || $row['Estado'] == "FINALIZADO"|| $row['Estado'] == "CANCELADO" || intval($row['validacion']) == 0 && $row['Estado'] == "ACEPTADO"){
                            echo('
                        <tr class="espera">
                            <th>'.substr("$row[folio]", 8).'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.substr("$row[descripcion]", 0,50).'</th>
                            <th>'.$row['Estado'].'</th>
                            ');
                        if ($row['Etapa'] == "1PENDIENTE"){
                                echo('<th><input class = "pen"type="submit" value="Orden de Trabajo"></th>');        
                            }if($row['Etapa'] == "2PROCESO"){
                                echo('<th><input class = "pro"type="submit" value="Orden de Trabajo"></th>');  
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
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true) {
        echo "<script>exito('Solicitud Atendida');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false){
        echo "<script>fracaso('Error! Solicitud no Atendida');</script>";
    }
?>

