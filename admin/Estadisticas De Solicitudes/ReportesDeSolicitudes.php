<?php  
  require "../../includes/funciones.php";  $auth = estaAutenticado();
  require "../../includes/config/database.php";
  if (!$auth) {
     header('location: /'); die();
  }
  
  inlcuirTemplate('header');
  $db =conectarDB();

  $queryEI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ESPERA' AND tipo = 'INTERNO'";
  $resultadoEI= mysqli_query($db, $queryEI);

  $queryAI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ACEPTADO' AND tipo = 'INTERNO'";
  $resultadoAI= mysqli_query($db, $queryAI);

  $queryRI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'RECHAZADO' AND tipo = 'INTERNO'";
  $resultadoRI= mysqli_query($db, $queryRI);

  $queryFI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'FINALIZADO'AND tipo = 'INTERNO'";
  $resultadoFI= mysqli_query($db, $queryFI);

  $queryCI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'CANCELADO'AND tipo = 'INTERNO'";
  $resultadoCI= mysqli_query($db, $queryCI);

  $rowEI = mysqli_fetch_assoc($resultadoEI);
  $rowAI = mysqli_fetch_assoc($resultadoAI);
  $rowRI = mysqli_fetch_assoc($resultadoRI);
  $rowFI = mysqli_fetch_assoc($resultadoFI);
  $rowCI = mysqli_fetch_assoc($resultadoCI);


  $queryEE = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ESPERA' AND tipo = 'EXTERNO'";
  $resultadoEE= mysqli_query($db, $queryEE);

  $queryAE = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ACEPTADO' AND tipo = 'EXTERNO'";
  $resultadoAE= mysqli_query($db, $queryAE);

  $queryRE = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'RECHAZADO' AND tipo = 'EXTERNO'";
  $resultadoRE= mysqli_query($db, $queryRE);

  $queryFE = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'FINALIZADO'AND tipo = 'EXTERNO'";
  $resultadoFE= mysqli_query($db, $queryFE);

  $queryCE = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'CANCELADO'AND tipo = 'EXTERNO'";
  $resultadoCE= mysqli_query($db, $queryCE);

  $rowEE = mysqli_fetch_assoc($resultadoEE);
  $rowAE = mysqli_fetch_assoc($resultadoAE);
  $rowRE = mysqli_fetch_assoc($resultadoRE);
  $rowFE = mysqli_fetch_assoc($resultadoFE);
  $rowCE = mysqli_fetch_assoc($resultadoCE);

?>
<main class="ReportesDeSolicitudes">
    <section class="w80">
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Reportes De Solicitudes Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Reportes De Solicitudes Mantenimiento De Equipo</h1>');
            }
        ?>
        <div class="btnsLista">
            <input type="button" onclick="mostrarContenido6();" value="Consultar por departamento" class="btnChoseD">
            <input type="button" onclick="mostrarContenido7();" value="Consulta general" class="btnChoseG" >
            
        </div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        google.charts.setOnLoadCallback(drawChart2);
        function drawChart1() {
            var data = google.visualization.arrayToDataTable([
            ['Estado', 'Número de solicitudes'],
            <?php 
                echo "['" .'ESPERA INTERNO'."', " .$rowEI['contador']."],".
                "['" .'ACEPTADO INTERNO'."', " .$rowAI['contador']."],".
                "['" .'RECHAZADO INTERNO'."', " .$rowRI['contador']."],".
                "['" .'FINALIZADO INTERNO'."', " .$rowFI['contador']."],".
                "['" .'CANCELADO INTERNO'."', " .$rowCI['contador']."]"
                ;
            ?>
            ]);
            var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
            chart.draw(data);
        }

        function drawChart2() {
            var data2 = google.visualization.arrayToDataTable([
            ['Estado', 'Número de solicitudes'],
            <?php 
                echo "['" .'ESPERA EXTERNO'."', " .$rowEE['contador']."],".
                "['" .'ACEPTADO EXTERNO'."', " .$rowAE['contador']."],".
                "['" .'RECHAZADO EXTERNO'."', " .$rowRE['contador']."],".
                "['" .'FINALIZADO EXTERNO'."', " .$rowFE['contador']."],".
                "['" .'CANCELADO EXTERNO'."', " .$rowCE['contador']."]"
                ;
            ?>
            ]);
            var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart2.draw(data2);
        }
        </script>
        <div id="grafico">
            <div class = "int">
                <div id="piechart1"></div>
            </div>

            <div class = "ext">
                <div id="piechart2"></div>
            </div>
            <div class ="cont">
            <?php 
                    $query ="SELECT * FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ACEPTADO' AND Etapa = '2PROCESO'";
                    $resultado = mysqli_query($db, $query);
                    echo('
                    <table class="tabla">
                    <tr>
                        <th>TIPO/ESTADO</th>
                        <th>ESPERA</th>
                        <th>ACEPTADO</th>
                        <th>RECHAZADO</th>
                        <th>FINALIZADO</th>
                        <th>CANCELADO</th>
                        </tr>'); 
                            echo('
                            <tr>
                                <th>INTERNO</th>
                                <th>'.$rowEI['contador'].'</th>
                                <th>'.$rowAI['contador'].'</th>
                                <th>'.$rowRI['contador'].'</th>
                                <th>'.$rowFI['contador'].'</th>
                                <th>'.$rowCI['contador'].'</th>
                            </tr>');

                            echo('
                            <tr>
                                <th>EXTERNO</th>
                                <th>'.$rowEE['contador'].'</th>
                                <th>'.$rowAE['contador'].'</th>
                                <th>'.$rowRE['contador'].'</th>
                                <th>'.$rowFE['contador'].'</th>
                                <th>'.$rowCE['contador'].'</th> </tr>');
                        echo('</table> ');
                ?>
            </div>
        </div>

        <div id ="porDpto1">
            <?php 
            $query ="SELECT * FROM departamentos";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>DEPARTAMENTO</th>
                <th>ESPERA INTERNO</th>
                <th>ACEPTADO INTERNO</th>
                <th>RECHAZADO INTERNO</th>
                <th>FINALIZADO INTERNO</th>
                <th>CANCELADO INTERNO</th>
                </tr>'); 
                while ($row = mysqli_fetch_array($resultado)){
                    $queryEIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'ESPERA' AND s.tipo = 'INTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoEIG = mysqli_query($db, $queryEIG);
                    $rowEIG = mysqli_fetch_assoc($resultadoEIG);

                    $queryAIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'ACEPTADO' AND s.tipo = 'INTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoAIG = mysqli_query($db, $queryAIG);
                    $rowAIG = mysqli_fetch_assoc($resultadoAIG);
        
                    $queryRIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'RECHAZADO' AND s.tipo = 'INTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoRIG = mysqli_query($db, $queryRIG);
                    $rowRIG = mysqli_fetch_assoc($resultadoRIG);
        
                    $queryFIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'FINALIZADO' AND s.tipo = 'INTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoFIG = mysqli_query($db, $queryFIG);
                    $rowFIG = mysqli_fetch_assoc($resultadoFIG);
        
                    $queryCIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'CANCELADO' AND s.tipo = 'INTERNO' AND u.idDpto = $row[idDpto]" ;
                    $resultadoCIG = mysqli_query($db, $queryCIG);
                    $rowCIG = mysqli_fetch_assoc($resultadoCIG);
                    
                    echo('
                    <tr>
                        <th>'.$row['nomDpto'].'</th>');
                        if($rowEIG['contador'] != 0){
                            echo('<th>'.$rowEIG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowAIG['contador'] != 0){
                            echo('<th>'.$rowAIG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowRIG['contador'] != 0){
                            echo('<th>'.$rowRIG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowFIG['contador'] != 0){
                            echo('<th>'.$rowFIG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowCIG['contador'] != 0){
                            echo('<th>'.$rowCIG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }

                        echo('
                    </tr>');
                }
                echo('</table>');
            ?>  
        </div>
        <div id="porDpto2">
        <?php 
            $query ="SELECT * FROM departamentos";
            $resultado = mysqli_query($db, $query);
            echo('
            <table class="tabla">
            <tr>
                <th>DEPARTAMENTO</th>
                <th>ESPERA EXTERNO</th>
                <th>ACEPTADO EXTERNO</th>
                <th>RECHAZADO EXTERNO</th>
                <th>FINALIZADO EXTERNO</th>
                <th>CANCELADO EXTERNO</th>
                </tr>'); 
                while ($row = mysqli_fetch_array($resultado)){
                    $queryEEG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'ESPERA' AND s.tipo = 'EXTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoEEG = mysqli_query($db, $queryEEG);
                    $rowEEG = mysqli_fetch_assoc($resultadoEEG);

                    $queryAEG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'ACEPTADO' AND s.tipo = 'EXTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoAEG = mysqli_query($db, $queryAEG);
                    $rowAEG = mysqli_fetch_assoc($resultadoAEG);
        
                    $queryREG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'RECHAZADO' AND s.tipo = 'EXTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoREG = mysqli_query($db, $queryREG);
                    $rowREG = mysqli_fetch_assoc($resultadoREG);
        
                    $queryFEG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'FINALIZADO' AND s.tipo = 'EXTERNO' AND u.idDpto = $row[idDpto]";
                    $resultadoFEG = mysqli_query($db, $queryFEG);
                    $rowFEG = mysqli_fetch_assoc($resultadoFEG);
        
                    $queryCEG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'CANCELADO' AND s.tipo = 'EXTERNO' AND u.idDpto = $row[idDpto]" ;
                    $resultadoCEG = mysqli_query($db, $queryCEG);
                    $rowCEG = mysqli_fetch_assoc($resultadoCEG);

                    echo('
                    <tr>
                        <th>'.$row['nomDpto'].'</th>');
                        if($rowEEG['contador'] != 0){
                            echo('<th>'.$rowEEG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowAEG['contador'] != 0){
                            echo('<th>'.$rowAEG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowREG['contador'] != 0){
                            echo('<th>'.$rowREG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowFEG['contador'] != 0){
                            echo('<th>'.$rowFEG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        if($rowCEG['contador'] != 0){
                            echo('<th>'.$rowCEG['contador'].'</th>');
                        }else{
                            echo ('<th></th>');
                        }
                        echo('
                    </tr>');
                }
                echo('</table>');
            ?>
        </div>
        
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>