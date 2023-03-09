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
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Imprimir Solicitud Finalizada Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Imprimir Solicitud Finalizada Mantenimiento de Equipo</h1>');
            }
        ?>
        <?php 
            $query ="SELECT * FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Etapa = '3FINALIZADO' ORDER BY Estado DESC, Fecha DESC";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>NUM</th>
                <th>DEPARTAMENTO</th>
                <th>SOLICITANTE</th>
                <th>FECHA-FIN</th>
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
                    echo('<form method="GET" action ="');
                    
                    if ($_SESSION['idDpto'] == 20){
                        echo ('ImprimirSolicitudCC.php');
                    }else{
                        echo ('ImprimirSolicitudME.php');
                    }
                    
                    echo('                    ">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.substr("$row[folio]", 4,-4).'</th>
                            <th>'.substr("$row3[nomDpto]", 0,26).'</th>
                            <th>'.substr("$name", 0,15).'</th>
                            <th>'.$row['fechaFin'].'</th>
                            <th>'.substr("$row[descripcion]", 0,30).'</th>');
                            if($row['Estado'] == "FINALIZADO"){
                                echo('<th><input class ="si" type="submit" value="Ver Solicitud"></th>');
                            }else{
                                echo('<th><input class ="no" type="submit" value="Ver Solicitud"></th>');
                            }
                            echo('
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

