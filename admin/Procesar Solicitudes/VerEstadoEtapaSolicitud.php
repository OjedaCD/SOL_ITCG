<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

?>
<main class="VerSolicitudesEntrantes">
    <section class="w80">
        <h1>Ver Estado o Etapa de Solicitud</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idUser = $_SESSION[idUser]  ORDER BY Etapa DESC ";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>ÁREA SOLICITANTE</th>
                <th>FECHA DE ENVÍO</th>
                <th>ESTADO</th>
                <th>ETAPA</th>
                <th>VER SOLICITUD</th>
                </tr>'); 
                while ($row = mysqli_fetch_array($resultado)){
                   

                    $queryDpto ="SELECT d.nomDpto FROM departamentos as d
                    INNER JOIN solicitudes as s ON s.idDpto = d.idDpto WHERE s.folio = $row[folio]";//Selecciono el id del usurio
                    $resultadoDpto = mysqli_query($db, $queryDpto);
                    $row3 = mysqli_fetch_array($resultadoDpto);

                    echo('<form method="GET" action ="VerEstadoEtapaSolicitudFormato.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.$row3['nomDpto'].'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.$row['Estado'].'</th>
                            <th>'.$row['Etapa'].'</th>
                            <th><input type="submit" value="Ver Solicitud"></th>
                        </tr>
                    </form>');
                }
                echo('</table>');
            ?>
    </section>
</main>

<?php 
    inlcuirTemplate('footer');
?>

