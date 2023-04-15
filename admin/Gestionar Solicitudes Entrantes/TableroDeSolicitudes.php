<?php
require "../../includes/funciones.php";
$auth = estaAutenticado();
require "../../includes/config/database.php";
if (!$auth) {
    header('location: /');
    die();
}

inlcuirTemplate('header');
$db = conectarDB();

$queryCont = "SELECT COUNT(*) AS 'contador' FROM solicitudes WHERE idDpto = $_SESSION[idDpto]";
$resultadoCont = mysqli_query($db, $queryCont);
$cont = mysqli_fetch_assoc($resultadoCont);
$total = intval($cont['contador']);

$querySolP = ("SELECT * FROM `solicitudes` WHERE Etapa = '1PENDIENTE' AND idDpto = $_SESSION[idDpto] ORDER BY Prioridad ASC");
$resultadoSolP  = mysqli_query($db, $querySolP);
$pendiente = array();
foreach ($resultadoSolP as $key => $value) {
    array_push($pendiente, $value["folio"]);
}

$querySolPr = ("SELECT * FROM `solicitudes` WHERE Etapa = '2PROCESO' AND idDpto = $_SESSION[idDpto] ORDER BY Prioridad ASC");
$resultadoSolPr  = mysqli_query($db, $querySolPr);
$proceso = array();
foreach ($resultadoSolPr as $key => $value) {
    array_push($proceso, $value["folio"]);
}


$querySolF = ("SELECT * FROM `solicitudes` WHERE Etapa = '3FINALIZADO' AND idDpto = $_SESSION[idDpto] ORDER BY Estado DESC, Prioridad ASC");
$resultadoSolF  = mysqli_query($db, $querySolF);
$finalizado = array();
foreach ($resultadoSolF as $key => $value) {
    array_push($finalizado, $value["folio"]);
}


?>
<main class="TableroDeSolicitudes">
    <section class="w80">
        <?php
        if ($_SESSION['idDpto'] == 20) {
            echo ('<h1>Tablero De Solicitudes Centro De Cómputo</h1>');
        }
        if ($_SESSION['idDpto'] == 21) {
            echo ('<h1>Tablero De Solicitudes Mantenimiento De Equipo</h1>');
        }

        function cambiaf_a_espanol($fecha)
        {
            preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
            $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
            return $lafecha;
        }
        ?>
        <div class="contenedor">

            <div class="interna1">
                <h4>PENDIENTE</h4>
                <div class="container top">
                    <div class="row sortable" id="drop-items">
                        <?php
                        foreach ($pendiente as $key => $value) {
                            $query = "SELECT * FROM solicitudes where folio = '{$value}'";
                            $resultado = mysqli_query($db, $query);
                            $row = mysqli_fetch_assoc($resultado);
                            $querySol = ("SELECT nomUsuario, apellidoUsuario FROM `users` WHERE idUser = $row[idUser]");
                            $resultadoSol  = mysqli_query($db, $querySol);
                            $rowN = mysqli_fetch_assoc($resultadoSol);

                            $queryDatos= "SELECT * FROM users as u WHERE u.idUser = $row[idUser] ";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $rowUD = mysqli_fetch_assoc($resultadoDatos);
                            
                            $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $rowUD[idDpto]";
                            $resultadoDpto = mysqli_query($db, $queryDpto);
                            $rowD = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario

                            echo ('              
                                <div class="col-md-6 col-lg-4" data-index="' . $row['folio'] . '">
                                    <div class="');
                            if ($row['Prioridad'] == '1ALTA') {
                                $clase = 'drop__card1';
                            } elseif ($row['Prioridad'] == '2MEDIA') {
                                $clase = 'drop__card2';
                            } elseif ($row['Prioridad'] == '3BAJA') {
                                $clase = 'drop__card3';
                            }
                            echo $clase;
                            echo ('">
                                    <form method="GET" action="SolicitudesPendientesFormato.php">
                                        <div class="drop__data">
                                            <div>
                                            <h1 class="drop__name">' . '<b>Solicitante: </b>' . $rowN["nomUsuario"] . '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Folio: </b>'  . $row["folio"] .
                                            '<br>' . '<b>Dpto: </b>' . substr("$rowD[nomDpto]", 0, 26) . '</h1>
                                                <span class="drop__description">' . '<b>Descripción: </b><br>' . substr("$row[descripcion]", 0, 200) . '</span>
                                                <h1 class="drop__date">' . '<b>Fecha: </b>' . cambiaf_a_espanol($row['fecha']) . '</h1>
                                                <input name = "' . $row['folio'] . '" type="hidden">');
                            if ($row['Estado'] != "RECHAZADO") {

                                if ($_SESSION['idDpto'] == 21 || !empty($row['encargadoS']) && $_SESSION['idDpto'] == 20) {
                                    echo ('<th><input class = "aceptado"type="submit" value="En Espera"></th>');
                                } elseif (empty($row['encargadoS']) && $_SESSION['idDpto'] == 20) {
                                    echo ('<th><input class = "aceptado"type="submit" value="Asignar Personal"></th>');
                                }
                            } else {
                                echo ('<th><input class = "rechazado"type="submit" value="En Correción"></th>');
                            }
                            echo ('
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
                    <div class="row sortable" id="drop-items">
                        <?php
                        foreach ($proceso as $key => $value) {
                            $query = "SELECT * FROM solicitudes where folio = '{$value}'";
                            $resultado = mysqli_query($db, $query);
                            $row = mysqli_fetch_assoc($resultado);
                            $querySol = ("SELECT nomUsuario, apellidoUsuario FROM `users` WHERE idUser = $row[idUser]");
                            $resultadoSol  = mysqli_query($db, $querySol);
                            $rowN = mysqli_fetch_assoc($resultadoSol);

                            $queryDatos= "SELECT * FROM users as u WHERE u.idUser = $row[idUser] ";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $rowUD = mysqli_fetch_assoc($resultadoDatos);
                            
                            $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $rowUD[idDpto]";
                            $resultadoDpto = mysqli_query($db, $queryDpto);
                            $rowD = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario

                            echo ('              
                                <div class="col-md-6 col-lg-4" data-index="' . $row['folio'] . '">
                                    <div class="');
                            if ($row['Prioridad'] == '1ALTA') {
                                $clase = 'drop__card1';
                            } elseif ($row['Prioridad'] == '2MEDIA') {
                                $clase = 'drop__card2';
                            } elseif ($row['Prioridad'] == '3BAJA') {
                                $clase = 'drop__card3';
                            }
                            echo $clase;
                            echo ('">
                                    <form method="GET" action="SolicitudesEnProcesoFormato.php">
                                        <div class="drop__data">
                                            <div>
                                            <h1 class="drop__name">' . '<b>Solicitante: </b>' . $rowN["nomUsuario"] . '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Folio: </b>'  . $row["folio"] .
                                            '<br>' . '<b>Dpto: </b>' . substr("$rowD[nomDpto]", 0, 26) . '</h1>
                                            <span class="drop__description">' . '<b>Descripción: </b><br>' . substr("$row[descripcion]", 0, 200) . '</span>
                                            <h1 class="drop__date">' . '<b>Fecha: </b>' . cambiaf_a_espanol($row['fecha']) . '</h1>
                                            <input name = "' . $row['folio'] . '" type="hidden">');
                            if ($row['validacion'] == 1 && strlen("" . trim($row['trabajo'])) != 0  && strlen("" . trim($row['materiales'])) != 0) {
                                echo ('<th><input class = "si"type="submit" value="Finalizar Proceso"></th>');
                            } elseif (empty($row['encargadoS']) && $_SESSION['idDpto'] == 21 || empty($row['trabajo']) && $_SESSION['idDpto'] == 21 || empty($row['materiales']) && $_SESSION['idDpto'] == 21) {
                                echo ('<th><input class = "no"type="submit" value="Orden De Trabajo"></th>');
                            } elseif ($row['validacion'] != 1 && strlen("" . trim($row['trabajo'])) != 0  && strlen("" . trim($row['materiales'])) != 0) {
                                echo ('<th><input class = "si"type="submit" value="En proceso"></th>');
                            } else {
                                echo ('<th><input class = "no"type="submit" value="En Proceso"></th>');
                            }
                            echo ('
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
                    <div class="row sortable" id="drop-items">
                        <?php
                        foreach ($finalizado as $key => $value) {
                            $query = "SELECT * FROM solicitudes where folio = '{$value}'";
                            $resultado = mysqli_query($db, $query);
                            $row = mysqli_fetch_assoc($resultado);
                            $querySol = ("SELECT nomUsuario, apellidoUsuario FROM `users` WHERE idUser = $row[idUser]");
                            $resultadoSol  = mysqli_query($db, $querySol);
                            $rowN = mysqli_fetch_assoc($resultadoSol);

                            $queryDatos= "SELECT * FROM users as u WHERE u.idUser = $row[idUser] ";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $rowUD = mysqli_fetch_assoc($resultadoDatos);
                            
                            $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $rowUD[idDpto]";
                            $resultadoDpto = mysqli_query($db, $queryDpto);
                            $rowD = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario


                            echo ('              
                                <div class="col-md-6 col-lg-4" data-index="' . $row['folio'] . '">
                                    <div class="');
                            if ($row['Prioridad'] == '1ALTA') {
                                $clase = 'drop__card1';
                            } elseif ($row['Prioridad'] == '2MEDIA') {
                                $clase = 'drop__card2';
                            } elseif ($row['Prioridad'] == '3BAJA') {
                                $clase = 'drop__card3';
                            }
                            if ($row['Estado'] == 'CANCELADO') {
                                $clase = 'drop__card4';
                            }
                            echo $clase;
                            echo ('">
                                    <form method="GET" action="SolicitudesFinalizadasFormato.php">
                                        <div class="drop__data">
                                            <div>
                                            <h1 class="drop__name">' . '<b>Solicitante: </b>' . $rowN["nomUsuario"] . '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Folio: </b>'  . $row["folio"] .
                                            '<br>' . '<b>Dpto: </b>' . substr("$rowD[nomDpto]", 0, 26) . '</h1>
                                                            <span class="drop__description">' . '<b>Descripción: </b><br>' . substr("$row[descripcion]", 0, 200) . '</span>
                                                            <h1 class="drop__date">' . '<b>Fecha: </b>' . cambiaf_a_espanol($row['fecha']) . '</h1>
                                                            <input name = "' . $row['folio'] . '" type="hidden">');
                            if ($row['Estado'] == "FINALIZADO") {
                                echo ('<th><input class ="si" type="submit" value="Finalizada"></th>');
                            } else {
                                echo ('<th><input class ="no" type="submit" value="Cancelada"></th>');
                            }
                            echo ('
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
            $(document).ready(function() {
                $('.sortable').sortable({
                    update: function(event, ui) {
                        $(this).children().each(function(index) {
                            if ($(this).attr('data-position') != (index + 1)) {
                                $(this).attr('data-position', (index + 1)).addClass('updated');

                            }
                        });
                        guardandoPosiciones();
                    }
                });
            });

            function guardandoPosiciones() {
                var positions = [];
                $('.updated').each(function() {
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