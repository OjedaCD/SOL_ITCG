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
<main class="SolicitudesEnProcesoFormato">
    <section class="w80">
        <h1>Solicitud En Proceso</h1>

        <form method="POST" action ="SolicitudesEnProceso.php">
            <?php 
                if ($_SERVER['REQUEST_METHOD']==="GET") {
                    //Obtengo los datos del form
                    foreach($_GET as $f1 => $value){
                    }
        
                    $folio = $f1;
                    $query = "SELECT folio FROM solicitudes";
                    $resultado = mysqli_query($db, $query);
                    
                    $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
                    $resultadoIdUs = mysqli_query($db, $queryIdUs);
                    
                    foreach ($resultadoIdUs as $value) {
                        foreach ($value as $key) {       
                        }
                    }
                    $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $key ";
                    $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                    $row = mysqli_fetch_assoc($resultadoDatos);
                            
                    $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
                    $resultadoDpto = mysqli_query($db, $queryDpto);
                    $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
                
                    $queryDpto ="SELECT * FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
                    $resultadoDpto = mysqli_query($db, $queryDpto);//Departamento para imprimir los formularios
                    $row3 = mysqli_fetch_assoc($resultadoDpto);
                    
                    $queryOb= "SELECT * FROM solicitudes WHERE folio = '{$folio}' ";
                    $resultadoOb = mysqli_query($db, $queryOb);
                    $aux2 = mysqli_fetch_assoc($resultadoOb);
                    
                    echo ('<div class="folio">
                                <label for="folio">Folio</label>
                                <input type="text" name="'.$folio.'" id="folio" value="'.$folio.'" disabled>           
                    </div>'); 
                    echo ('
                    <input type="hidden" name="tipoForm2" value="'.$folio.'">
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
                    if($aux2['validacion'] != 0){
                        date_default_timezone_set("America/Mexico_City");
                        $fecha2 = date('Y-m-d');

                        echo('
                        <div class="fechaFin">
                            <label for="fechaFin">Fecha de realización</label>
                            <input id="fechaFin" name="fechaFin" value ="'.$fecha2.'"value type="date" disabled>
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
                        echo('<div class="fallas ">');
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
                    echo('<div class="descripcion">');
                    if($_SESSION['idDpto'] == 20){
                        echo ('<label for="descripcion">Descripción de la falla:</label>');
                    }else{
                        echo ('<label for="descripcion">Descripción del servicio solicitado o falla a reparar:</label>');
                    }
                    echo('<textarea id ="descripcion" name ="descripcion" placeholder="'.$row3['descripcion'].'" disabled></textarea>
                    <input type="hidden" name="descripcion" value="'.$row3['descripcion'].'" >
                        </div>'); 

                    
                    if($_SESSION['idRole'] != 4){
                        echo('<div class="observacion">
                        <label for="observacion">Coloque los comentarios, observaciones, o las razones de cancelación de la solicitud:</label>
                        <textarea id ="observacion" maxlength="1000" name ="observacion" placeholder="Aquí aparecerán las correcciones pertinentes para que su solicitud sea válida, en caso de ser RECHAZADA."> ')."".trim($aux2['observacion']);  
                        echo('</textarea></div>');
                        
                        
                        
                        echo('
                        <div class= "opcionesSel">
                            <div class="prioridad">
                            <label for="prioridad">Nivel de Prioridad</label>
                            <select name="prioridad" id="prioridad" required >');
                            if(!empty($aux2['Prioridad'])){
                                if($aux2['Prioridad'] == "3BAJA"){
                                    echo('                                
                                    <option selected="selected" value="'.$aux2['Prioridad'].'">BAJA</option>
                                    <option value="2MEDIA">MEDIA</option>
                                    <option value="1ALTA">ALTA</option>
                                    </select></div>');
                                }elseif($aux2['Prioridad'] == "2MEDIA"){
                                    echo('                                
                                    <option value="3BAJA">BAJA</option>
                                    <option dedault selected="selected" value="'.$aux2['Prioridad'].'">MEDIA</option>
                                    <option value="1ALTA">ALTA</option>
                                    </select></div>');
                                }elseif($aux2['Prioridad'] == "1ALTA"){
                                    echo('                                
                                    <option value="3BAJA">BAJA</option>
                                    <option value="2MEDIA">MEDIA</option>
                                    <option selected="selected" value="'.$aux2['Prioridad'].'">ALTA</option>
                                    </select></div>');
                                }
                            }else{
                                echo('                                
                                    <option value="3BAJA">BAJA</option>
                                    <option value="2MEDIA">MEDIA</option>
                                    <option value="1ALTA">ALTA</option>
                                    </select></div>');
                            }
                            echo('
                            <div class="tipo">
                            <label for="tipo">Tipo de mantenimiento</label>
                            <select name="tipo" id="tipo" required >');
                            if(!empty($aux2['tipo'])){
                                if($aux2['tipo'] == "INTERNO"){
                                    echo('                                
                                    <option selected="selected" value="'.$aux2['tipo'].'">INTERNO</option>
                                    <option value="EXTERNO">EXTERNO</option>
                                    </select>');
                                }elseif($aux2['tipo'] == "EXTERNO"){
                                    echo('                                
                                    <option value="INTERNO">INTERNO</option>
                                    <option selected="selected" value="'.$aux2['tipo'].'">EXTERNO</option>
                                    </select>');
                                }
                            }else{
                                echo('                                
                                    <option value="INTERNO">INTERNO</option>
                                    <option value="EXTERNO">EXTERNO</option>
                                    </select>');
                            }
                            if($_SESSION['idDpto']== 20){
                                echo('
                                <select name="mantenimiento" id="mantenimiento" required >');
                                if(!empty($aux2['mantenimiento'])){
                                    if($aux2['mantenimiento'] == "CORRECTIVO"){
                                        echo('                                
                                        <option selected="selected" value="'.$aux2['mantenimiento'].'">CORRECTIVO</option>
                                        <option value="PREVENTIVO">PREVENTIVO</option>
                                        </select></div>');
                                    }elseif($aux2['mantenimiento'] == "PREVENTIVO"){
                                        echo('  
                                        <option value="CORRECTIVO">CORRECTIVO</option>                              
                                        <option selected="selected" value="'.$aux2['mantenimiento'].'">PREVENTIVO</option>
                                        </select></div>');
                                    }
                                }else{
                                    echo('  
                                        <option value="CORRECTIVO">CORRECTIVO</option>                              
                                        <option value="PREVENTIVO">PREVENTIVO</option>
                                        </select></div>');
                                }
                                echo('
                                <div class="lugar">
                                <label for="lugar">Lugar de mantenimiento</label>
                                <select name="lugar" id="lugar" required >');
                                if(!empty($aux2['lugar'])){
                                    if($aux2['lugar'] == "CÓMPUTO"){
                                        echo('                                
                                        <option selected="selected" value="'.$aux2['lugar'].'">CÓMPUTO</option>
                                        <option value="LABORATORIO">LABORATORIO</option>
                                        </select></div>');
                                    }elseif($aux2['lugar'] == "LABORATORIO"){
                                        echo('                                
                                        <option value="CÓMPUTO">CÓMPUTO</option>
                                        <option dedault selected="selected" value="'.$aux2['lugar'].'">LABORATORIO</option>
                                        </select></div>');
                                    }
                                }else{
                                    echo('                              
                                        <option value="CÓMPUTO">CÓMPUTO</option>
                                        <option value="LABORATORIO">LABORATORIO</option>
                                        </select></div>');
                                }
                            }else{
                                echo('</div>');
                            }
                            if($_SESSION['idDpto'] == 20){
                                echo('
                                <div class="asignado">
                                    <label for="asignado">Asignado a</label>
                                    <select name="asignado" id="asignado" required>
                                        <option value=""disabled selected>--Persona Asignada--</option>');
                                        $queryA ="SELECT * FROM users WHERE idRole = 5 AND idDpto = 20";
                                        $resultadoA= mysqli_query($db, $queryA);

                                        while($rowA = mysqli_fetch_assoc($resultadoA)){
                                            if($rowA['email'] == $row3['encargadoS']){
                                                echo('<option selected = "selected" value="'.$rowA['email'].'">');
                                                echo ($rowA["nomUsuario"]." ".$rowA["apellidoUsuario"]);
                                                echo ('</option>');
                                            }else{
                                                echo('<option value="'.$rowA['email'].'">');
                                                echo ($rowA["nomUsuario"]." ".$rowA["apellidoUsuario"]);
                                                echo ('</option>');
                                            }    
                                        }
                                    echo('
                                    </select> 
                                    <div class="btnAP">
                                        <input type="submit" name = "btn"  value="Cambiar Personal">
                                    </div>
                                </div>'); 
                                }
                                
                        echo('</div>');

                        echo('
                        <div class = "Botones">');
                        if($aux2['validacion'] != 1){
                        
                        echo('<div class="btnCSo">
                                <input type="submit" name = "btn" value="Cancelar Solicitud">
                            </div>');
                            echo('<div class="btnAC">
                                <input type="submit" name = "btn" value="Actualizar Comentario">
                            </div>
                            ');
                        }
                        
                            echo('
                            <div class="btnFSo">
                                ');
                                if($aux2['validacion'] == 0|| strlen("".trim($row3['trabajo'])) == 0  && strlen("".trim($row3['materiales'])) == 0 || empty($row3['encargadoS']) && $_SESSION['idDpto'] == 20){
                                    echo('<input type="submit" disabled="disabled" name = "btn"  value="Finalizar Solicitud">');
                                }else{
                                    echo('<input type="submit" name = "btn"  value="Finalizar Solicitud">');
                                }
                            echo('
                            </div>
                            <input type="hidden" name="tipoForm3" value="X" >
                        </div>                 
                        ');
                        if($aux2['validacion'] != 1 ){
                            $requerido = "";
                        }else{
                            $requerido = "required";
                        }
                        if($_SESSION['idDpto'] == 20){
                            $disabled = "disabled";
                        }else{
                            $disabled = "";
                        }

                        
                        if($_SESSION['idDpto'] == 21|| $_SESSION['idDpto'] == 20 && !empty($row3['encargadoS']) && !empty($row3['trabajo'])&& !empty($row3['materiales'])){

                            echo('<br><hr><h1>Orden De Trabajo</h1>');
                            $queryEn = "SELECT u.nomUsuario, u.apellidoUsuario FROM users as u INNER JOIN solicitudes as s ON u.email = s.encargadoS WHERE s.folio = '{$folio}' ";
                            $resultadoEn = mysqli_query($db, $queryEn);
                            $aux3 = mysqli_fetch_assoc($resultadoEn);
                            if($row3['idDpto'] == 20){
                                echo('<div class="encargadoS">
                                <label for="encargadoS">Asignado a:</label>
                                <textarea id ="encargadoS" name ="encargadoS" placeholder="Aquí aparecerán los nombres de las personas encargadas de atender las solicitud" '.$requerido." ".$disabled.'>')."".trim($aux3["nomUsuario"]." ".$aux3["apellidoUsuario"]);
                                echo('</textarea>
                                </div>');
                            }else{
                                echo('<div class="encargadoS">
                                <label for="encargadoS">Asignado a:</label>
                                <textarea id ="encargadoS" maxlength="1000" name ="encargadoS" '.$requerido." ".$disabled.'>')."".trim($aux2['encargadoS']);  
                                echo('</textarea></div>');
                            }

                            
    
                            echo('<div class="trabajo">
                            <label for="trabajo">Trabajo realizado:</label>
                            <textarea id ="trabajo" maxlength="1000" name ="trabajo" '.$requerido." ".$disabled.'>')."".trim($aux2['trabajo']);  
                            echo('</textarea></div>');
    
                            echo('<div class="materiales">');
                            echo('<label for="materiales">Materiales y Herramientas utilizados:</label>');
                            echo('
                            <textarea id ="materiales" maxlength="1000" name ="materiales" '.$requerido." ".$disabled.'>')."".trim($aux2['materiales']);  
                            echo('</textarea></div>');
                        } 
                    }else{
                        echo('
                        <div class="btnCS">
                            <input type="submit" name = "btn" value="Cerrar Solicitud">
                        </div>
                        ');
                    }
                     
                }
            ?>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
    
?>