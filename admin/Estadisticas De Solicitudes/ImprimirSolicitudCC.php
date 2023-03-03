<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    $db =conectarDB();


    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";
    $resultadoDep= mysqli_query($db, $queryDep);
    
    $queryFallaCP ="SELECT * FROM fallas WHERE idFalla <= 7";
    $resultadoFallaCP= mysqli_query($db, $queryFallaCP);

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
    }
    td, th{
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    .my-table{
        text-align: right;

    }
    #sing{
        padding-top: 100px;
        text-align: right;
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
                <td class="uno3"><b>Nombre del documento:</b> Solicitud de Mantenimiento
                    <br>
                    Correctivo de equipo de cómputo o laboratorios del
                    <br>
                    ITCG
                    <br>
                    <b>Referencia de la norma:</b> ISO 9001:2015 7.1.3,7.1.4
                </td>
                    <table>
                        <tbody>
                            <tr>
                                <td><b>Código: ITCG-AD-PO-009-01</b></td>
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
                    <b>Fecha de elaboración: </b> <?php echo $row3['fecha']?>
                </td>
                <td class= "dos4">
                    <b>Fecha de realización:</b> <?php echo $row3['fechaFin']?>
                </td>
            </tr>
            
        </tbody>
    </table>
</body>
</html>

<?php 
    if ($_SERVER['REQUEST_METHOD']==="GET") {
        //Obtengo los datos del form
        foreach($_GET as $fl => $value){
        }

        $folio = "CC2012023";
        $query = "SELECT folio FROM solicitudes";
        $resultado = mysqli_query($db, $query);
        
    }                
?>










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