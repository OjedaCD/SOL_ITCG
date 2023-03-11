<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};
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

    $queryCT = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto]";
    $resultadoCT = mysqli_query($db, $queryCT);
  
    $rowEI = mysqli_fetch_assoc($resultadoEI);
    $rowAI = mysqli_fetch_assoc($resultadoAI);
    $rowRI = mysqli_fetch_assoc($resultadoRI);
    $rowFI = mysqli_fetch_assoc($resultadoFI);
    $rowCI = mysqli_fetch_assoc($resultadoCI);

    $rowCT = mysqli_fetch_assoc($resultadoCT);

    if ($_SERVER['REQUEST_METHOD']==="POST" ){
            $btn= $_POST['btn'];
            $excel= new Spreadsheet();
            $hojaActiva = $excel->getActiveSheet();
            if($btn == "Estadísticas Generales"){
                $hojaActiva->setTitle("Estadísticas");
                $hojaActiva->getColumnDimension('A')->setWidth(15);
                $hojaActiva->setCellValue('A1','ESTADO');
                $hojaActiva->getColumnDimension('B')->setWidth(15);
                $hojaActiva->setCellValue('B1','ESPERA');
                $hojaActiva->getColumnDimension('C')->setWidth(15);
                $hojaActiva->setCellValue('C1','ACEPTADO');
                $hojaActiva->getColumnDimension('D')->setWidth(15);
                $hojaActiva->setCellValue('D1','RECHAZADO');
                $hojaActiva->getColumnDimension('E')->setWidth(15);
                $hojaActiva->setCellValue('E1','FINALIZADO');
                $hojaActiva->getColumnDimension('F')->setWidth(15);
                $hojaActiva->setCellValue('F1','CANCELADO');
                $hojaActiva->getColumnDimension('G')->setWidth(15);
                $hojaActiva->setCellValue('G1','TOTAL');
                
                $hojaActiva->setCellValue('A2','SOLICITUDES');
                $hojaActiva->setCellValue('B2',$rowEI['contador']);
                $hojaActiva->setCellValue('C2',$rowAI['contador']);
                $hojaActiva->setCellValue('D2',$rowRI['contador']);
                $hojaActiva->setCellValue('E2',$rowFI['contador']);
                $hojaActiva->setCellValue('F2',$rowCI['contador']);
                $hojaActiva->setCellValue('G2',$rowCT['contador']);

                ob_end_clean();    
                // redirect output to client browser
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Estadísticas.xlsx"');
                header('Cache-Control: max-age=0');
            }elseif($btn == "Estadísticas Por Dpto"){
                
                $query ="SELECT * FROM departamentos";
                $resultado = mysqli_query($db, $query);

                $hojaActiva->setTitle("Departamento Interno");
                $hojaActiva->getColumnDimension('A')->setWidth(55);
                $hojaActiva->setCellValue('A1','DEPARTAMENTO');
                $hojaActiva->getColumnDimension('B')->setWidth(15);
                $hojaActiva->setCellValue('B1','ESPERA');
                $hojaActiva->getColumnDimension('C')->setWidth(15);
                $hojaActiva->setCellValue('C1','ACEPTADO');
                $hojaActiva->getColumnDimension('D')->setWidth(15);
                $hojaActiva->setCellValue('D1','RECHAZADO');
                $hojaActiva->getColumnDimension('E')->setWidth(15);
                $hojaActiva->setCellValue('E1','FINALIZADO');
                $hojaActiva->getColumnDimension('F')->setWidth(15);
                $hojaActiva->setCellValue('F1','CANCELADO');
                $hojaActiva->getColumnDimension('H')->setWidth(20);
                $hojaActiva->setCellValue('H1','SOLICITUDES TOTALES');
                $hojaActiva->setCellValue('H2',$rowCT['contador']);
                $fila = 2;
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
                    
                    $hojaActiva->setCellValue('A'.$fila,$row['nomDpto']);

                    if($rowEIG['contador'] != 0){
                        $hojaActiva->setCellValue('B'.$fila,$rowEIG['contador']);
                    }else{
                            
                        $hojaActiva->setCellValue('B'.$fila,"");
                    }
                    if($rowAIG['contador'] != 0){
                        $hojaActiva->setCellValue('C'.$fila,$rowAIG['contador']);
                    }else{
                        $hojaActiva->setCellValue('C'.$fila,"");
                    }
                    if($rowRIG['contador'] != 0){
                        $hojaActiva->setCellValue('D'.$fila,$rowRIG['contador']);
                    }else{
                        $hojaActiva->setCellValue('D'.$fila,"");
                    }
                    if($rowFIG['contador'] != 0){
                        $hojaActiva->setCellValue('E'.$fila,$rowFIG['contador']);
                    }else{
                        $hojaActiva->setCellValue('E'.$fila,"");
                    }
                    if($rowCIG['contador'] != 0){
                        $hojaActiva->setCellValue('F'.$fila,$rowCIG['contador']);
                    }else{
                        $hojaActiva->setCellValue('E'.$fila,"");
                    }
                    $fila++;
                }

                ob_end_clean();    
                // redirect output to client browser
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Estadístcias Dpto.xlsx"');
                header('Cache-Control: max-age=0');
            }

            $writer = IOFactory::createWriter($excel, 'Xlsx');
            $writer->save('php://output');
            exit;
    }

?>
<main class="ExportarDatos">
    <section class="w80">
        <?php 

            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Exportar Datos Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Exportar Datos Mantenimiento De Equipo</h1>');
            }
        ?>
        <form action="" method ="POST" class="BtnExcel">
            <input type="submit" name = "btn"  value="Estadísticas Generales" class="btnChoseG" >
            <input type="submit" name = "btn"  value="Estadísticas Por Dpto" class="btnChoseD" >
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>
