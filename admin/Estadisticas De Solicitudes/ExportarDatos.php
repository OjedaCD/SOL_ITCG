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
<main class="ExportarDatos">
    <section class="w80">
        <?php 
            require '../../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};
            
            $excel= new Spreadsheet();
            $hojaActiva = $excel->getActiveSheet();
            $hojaActiva->setTitle("Estadisticas");
        
            $hojaActiva->setCellValue('A1','TIPO/ESTADO');
            $hojaActiva->setCellValue('B1','ESPERA');
            $hojaActiva->setCellValue('C1','ACEPTADO');
            $hojaActiva->setCellValue('D1','RECHAZADO');
            $hojaActiva->setCellValue('E1','FINALIZADO');
            $hojaActiva->setCellValue('F1','CANCELADO');
        
            for ($i= 2; $i < 4; $i++) { 
                if($i == 2){
                    $hojaActiva->setCellValue('A'.$i,'INTERNO');
                    $hojaActiva->setCellValue('B'.$i,$rowEI['contador']);
                    $hojaActiva->setCellValue('C'.$i,$rowAI['contador']);
                    $hojaActiva->setCellValue('D'.$i,$rowRI['contador']);
                    $hojaActiva->setCellValue('E'.$i,$rowFI['contador']);
                    $hojaActiva->setCellValue('F'.$i,$rowCI['contador']);
                }elseif ($i == 3){
                    $hojaActiva->setCellValue('A'.$i,'EXTERNO');
                    $hojaActiva->setCellValue('B'.$i,$rowEE['contador']);
                    $hojaActiva->setCellValue('C'.$i,$rowAE['contador']);
                    $hojaActiva->setCellValue('D'.$i,$rowRE['contador']);
                    $hojaActiva->setCellValue('E'.$i,$rowFE['contador']);
                    $hojaActiva->setCellValue('F'.$i,$rowCE['contador']);
                }
                
            }//ponla en otra clase
            
                
            // redirect output to client browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Estadisticas.xlsx"');
            header('Cache-Control: max-age=0');
        
            $writer = IOFactory::createWriter($excel, 'Xlsx');
            $writer->save('php://output');
            exit;

            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Exportar Datos Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Exportar Datos Mantenimiento De Equipo</h1>');
            }
        ?>
      
        
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>
