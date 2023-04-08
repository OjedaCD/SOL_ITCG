<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');

    $db = conectarDB();


    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";
    $resultadoDep= mysqli_query($db, $queryDep);
    
    $queryFallaCP ="SELECT * FROM fallas WHERE idFalla <=7";
    $resultadoFallaCP= mysqli_query($db, $queryFallaCP);

    $queryFallaCP2 ="SELECT * FROM fallas WHERE idFalla >7";
    $resultadoFallaCP2= mysqli_query($db, $queryFallaCP2);

    
?>
<main class="SolicitudFormato">
    <section class="w80">
        <h1>Solicitud</h1>
            <?php 
                if ($_SERVER['REQUEST_METHOD']==="GET") {
                    //Obtengo los datos del form
                    $folio = $_GET ['folio'];
                    $query = "SELECT folio FROM solicitudes";
                    $resultado = mysqli_query($db, $query);
                    $ngg = substr($folio, 6, 2);
                    echo('<form method="POST" action ="SolicitudesMenu.php">');

                    $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
                    $resultadoIdUs = mysqli_query($db, $queryIdUs);
                    
                    foreach ($resultadoIdUs as $value) {
                        foreach ($value as $idU) {       
                        }
                    }

                    $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $idU ";
                    $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                    $row = mysqli_fetch_assoc($resultadoDatos);
                    
                    $queryDpto ="SELECT * FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
                    $resultadoDpto = mysqli_query($db, $queryDpto);//Departamento para imprimir los formularios
                    $row3 = mysqli_fetch_assoc($resultadoDpto);
                    
                    $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
                    $resultadoDpto = mysqli_query($db, $queryDpto);
                    $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
                    
                    $queryOb= "SELECT * FROM solicitudes WHERE folio = '{$folio}' ";
                    $resultadoOb = mysqli_query($db, $queryOb);
                    $aux2 = mysqli_fetch_assoc($resultadoOb);
                    
                    echo ('<div class="folio">
                                <label for="folio">Folio</label>
                                <input type="text" name="'.$folio.'" id="folio" value="'.$folio.'" disabled>           
                    </div>');
                    echo ('<input type="hidden" name="tipoForm2" value="'.$folio.'" >');   
                    echo ('
                    <div class="email">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value = "'.$row["email"].'" pattern="[A-Za-z 0-9]+" disabled>           
                    </div>');
                    echo('
                    <div class="nombreUser">
                        <label for="nombre">Nombre del Solicitante</label>
                        <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"]." ".$row["apellidoUsuario"].'" maxlength="50" pattern="[A-Za-z]+" disabled >           
                    </div>');

                    echo('
                    <div class="departamento">
                        <label for="departamento">Dpto del solicitante</label>
                            <input type="text" name="departamento" id="departamento" value = "'.$row2["nomDpto"].'" disabled>           
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
                        <label for="fecha">Fecha de elaboración</label>
                        <input id="fechaActual" name="fecha" type="text" value ="'.cambiaf_a_espanol($fecha1).'" disabled>
                    </div>');
                    if($aux2['Etapa'] == "3FINALIZADO"){
                        echo('
                        <div class="fechaFin">
                            <label for="fechaFin">Fecha de realización</label>
                            <input id="fechaFin" name="fechaFin" type="text" value ="'.cambiaf_a_espanol($fecha2).'" disabled>
                        </div>');
                    }
                    echo('
                        <div class="opciones">
                            <label for="opciones">Clasificación de la falla a reparar:</label>
                        </div>');
                    
                    $queryDetalles = "SELECT idFalla FROM detalles WHERE folio = '$row3[folio]' ";
                    $resultadoDetalles =  mysqli_query($db, $queryDetalles);
                    $detalles = array();

                    foreach ($resultadoDetalles as $key => $value) {
                        array_push($detalles,$value["idFalla"]);
                    }
                    $Marcado = ' checked="checked"';
                    if($row3['idDpto'] == 20){//Formulario del centro de computo
                        echo('<div class="fallas" ">');
                            while($falla = mysqli_fetch_assoc($resultadoFallaCP)){
                                
                                echo('<input type = "checkbox" disabled name ="checkbox[]"');
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
                                echo('<input type = "checkbox" disabled name ="checkbox[]"');
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
                            <label for="descripcion">Descripción del servicio solicitado o falla a reparar del Solicitante:</label>
                            <textarea id ="descripcion" name ="descripcion" placeholder="Ingresa la descripción lo más detallada posible, en caso de no hacerlo tu solicitud será rechazada. Debe de contener la descripción del servicio solicitado o reparación de fallas identificadas en los equipos, y su ubicación precisa dentro del ITCG." disabled>')."".trim($value);
                    echo('</textarea>
                    </div>');
                    }
                    
                    if($aux2['Etapa'] != "3FINALIZADO"){
                        echo('<hr><h1>Orden De Trabajo</h1>');
                        echo('<div class="trabajo">
                        <label for="trabajo">Trabajo realizado:</label>
                        <textarea id ="trabajo" maxlength="1000" name ="trabajo" required>')."".trim($aux2['trabajo']);  
                        echo('</textarea></div>');

                        echo('<div class="materiales">');
                        if($_SESSION['idDpto'] == 20){
                            echo('<label for="materiales">Materiales utilizados:</label>');
                        }elseif($_SESSION['idDpto'] == 21){
                            echo('<label for="materiales">Materiales y Herramientas utilizados:</label>');
                        }
                        echo('
                        <textarea id ="materiales" maxlength="1000" name ="materiales" required>')."".trim($aux2['materiales']);  
                        echo('</textarea></div>');

                        echo('
                        <div class="btnCS">
                            <input name = "btn" type="submit" value="Atender Orden">
                        </div>');
                    }else{
                        if($aux2['Estado'] != "CANCELADO"){
                            echo('<div class="trabajo">
                            <label for="trabajo">Trabajo realizado:</label>
                            <textarea disabled id ="trabajo" maxlength="1000" name ="trabajo" required>')."".trim($aux2['trabajo']);  
                            echo('</textarea></div>');

                            echo('<div class="materiales">');
                            if($_SESSION['idDpto'] == 20){
                                echo('<label for="materiales">Materiales utilizados:</label>');
                            }elseif($_SESSION['idDpto'] == 21){
                                echo('<label for="materiales">Materiales y Herramientas utilizados:</label>');
                            }
                            echo('
                            <textarea disabled id ="materiales" maxlength="1000" name ="materiales" required>')."".trim($aux2['materiales']);  
                            echo('</textarea></div>');

                        }else{
                            $queryOb= "SELECT observacion FROM solicitudes WHERE folio = '{$folio}' ";
                            $resultadoOb = mysqli_query($db, $queryOb);
                            $aux1 = mysqli_fetch_assoc($resultadoOb);
                            foreach ($aux1 as $key => $value) {
                                if(strlen("".trim($value)) != 0){
                                    echo('<div class="observacion">');
                                    echo('<label for="observacion">Razones de cancelación:</label>');                            
                                    echo('<textarea id ="observacion" maxlength="1000" name ="observacion" placeholder="Aquí aparecerán las correcciones pertinentes para que su solicitud sea válida, en caso de ser RECHAZADA." disabled> ')."".trim($value);  
                                    echo('</textarea>
                                    </div>');
                                }
                            }
                        }
                        
                        echo('
                        <div class="btnCS">
                            <input name = "btn" type="submit" value="Cerrar Solicitud">
                            <input type="hidden" name="cn" value="cn" >
                        </div>');
                        
                    }
                      
                }
            
            ?>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>