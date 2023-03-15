<?php  
  require "../../includes/funciones.php";  $auth = estaAutenticado();
  require "../../includes/config/database.php";
  if (!$auth) {
     header('location: /'); die();
  }
  
  inlcuirTemplate('header');
  $db =conectarDB();

  $queryEI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ESPERA' ";
  $resultadoEI= mysqli_query($db, $queryEI);

  $queryAI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ACEPTADO' ";
  $resultadoAI= mysqli_query($db, $queryAI);

  $queryRI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'RECHAZADO' ";
  $resultadoRI= mysqli_query($db, $queryRI);

  $queryFI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'FINALIZADO'";
  $resultadoFI= mysqli_query($db, $queryFI);

  $queryCI = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'CANCELADO'";
  $resultadoCI= mysqli_query($db, $queryCI);

  $queryCT = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado != 'CANCELADO'";
  $resultadoCT = mysqli_query($db, $queryCT);

  $rowEI = mysqli_fetch_assoc($resultadoEI);
  $rowAI = mysqli_fetch_assoc($resultadoAI);
  $rowRI = mysqli_fetch_assoc($resultadoRI);
  $rowFI = mysqli_fetch_assoc($resultadoFI);
  $rowCI = mysqli_fetch_assoc($resultadoCI);
  $rowCT = mysqli_fetch_assoc($resultadoCT);
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
                echo "['" .'ESPERA '."', " .$rowEI['contador']."],".
                "['" .'ACEPTADO '."', " .$rowAI['contador']."],".
                "['" .'RECHAZADO '."', " .$rowRI['contador']."],".
                "['" .'FINALIZADO '."', " .$rowFI['contador']."],".
                "['" .'CANCELADO '."', " .$rowCI['contador']."]"
                ;
            ?>
            ]);
            var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
            chart.draw(data);
        }

        </script>
        <div id="grafico">
            <div class = "int">
                <div id="piechart1"></div>
            </div>

            <div class ="cont">
            <?php 
                    $query ="SELECT * FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Estado = 'ACEPTADO' AND Etapa = '2PROCESO'";
                    $resultado = mysqli_query($db, $query);
                    echo('
                    <table class="tabla">
                    <tr>
                        <th>ESTADO</th>
                        <th>ESPERA</th>
                        <th>ACEPTADO</th>
                        <th>RECHAZADO</th>
                        <th>FINALIZADO</th>
                        <th>CANCELADO</th>
                        <th>RECIBIDAS</th>
                        
                        </tr>'); 
                            echo('
                            <tr>
                                <th>SOLICITUDES</th>
                                <th>'.$rowEI['contador'].'</th>
                                <th>'.$rowAI['contador'].'</th>
                                <th>'.$rowRI['contador'].'</th>
                                <th>'.$rowFI['contador'].'</th>
                                <th>'.$rowCI['contador'].'</th>
                                <th>'.$rowCT['contador'].'</th>
                            </tr>
                            </tr>');

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
                <th>ESPERA</th>
                <th>ACEPTADO </th>
                <th>RECHAZADO </th>
                <th>FINALIZADO </th>
                <th>CANCELADO </th>
                </tr>'); 
                while ($row = mysqli_fetch_array($resultado)){
                    $queryEIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'ESPERA' AND u.idDpto = $row[idDpto]";
                    $resultadoEIG = mysqli_query($db, $queryEIG);
                    $rowEIG = mysqli_fetch_assoc($resultadoEIG);

                    $queryAIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'ACEPTADO' AND u.idDpto = $row[idDpto]";
                    $resultadoAIG = mysqli_query($db, $queryAIG);
                    $rowAIG = mysqli_fetch_assoc($resultadoAIG);
        
                    $queryRIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'RECHAZADO' AND u.idDpto = $row[idDpto]";
                    $resultadoRIG = mysqli_query($db, $queryRIG);
                    $rowRIG = mysqli_fetch_assoc($resultadoRIG);
        
                    $queryFIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'FINALIZADO' AND u.idDpto = $row[idDpto]";
                    $resultadoFIG = mysqli_query($db, $queryFIG);
                    $rowFIG = mysqli_fetch_assoc($resultadoFIG);
        
                    $queryCIG ="SELECT COUNT(*) AS 'contador' FROM solicitudes AS s INNER JOIN users AS u ON s.idUser = u.idUser WHERE  s.idDpto = $_SESSION[idDpto] AND s.Estado = 'CANCELADO' AND u.idDpto = $row[idDpto]" ;
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
        
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>