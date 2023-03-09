<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    $db =conectarDB();


    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";
    $resultadoDep= mysqli_query($db, $queryDep);
    
    $queryFallaCP2 ="SELECT * FROM fallas WHERE idFalla > 7";
    $resultadoFallaCP2= mysqli_query($db, $queryFallaCP2);

    $ban = null;
    ob_start();
?>
<?php 
    if ($_SERVER['REQUEST_METHOD']==="GET") {
        //Obtengo los datos del form
        foreach($_GET as $fl => $value){
        }

        $folio = $fl;
        $query = "SELECT folio FROM solicitudes";
        $resultado = mysqli_query($db, $query);

        $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
        $resultadoIdUs = mysqli_query($db, $queryIdUs);
        
        foreach ($resultadoIdUs as $value) {
            foreach ($value as $idU) {       
            }
        }

        $queryDatos= "SELECT * FROM users as u WHERE u.idUser = $idU ";
        $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
        $row = mysqli_fetch_assoc($resultadoDatos);
        
        $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
        $resultadoDpto = mysqli_query($db, $queryDpto);
        $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
        
        $queryDpto ="SELECT *FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
        $resultadoDpto = mysqli_query($db, $queryDpto);//Departamento para imprimir los formularios
        $row3 = mysqli_fetch_assoc($resultadoDpto);
        $fecha1 = $row3['fecha'];
        $fecha2 = $row3['fechaFin'];
        function cambiaf_a_espanol($fecha){
            preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
            $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
            return $lafecha;
        }
        
    }                
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    table{
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 15px;
    }
    td, th{
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    .uno{
        text-align: center;
    }
    .uno1{
        width: 70px;
    }
    .uno3{
        text-align: center;
    }

    .dos1{
        text-align: center;
        width: 70px;
    }
    .tres1{
        width:  353px;
    }
    .cuatro2{
        vertical-align: top;
        width:  200px;
    }
    .cinco1{
        width:  400px;
    }

    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td colspan="3" class= "uno">
                    <b>T E C N O L Ó G I C O&nbsp;&nbsp; N A C I O N A L&nbsp;&nbsp; D E &nbsp;&nbsp;M É X I C O</b>
                    <br>
                    I N S T I T U T O &nbsp;&nbsp; T E C N O L Ó G I C O &nbsp;&nbsp; D E&nbsp;&nbsp;  C D. G U Z M Á N
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="uno1">
                    <?php $nombreImagen1 = "../../src/img/itcg.png";
                    $imagenBase641 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen1));
                    echo ('<img src="'.$imagenBase641.'"  alt="" style="width: 60px;
                    margin-left: 4px;
                    ">');?>
                </td>
                <td class="uno3"><b>Nombre del documento:</b> Orden de Trabajo de
                    <br>
                    Mantenimiento
                    <br>
                    <b>Referencia de la norma:</b> ISO 9001:2015 7.1.3,7.1.4
                </td>
                    <table>
                        <tbody>
                            <tr>
                                <td><b>Código: ITCG-AD-PO-001-04</b></td>
                            </tr>
                            <tr>
                                <td><b>Revisión:</b> 8</td>
                            </tr>
                            <tr>
                                <td><b>Pág</b> 1 de 1</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td class= "dos1">
                    <b>Folio: </b> <?php echo $folio?>
                </td>
                <td class= "dos2">
                    <b>Área Solicitante:</b> <?php echo $row2['nomDpto']?>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td class= "dos3">
                    <b>Fecha de elaboración: </b> <?php echo cambiaf_a_espanol($fecha1)?>
                </td>
                <td class= "dos4">
                    <b>Fecha de realización:</b> <?php echo cambiaf_a_espanol($fecha2)?>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td class= "tres1">
                    <b>Mantenimiento: </b> <?php echo $row3['mantenimiento']?>
                    <?php echo $row3['tipo']?>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td>
                    <b>Nombre del Solicitante: </b> <?php echo $row["nomUsuario"]." ".$row["apellidoUsuario"]?>
                </td>
            </tr>
            <tr>
                <td >
                    <b>Correo del Solicitante:</b> <?php echo $row["email"]?>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td>
                    <b>Clasificación de la falla a reparar: </b> 
                    <?php 
                    $queryDetalles = "SELECT d.idFalla FROM detalles as d WHERE d.idSolicitud = $row3[idSolicitud] ";
                    $resultadoDetalles =  mysqli_query($db, $queryDetalles);
                    $detalles = array();

                    foreach ($resultadoDetalles as $key => $value) {
                        array_push($detalles,$value["idFalla"]);
                    }
                    $Marcado = ' checked="checked"';
                    echo('<div class="fallas" ">');
                    while($falla = mysqli_fetch_assoc($resultadoFallaCP2)){
                        echo('<input type = "checkbox" style = "margin-left: 2rem" disabled name ="checkbox[]"');
                        if($detalles){
                            foreach ($detalles as $key => $checkboxSel) {
                                $valorX  = array_shift($detalles);
                                if ($valorX == $falla['idFalla']){
                                    echo($Marcado);
                                }else{
                                    array_push($detalles, $valorX);
                                }
                            }
                        }
                        echo('value="'.$falla['idFalla'].'"><label>'.$falla['nomFalla'].'</label><br>');
                    }
                    echo('</div>'); 
                    ?>
                </td>
                <td class="cuatro2">
                    <b>Descripción de la falla:</b> <?php echo $row3["descripcion"]?>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td>
                    <b>Asignado a: </b> <?php echo $row3["encargadoS"]?>
                </td>
            </tr>
            <tr>
                <td >
                    <b>Observaciones:</b> <?php echo $row3["observacion"]?>
                </td>
            </tr>
            <tr>
                <td >
                    <b>Materiales utilizados:</b> <?php echo $row3["materiales"]?>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td class="cinco1">
                    <b>Recibe de conformidad (nombre y firma)</b>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td class="cinco1">
                    <b>Cierra orden de trabajo realizado: (nombre y firma)</b>
                </td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>
    
</body>
</html>









<?php
$html =ob_get_clean();
// echo $html;

require_once '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');
$dompdf->render();

$dompdf->stream("solicitud.pdf", array("Attachment" => false));


//especificar una ruta repostes/solicitud el pex es la dirección de la memoria

?>