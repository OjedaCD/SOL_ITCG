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

 $querySolP = ("SELECT * FROM `solicitudes` WHERE Etapa = 'PENDIENTE' AND idDpto = $_SESSION[idDpto] ORDER BY Prioridad ASC");
 $resultadoSolP  = mysqli_query($db, $querySolP);
 $pendiente = array();
 foreach ($resultadoSolP as $key => $value) {
    array_push($pendiente ,$value["idSolicitud"]);
 }

 $querySolPr = ("SELECT * FROM `solicitudes` WHERE Etapa = 'PROCESO' AND idDpto = $_SESSION[idDpto] ORDER BY Prioridad ASC");
 $resultadoSolPr  = mysqli_query($db, $querySolPr);
 $proceso = array();
 foreach ($resultadoSolPr as $key => $value) {
    array_push($proceso,$value["idSolicitud"]);
 }


 $querySolF = ("SELECT * FROM `solicitudes` WHERE Etapa = 'FINALIZADO' AND idDpto = $_SESSION[idDpto] ORDER BY Prioridad ASC");
 $resultadoSolF  = mysqli_query($db, $querySolF);
 $finalizado= array();
 foreach ($resultadoSolF as $key => $value) {
    array_push($finalizado,$value["idSolicitud"]);
 }
 $banP = true;
 $banPr = null;
 $banF = null;
 $kanban = array();

?>
<main class="TableroKanban">
    <section class="w80">
        <?php 
            if($_SESSION['idDpto'] == 20 ){
                echo('<h1>Kanban Centro de Cómputo</h1>');
            }
            if($_SESSION['idDpto'] == 21 ){
                echo('<h1>Knaban Mantenimiento de Equipo</h1>');
            }
        ?>
        <div class="KanbanContent">
            <div class="container top">
            <link href ="/build/css/bootstrap.css" rel="stylesheet">
                <div class="row sortable"  id="drop-items">
                    <?php for ($i=1; $i < $total ; $i++) { //Se recorren todas las posiciones que son las solicitudes
                        
                        if($banP && $pendiente >= 0){
                            foreach ($pendiente as $key) {
                                $valorX  = array_shift($pendiente);
                                array_push($kanban, $valorX);
                                break;
                            }
                            $banP = false;
                            $banPr = true;
                            $banF = false;
                        }
                        if($banPr && $proceso >= 0){
                            foreach ($proceso as $key) {
                                $valorX  = array_shift($proceso);
                                array_push($kanban, $valorX);
                                break;
                            }
                            $banP = false;
                            $banPr = false;
                            $banF = true;
                        } 
                        if($banF && $finalizado >= 0){
                            foreach ($finalizado as $key) {
                                $valorX  = array_shift($finalizado);
                                array_push($kanban, $valorX);
                                break;
                            }
                            $banP = true;
                            $banPr = false;
                            $banF = false;
                        }     
                        
                    }


                    foreach ($kanban as $key => $value) {
                        $query = "SELECT * FROM solicitudes where idSolicitud = $value";
                        $resultado = mysqli_query($db, $query);
                        $row= mysqli_fetch_assoc($resultado);
                        $querySol = ("SELECT nomUsuario, apellidoUsuario FROM `users` WHERE idUser = $row[idUser]");
                        $resultadoSol  = mysqli_query($db, $querySol);
                        $rowN= mysqli_fetch_assoc($resultadoSol);
    
                        echo('              
                        <div class="col-md-6 col-lg-4" data-index="'.$row['idSolicitud'].'">
                            <div class="drop__card">
                                <div class="drop__data">
                                    <div>
                                        <h1 class="drop__name">'.$rowN["nomUsuario"]." ".$rowN["apellidoUsuario"].'</h1>
                                        <span class="drop__description">'.$row['descripcion'].'</span>
                                        <h1 class="drop__date">'.$row['fecha'].'</h1>
                                    </div>
                                </div>
                            </div>
                        </div>');
                    }

                    ?>
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
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>
