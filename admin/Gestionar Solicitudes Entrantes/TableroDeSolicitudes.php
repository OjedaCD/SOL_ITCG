<?php  
 require "../../includes/funciones.php";  $auth = estaAutenticado();
 require "../../includes/config/database.php";
 if (!$auth) {
    header('location: /'); die();
 }
 
 inlcuirTemplate('header');
 $db =conectarDB();

 $queryCont = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto]";
 $resultadoCont = mysqli_query($db, $queryCont);
 $cont = mysqli_fetch_assoc($resultadoCont);
 $total = intval($cont['contador']);

 $querySolP = ("SELECT * FROM `solicitudes` WHERE Etapa = '1PENDIENTE' AND idDpto = $_SESSION[idDpto] ORDER BY Prioridad ASC");
 $resultadoSolP  = mysqli_query($db, $querySolP);
 $pendiente = array();
 foreach ($resultadoSolP as $key => $value) {
    array_push($pendiente ,$value["folio"]);
 }

 $querySolPr = ("SELECT * FROM `solicitudes` WHERE Etapa = '2PROCESO' AND idDpto = $_SESSION[idDpto] ORDER BY Prioridad ASC");
 $resultadoSolPr  = mysqli_query($db, $querySolPr);
 $proceso = array();
 foreach ($resultadoSolPr as $key => $value) {
    array_push($proceso,$value["folio"]);
 }


 $querySolF = ("SELECT * FROM `solicitudes` WHERE Etapa = '3FINALIZADO' AND idDpto = $_SESSION[idDpto] ORDER BY Estado DESC, Prioridad ASC");
 $resultadoSolF  = mysqli_query($db, $querySolF);
 $finalizado= array();
 foreach ($resultadoSolF as $key => $value) {
    array_push($finalizado,$value["folio"]);
 }


?>
<main class="TableroDeSolicitudes">
    <section class="w80">
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Tablero De Solicitudes Centro De Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Tablero De Solicitudes Mantenimiento De Equipo</h1>');
            }
        ?>
        <div class="contenedor">
        
            <div class="interna1">
                <h4>PENDIENTE</h4>
                <div class="container top">
                    <div class="row sortable"  id="drop-items">
                        <?php 
                            foreach ($pendiente as $key => $value) {
                                $query = "SELECT * FROM solicitudes where folio = '{$value}'";
                                $resultado = mysqli_query($db, $query);
                                $row= mysqli_fetch_assoc($resultado);
                                $querySol = ("SELECT nomUsuario, apellidoUsuario FROM `users` WHERE idUser = $row[idUser]");
                                $resultadoSol  = mysqli_query($db, $querySol);
                                $rowN= mysqli_fetch_assoc($resultadoSol);
            
                                
                                echo('              
                                <div class="col-md-6 col-lg-4" data-index="'.$row['folio'].'">
                                    <div class="');
                                    if($row['Prioridad'] == '1ALTA' ){
                                        $clase = 'drop__card1';
                                    }elseif($row['Prioridad'] == '2MEDIA'){
                                        $clase = 'drop__card2';
                                    }elseif($row['Prioridad'] == '3BAJA'){
                                        $clase = 'drop__card3';
                                    }
                                    echo $clase;
                                    echo('">
                                    <form method="GET" action="SolicitudesPendientesFormato.php">
                                        <div class="drop__data">
                                            <div>
                                                <h1 class="drop__name">'.$rowN["nomUsuario"]." ".$rowN["apellidoUsuario"].'</h1>
                                                <span class="drop__description">'.$row['descripcion'].'</span>
                                                <h1 class="drop__date">'.$row['fecha'].'</h1>
                                                <input name = "'.$row['folio'].'" type="hidden">');
                                                if ($row['Estado'] != "RECHAZADO"){
                                                    echo('<th><input class = "aceptado"type="submit" value="Ver Solicitud"></th>');
                                                }else{
                                                    echo('<th><input class = "rechazado"type="submit" value="Ver Solicitud"></th>');
                                                }
                                                echo('
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>');
                            }
                            ?>   
                        </div>
                    </div>
                </div>
            
            <div class="interna2">
            <h4>PROCESO</h4>
                <div class="container top">
                    <div class="row sortable"  id="drop-items">
                        <?php 
                            foreach ($proceso as $key => $value) {
                                $query = "SELECT * FROM solicitudes where folio = '{$value}'";
                                $resultado = mysqli_query($db, $query);
                                $row= mysqli_fetch_assoc($resultado);
                                $querySol = ("SELECT nomUsuario, apellidoUsuario FROM `users` WHERE idUser = $row[idUser]");
                                $resultadoSol  = mysqli_query($db, $querySol);
                                $rowN= mysqli_fetch_assoc($resultadoSol);
                
                                
                                echo('              
                                <div class="col-md-6 col-lg-4" data-index="'.$row['folio'].'">
                                    <div class="');
                                    if($row['Prioridad'] == '1ALTA' ){
                                        $clase = 'drop__card1';
                                    }elseif($row['Prioridad'] == '2MEDIA'){
                                        $clase = 'drop__card2';
                                    }elseif($row['Prioridad'] == '3BAJA'){
                                        $clase = 'drop__card3';
                                    }
                                    echo $clase;
                                    echo('">
                                    <form method="GET" action="SolicitudesEnProcesoFormato.php">
                                        <div class="drop__data">
                                            <div>
                                                <h1 class="drop__name">'.$rowN["nomUsuario"]." ".$rowN["apellidoUsuario"].'</h1>
                                                <span class="drop__description">'.$row['descripcion'].'</span>
                                                <h1 class="drop__date">'.$row['fecha'].'</h1>
                                                <input name = "'.$row['folio'].'" type="hidden">');
                                                if($row['validacion'] == 1){
                                                    echo('<th><input class = "si"type="submit" value="Ver Solicitud"></th>');  
                                                }if($row['validacion'] == 0){
                                                    echo('<th><input class = "no"type="submit" value="Ver Solicitud"></th>');  
                                                }
                                                echo('
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>');
                            }
                            ?>   
                    </div>
                </div>
            </div>
            <div class="interna3">
                <h4>FINALIZADA</h4>
                <div class="container top">
                    <div class="row sortable"  id="drop-items">
                        <?php 
                            foreach ($finalizado as $key => $value) {
                                $query = "SELECT * FROM solicitudes where folio = '{$value}'";
                                $resultado = mysqli_query($db, $query);
                                $row= mysqli_fetch_assoc($resultado);
                                $querySol = ("SELECT nomUsuario, apellidoUsuario FROM `users` WHERE idUser = $row[idUser]");
                                $resultadoSol  = mysqli_query($db, $querySol);
                                $rowN= mysqli_fetch_assoc($resultadoSol);
                
                                
                                echo('              
                                <div class="col-md-6 col-lg-4" data-index="'.$row['folio'].'">
                                    <div class="');
                                    if($row['Prioridad'] == '1ALTA' ){
                                        $clase = 'drop__card1';
                                    }elseif($row['Prioridad'] == '2MEDIA'){
                                        $clase = 'drop__card2';
                                    }elseif($row['Prioridad'] == '3BAJA'){
                                        $clase = 'drop__card3';
                                    }
                                    if($row['Estado'] == 'CANCELADO'){
                                        $clase = 'drop__card4';
                                    }
                                    echo $clase;
                                    echo('">
                                    <form method="GET" action="SolicitudesFinalizadasFormato.php">
                                        <div class="drop__data">
                                            <div>
                                                <h1 class="drop__name">'.$rowN["nomUsuario"]." ".$rowN["apellidoUsuario"].'</h1>
                                                <span class="drop__description">'.$row['descripcion'].'</span>
                                                <h1 class="drop__date">'.$row['fecha'].'</h1>
                                                <input name = "'.$row['folio'].'" type="hidden">');
                                                if($row['Estado'] == "FINALIZADO"){
                                                    echo('<th><input class ="si" type="submit" value="Ver Solicitud"></th>');
                                                }else{
                                                    echo('<th><input class ="no" type="submit" value="Ver Solicitud"></th>');
                                                }
                                                echo('
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>');
                            }
                            ?>   
                    </div>
                </div>
            </div>
        </div>
        


            <script type="text/javascript" charset="utf-8" src="/build/js/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" charset="utf-8" src="/build/js/jquery-ui.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                $('.sortable').sortable({
                    update: function (event, ui) {
                        $(this).children().each(function (index) {
                                if ($(this).attr('data-position') != (index+1)) {
                                    $(this).attr('data-position', (index+1)).addClass('updated');
                                   
                                }
                        });
                        guardandoPosiciones();
                    }
                });
                });

                function guardandoPosiciones() {
                    var positions = [];
                    $('.updated').each(function () {
                    positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                    $(this).removeClass('updated');
                    });
                }
            </script>
       
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>
