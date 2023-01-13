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
                "['" .'RECHAZADO INTERNO'."', " .$rowAI['contador']."],".
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
                "['" .'RECHAZADO EXTERNO'."', " .$rowAE['contador']."],".
                "['" .'FINALIZADO EXTERNO'."', " .$rowFE['contador']."],".
                "['" .'CANCELADO EXTERNO'."', " .$rowCE['contador']."]"
                ;
            ?>
            ]);
            var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart2.draw(data2);
        }
        </script>
        <div class="grafico">
            <div id="piechart1"></div>
            <div id="piechart2"></div>
        </div>
        
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>