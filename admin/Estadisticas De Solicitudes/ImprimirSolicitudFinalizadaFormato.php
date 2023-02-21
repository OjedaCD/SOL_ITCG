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
        
        $querySolicitud = "SELECT nomDpto FROM departamentos WHERE idDpto = $row3[idDpto]";
        $resultadoSolicitud = mysqli_query($db, $querySolicitud);
        $row4 = mysqli_fetch_assoc($resultadoSolicitud);//departamento al que pertenece el usuario
    

        
        echo ('<div class="folio">
        <img src= "../../src/img/itcg.png" style="width: 80px" >
        <img src= "../../src/img/tecnm.png" style="width: 160px" >
            <P><b>DEPARTAMENTO SOLICITADO: </b> '.$row4['nomDpto'].'</p>  
            
            <P><b>Número de folio: </b> '.$folio.'</p>   
        </div>');  
        echo ('
        <div class="email">
            <P><b> Correo Institucional: </b>'.$row["email"].'</p></label>                                    
        </div>');
        echo('
        <div class="nombreUser">
            <P><b>Nombre del Solicitante:</b>  '.$row["nomUsuario"]." ".$row["apellidoUsuario"].'</p></label>  
        </div>');

        echo('
        <div class="departamento">
            <P><b>Departamento del Solicitante: </b>  '.$row2["nomDpto"].'</p></label>          
        </div>');
        $fecha1 = $row3['fecha'];
        function cambiaf_a_espanol($fecha){
            preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
            $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
            return $lafecha;
        }
        echo('
        <div class="fecha">
            <P><b>Fecha de elaboración:</b>   '.cambiaf_a_espanol($fecha1).'</p></label>   
        </div>');
        echo('
            <div class="opciones">
                <P><b>Clasificación de la falla a reparar:</label></b>
                
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
                <P><b>Descripción del servicio solicitado o falla a reparar del Solicitante:</label></b>
                <P>'."".trim($value).'</p>');
        }
        $queryOb= "SELECT observacion FROM solicitudes WHERE folio = '{$folio}' ";
        $resultadoOb = mysqli_query($db, $queryOb);
        $aux1 = mysqli_fetch_assoc($resultadoOb);
        foreach ($aux1 as $key => $value) {
            if(strlen("".trim($value)) != 0){
                echo('                
                <P><b>Correcciones para que su solicitud sea valida o comentarios:</label></b>
                <P>'."".trim($value).'</p>');
            }
        }

        $queryEn = "SELECT encargadoS FROM solicitudes WHERE folio = '{$folio}' ";
        $resultadoEn = mysqli_query($db, $queryEn);
        $aux3 = mysqli_fetch_assoc($resultadoEn);
        foreach ($aux3 as $key => $value) {
            echo('
                <P><b>Nombres de las personas encargadas de atender la solicitud:</label></b>
                <P>'."".trim($value).'</p>');
        }
        echo('
        <br>
        <style>
        .fs{text-align: center;}
        </style>
        <P class = "fs"><b >Firma del Solicitante</p></b>  
        '); 
    }                
?>
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

$dompdf->stream("solicitud_.pdf", array("Attachment" => false));


//especificar una ruta repostes/solicitud el pex es la dirección de la memoria

?>