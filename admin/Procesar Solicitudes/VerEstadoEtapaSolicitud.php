<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

?>
<main class="VerEstadoEtapaSolicitud">
    <section class="w80">
        <h1>Ver Solicitudes de Centro de Cómputo</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idUser = $_SESSION[idUser] AND idDpto = 20 ORDER BY Etapa ASC ";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>FECHA</th>
                <th>DESCRIPCIÓN</th>
                <th>ESTADO</th>
                <th>DETALLES</th>
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
                    }else{
                        echo('<form method="GET" action ="VerEstadoEtapaSolicitudFormato.php">'); 
                    }




                    
                    echo('
                        <input name = "'.$row['folio'].'" type="hidden">');
                        if($row['Estado'] != "RECHAZADO"){
                            echo('
                        <tr class="espera">
                            <th>'.$row['fecha'].'</th>
                            <th>'.substr("$row[descripcion]", 0,50).'</th>
                            <th>'.$row['Estado'].'</th>
                            ');
                        if ($row['Etapa'] == "1PENDIENTE"){
                                echo('<th><input class = "pen"type="submit" value="Cancelar Solicitud"></th>');        
                            }if($row['Etapa'] == "2PROCESO"){
                                echo('<th><input class = "pro"type="submit" value="Finalizar Servicio"></th>');  
                            }if($row['Etapa'] == "3FINALIZADO"){
                                echo('<th><input class = "fin"type="submit" value="Ver detalles"></th>');  
                            }
                        echo('
                        </tr>');
                        }else{
                            echo('
                        <tr class="rechazado">
                            <th>'.$row['fecha'].'</th>
                            <th>'.substr("$row[descripcion]", 0,40).'</th>
                            <th>'.$row['Estado'].'</th>
                            <th><input class = "pen"type="submit" value="Modificar Solicitud"></th>
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
?>

