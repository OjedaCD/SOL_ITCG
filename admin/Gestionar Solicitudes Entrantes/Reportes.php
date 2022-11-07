<?php  
  require "../../includes/funciones.php";  $auth = estaAutenticado();
  require "../../includes/config/database.php";
  if (!$auth) {
     header('location: /'); die();
  }
  
  inlcuirTemplate('header');
  $db =conectarDB();


?>
<main class="Reportes">
    <section class="w80">
        <h1>Reportes de Solicitudes</h1>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                <?php 
                    $query = "SELECT * FROM solicitudes";
                    $resultadoQuery = mysqli_query($db, $query);
                     while($row = mysqli_fetch_assoc($resultadoQuery)){
                        echo "['" .$row['Estado']."'],";
                     }
                    ?>
            ]);

            var options = {
            title: 'REPORTES CENTRO DE CÓMPUTO'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        </script>

        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>