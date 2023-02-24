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
        
        $queryDpto ="SELECT *FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
        $resultadoDpto = mysqli_query($db, $queryDpto);//Departamento para imprimir los formularios
        $row3 = mysqli_fetch_assoc($resultadoDpto);
        
        $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
        $resultadoDpto = mysqli_query($db, $queryDpto);
        $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
        
        $querySolicitud = "SELECT nomDpto FROM departamentos WHERE idDpto = $row3[idDpto]";
        $resultadoSolicitud = mysqli_query($db, $querySolicitud);
        $row4 = mysqli_fetch_assoc($resultadoSolicitud);//departamento al que pertenece el usuario

        echo ('<div style="display: flex;
        justify-content: center;
        position: relative;
        margin-bottom: 2rem;">');
        $nombreImagen1 = "../../src/img/sep.png";
        $imagenBase641 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen1));
        echo ('<img src="'.$imagenBase641.'"  alt="" style="height: 5rem;
        margin-right: 1rem; float: left;
        ">');

        echo ('<div class="v-line1" style =" border: 1px solid #c59762;
        background-color: #c59762;
        height:4rem;
        float: left;
        width: .05rem;
        margin-top: .5rem;
        margin-right: 1.5rem"></div>');

        $nombreImagen2 = "../../src/img/tecnm.png";
        $imagenBase642 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen2));
        echo ('<img src="'.$imagenBase642.'"  alt="" style="height: 5rem; float: left;"');

        echo ('<div class="v-line2" style =" border: 1px solid #c59762;
        background-color: #c59762;
        height:4rem;
        float: left;
        width: .05rem;
        margin-top: .5rem;
        margin-left: 1.5rem;
        margin-right: 1.5rem;"></div>');

        $nombreImagen3 = "../../src/img/itcg.png";
        $imagenBase643 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen3));
        echo ('<img src="'.$imagenBase643.'" alt="" style="height: 4rem; ">');
        echo('</div>');

        echo ('<div class="folio"  >
           <b>Departamento Solicitado:</b> '.$row4['nomDpto']. ' '.'<b> Número de folio:</b> '.$folio.'  
        </div>');  
        echo ('
        <div class="email">
            <b> Correo Institucional: </b>'.$row["email"].'</label>                                    
        </div>');
        echo('
        <div class="nombreUser">
            <b>Nombre del Solicitante:</b>  '.$row["nomUsuario"]." ".$row["apellidoUsuario"].'</label>  
        </div>');

        echo('
        <div class="departamento">
            <b>Departamento del Solicitante: </b>  '.$row2["nomDpto"].'</label>          
        </div>');
        $fecha1 = $row3['fecha'];
        $fecha2 = $row3['fechaFin'];
        function cambiaf_a_espanol($fecha){
            preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
            $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
            return $lafecha;
        }
        echo('
        <div class="fecha">
            <b>Fecha de elaboración: </b>'.cambiaf_a_espanol($fecha1). '<b> Fecha de realización: </b>'.cambiaf_a_espanol($fecha2).'</b></label>   
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
                '."".trim($value));
        }

        $queryOb= "SELECT observacion FROM solicitudes WHERE folio = '{$folio}' ";
            $resultadoOb = mysqli_query($db, $queryOb);
            $aux1 = mysqli_fetch_assoc($resultadoOb);
            foreach ($aux1 as $key => $value) {
                if(strlen("".trim($value)) != 0){
                    echo('<div class="observacion">');
                    if($row3['Estado'] != "CANCELADO"){
                        echo('<b>Correcciones para que su solicitud sea valida o comentarios: </b>');
                    }else{
                        echo('<b>Razones de cancelación: </b>');
                    }
                    echo("".trim($value));
                }
            }

            if($row3['Estado'] != "CANCELADO"){
                echo('<style>
                .ot{text-align: center;}
                </style>
                <hr><p class = "ot"><b>Orden De Trabajo</p></b>');
                $queryEn = "SELECT encargadoS FROM solicitudes WHERE folio = '{$folio}' ";
                $resultadoEn = mysqli_query($db, $queryEn);
                $aux3 = mysqli_fetch_assoc($resultadoEn);
                foreach ($aux3 as $key => $value) {
                    echo('
                        <P><b>Nombres de las personas encargadas de atender la solicitud:</label></b>
                        '."".trim($value));
                }
                
                $queryTr = "SELECT trabajo FROM solicitudes WHERE folio = '{$folio}' ";
                $resultadoTr = mysqli_query($db, $queryTr);
                $aux4 = mysqli_fetch_assoc($resultadoTr);
                foreach ($aux4 as $key => $value) {
                    echo('
                        <P><b>Trabajo realizado:</label></b>
                        '."".trim($value));
                }

                $queryMa = "SELECT materiales FROM solicitudes WHERE folio = '{$folio}' ";
                $resultadoMa = mysqli_query($db, $queryMa);
                $aux5 = mysqli_fetch_assoc($resultadoMa);
                foreach ($aux5 as $key => $value) {
                    echo('
                        <P><b>Materiales utilizados:</label></b>
                        '."".trim($value));
                }
            }

        echo('
        <br>
        <br>
        <br>
        <style>
        .fs{text-align: center;}
        </style>
        <P class = "fs"><b >Firma del Solicitante</p></b>
        
        '); 
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