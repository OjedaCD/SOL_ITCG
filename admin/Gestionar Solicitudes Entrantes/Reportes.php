<?php  
  require "../../includes/funciones.php";  $auth = estaAutenticado();
  require "../../includes/config/database.php";
  if (!$auth) {
     header('location: /'); die();
  }
  
  inlcuirTemplate('header');
  $db =conectarDB();

  $queryP = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Etapa = 'PENDIENTE'";
  $resultadoP= mysqli_query($db, $queryP);

  $queryPr = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Etapa = 'PROCESO'";
  $resultadoPr= mysqli_query($db, $queryPr);

  $queryF = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto] AND Etapa = 'FINALIZADO'";
  $resultadoF= mysqli_query($db, $queryF);

  $rowP = mysqli_fetch_assoc($resultadoP);
  $rowPr = mysqli_fetch_assoc($resultadoPr);
  $rowF = mysqli_fetch_assoc($resultadoF);
?>
<main class="Reportes">
    <section class="w80">
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Reportes de Solicitudes Centro de Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Reportes de Solicitudes Mantenimiento de Equipo</h1>');
            }
        ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {


        var data = google.visualization.arrayToDataTable([
          ['Etapa', 'Número de solicitudes'],
          <?php 
            echo "['" .'PENDIENTE'."', " .$rowP['contador']."],".
            "['" .'PROCESO'."', " .$rowPr['contador']."],".
            "['" .'FINALIZADO'."', " .$rowF['contador']."]"
            ;
        ?>
        ]);

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data);
        }
        </script>

        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>