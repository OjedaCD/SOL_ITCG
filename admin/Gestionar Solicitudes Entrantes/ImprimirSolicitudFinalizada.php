<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

?>
<main class="ImprimirSolicitudFinalizada">
    <section class="w80">
        <h1>Imprimir Solicitud Finalizada</h1>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Etapa = 'FINALIZADO' ORDER BY Estado ASC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>ÁREA SOLICITANTE</th>
                <th>FECHA DE ENVÍO</th>
                <th>ESTADO</th>
                <th>ETAPA</th>
                <th>VER DETALLES</th>
                </tr>'); 
                while ($row = mysqli_fetch_array($resultado)){
              
                    $queryDpto ="SELECT d.nomDpto FROM departamentos as d
                    INNER JOIN solicitudes as s ON s.idDpto = d.idDpto WHERE s.folio = '$row[folio]'";//Selecciono el id del usurio
                    $resultadoDpto = mysqli_query($db, $queryDpto);
                    $row3 = mysqli_fetch_array($resultadoDpto);


                    echo('<form method="GET" action ="ImprimirSolicitudFinalizadaFormato.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.$row3['nomDpto'].'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.$row['Estado'].'</th>
                            <th>'.$row['Etapa'].'</th>
                            <th><input type="submit" value="Imprimir"></th>
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

