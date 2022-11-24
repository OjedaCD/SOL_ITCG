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

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
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
                        
                        $ban2 = true;
                        $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $idU ";
                        $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                        $row = mysqli_fetch_assoc($resultadoDatos);
                        
                        $queryDpto ="SELECT s.idDpto, s.idSolicitud, s.fecha FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
                        $resultadoDpto = mysqli_query($db, $queryDpto);//Departamento para imprimir los formularios
                        $row3 = mysqli_fetch_assoc($resultadoDpto);
                        
                        $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
                        $resultadoDpto = mysqli_query($db, $queryDpto);
                        $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
                        
                        
                        echo ('<div class="folio">
                            <br>
                            <br>
                            <b><P style = "margin-left: 2rem">Número de folio: </b>  '.$folio.'</p></label>    
                        </div>');  
                        echo ('
                        <div class="email">
                            <b> <P style = "margin-left: 2rem">Correo Institucional:</b>   '.$row["email"].'</p></label>                                       
                        </div>');
                        echo('
                        <div class="nombreUser">
                            <b><P style = "margin-left: 2rem">Nombre del Solicitante:</b>  '.$row["nomUsuario"]." ".$row["apellidoUsuario"].'</p></label>  
                        </div>');

                        echo('
                        <div class="departamento">
                            <b><P style = "margin-left: 2rem">Departamento del Solicitante: </b>  '.$row2["nomDpto"].'</p></label>          
                        </div>');
                        $fecha1 = $row3['fecha'];
                        function cambiaf_a_espanol($fecha){
                            preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
                            $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
                            return $lafecha;
                        }
                        echo('
                        <div class="fecha">
                            <b><P style = "margin-left: 2rem">Fecha de elaboración:</b>   '.cambiaf_a_espanol($fecha1).'</p></label>   
                        </div>');
                        echo('
                            <div class="opciones">
                                <b><label for="opciones" style = "margin-left: 2rem">Clasificación de la falla a reparar:</label></b>
                                
                            </div>');
                        
                        $queryDetalles = "SELECT d.idFalla FROM detalles as d WHERE d.idSolicitud = $row3[idSolicitud] ";
                        $resultadoDetalles =  mysqli_query($db, $queryDetalles);
                        $detalles = array();

                        foreach ($resultadoDetalles as $key => $value) {
                            array_push($detalles,$value["idFalla"]);
                        }
                        $Marcado = ' checked="checked"';
                        if($row3['idDpto'] == 20){//Formulario del centro de computo
                            echo('<div class="fallas" ">');
                                while($falla = mysqli_fetch_assoc($resultadoFallaCP)){
                                    
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
                        
                        }elseif($row3['idDpto'] == 21){//Formulario de servicios de mantenimiento
                            echo('<div class="fallas2" >');
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
                        }
                        
                        $queryDes = "SELECT descripcion FROM solicitudes WHERE folio = '{$folio}' ";
                        $resultadoDes = mysqli_query($db, $queryDes);
                        $aux1 = mysqli_fetch_assoc($resultadoDes);
                        foreach ($aux1 as $key => $value) {
                            echo('<div class="descripcion">
                                <b><label for="descripcion" style = "margin-left: 2rem">Descripción del servicio solicitado o falla a reparar del Solicitante:</label></b>
                                <p style = "margin-left: 2rem">'."".trim($value).'</p>');
                        }
                        echo('
                        <br>
                        <
                        <b><p>Firma del Solicitante</p></b>  
                        '); 
                }
            ?>
</body>
</html>




<?php 
$html =ob_get_clean();
//echo $html;

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("solicitud_.pdf", array("Attachment" => false));

?>