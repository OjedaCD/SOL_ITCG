<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

?>
<main class="SolicitudesFinalizadas">
    <section class="w80">
    <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Solicitudes Finalizadas Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Solicitudes Finalizadas Mantenimiento de Equipo</h1>');
            }
        ?>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Etapa = '3FINALIZADO' ORDER BY Estado ASC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>NUM</th>
                <th>DEPARTAMENTO</th>
                <th>SOLICITANTE</th>
                <th>FECHA</th>
                <th>DESCRIPCIÓN</th>
                <th>FINALIZADA</th>
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
                    echo('<form method="GET" action ="SolicitudesFinalizadasFormato.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.substr("$row[folio]", 4,-4).'</th>
                            <th>'.substr("$row3[nomDpto]", 0,26).'</th>
                            <th>'.substr("$name", 0,15).'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.substr("$row[descripcion]", 0,30).'</th>
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

