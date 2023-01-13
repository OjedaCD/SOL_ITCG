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
<div id="modificar">
    <main class="ModificarSolicitudFormato">
        <section class="w80">
            <h1>Modificar Solicitud</h1>
            <script>
            function validar(esto){
            valido=false;
                for(a=0;a<esto.elements.length;a++){
                    if(esto[a].type=="checkbox" && esto[a].checked==true){
                    valido=true;
                    break
                    }
                }
                if(!valido){
                    alert("Chequee una casilla!");return false
                }
            } 
            </script> 
                <?php 
                    if ($_SERVER['REQUEST_METHOD']==="GET") {
                        //Obtengo los datos del form
                        foreach($_GET as $fl => $value){
                        }
                
                        $folio = $fl;
                        $query = "SELECT folio FROM solicitudes";
                        $resultado = mysqli_query($db, $query);
                        
                        $ngg = substr($folio, 0, 2);
                        if ($ngg == "CC"){
                            echo('<form method="POST" onsubmit="return validar(this)" action ="SolicitudesCC.php">
                            <input type="hidden" name ="modificar" value = "modificar">');
                        }else {
                            echo('<form method="POST" onsubmit="return validar(this)" action ="SolicitudesME.php">
                            <input type="hidden" name ="modificar" value = "modificar">');
                        }
                        $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
                        $resultadoIdUs = mysqli_query($db, $queryIdUs);
                        
                        foreach ($resultadoIdUs as $value) {
                            foreach ($value as $idU) {       
                            }
                        }

                        if ($_SESSION['idUser'] == $idU){
                        
                            $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $idU ";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $row = mysqli_fetch_assoc($resultadoDatos);
                            
                            $queryDpto ="SELECT s.idDpto, s.idSolicitud FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
                            $resultadoDpto = mysqli_query($db, $queryDpto);//Departamento para imprimir los formularios
                            $row3 = mysqli_fetch_assoc($resultadoDpto);
                            
                            $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
                            $resultadoDpto = mysqli_query($db, $queryDpto);
                            $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
                            
                            
                            echo ('<div class="folio">
                                        <label for="folio">Folio</label>
                                        <input type="text" name="'.$folio.'" id="folio" value="'.$folio.'" disabled>           
                            </div>');  
                            echo ('<input type="hidden" name="tipoForm2" value="'.$folio.'" >');    //Envia el folio 
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
                            date_default_timezone_set("America/Mexico_City");
                            $fecha = date('Y-m-d');

                            echo('
                            <div class="fecha">
                                <label for="fecha">Fecha de elaboración</label>
                                <input id="fechaActual" name="fecha" value ="'.$fecha.'"value type="date" disabled>
                            </div>');

                            echo('
                                <div class="opciones">
                                    <label for="opciones">Clasificación de la falla a reparar:</label>
                                </div>');
                            $queryDetalles = "SELECT d.idFalla FROM detalles as d WHERE d.idSolicitud = $row3[idSolicitud] ";
                            $resultadoDetalles =  mysqli_query($db, $queryDetalles);
                            $detalles = array();

                            foreach ($resultadoDetalles as $key => $value) {
                                array_push($detalles,$value["idFalla"]);
                            }
                            $Marcado = ' checked="checked"';                                
                            if($row3['idDpto'] == 20){//Formulario del centro de computo
                                echo('<div class="fallas">');
                                    while($falla = mysqli_fetch_assoc($resultadoFallaCP)){
                                        echo('<input type = "checkbox" name ="checkbox[]"');
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
                                        echo('value="'.$falla['idFalla'].'"><label>'.$falla['nomFalla'].'</label><br>');}
                            echo('</div>'); 
                            
                            }elseif($row3['idDpto'] == 21){//Formulario de servicios de mantenimiento
                                echo('<div class="fallas2" >');
                                    while($falla = mysqli_fetch_assoc($resultadoFallaCP2)){
                                        echo('<input type = "checkbox"  name ="checkbox[]"');
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
                                        echo('value="'.$falla['idFalla'].'"><label>'.$falla['nomFalla'].'</label><br>');}
                            echo('</div>'); 
                            }
                            
                            $queryDes = "SELECT descripcion FROM solicitudes WHERE folio = '{$folio}' ";
                            $resultadoDes = mysqli_query($db, $queryDes);
                            $aux1 = mysqli_fetch_assoc($resultadoDes);
                            foreach ($aux1 as $key => $value) {
                                echo('<div class="descripcion">
                                    <label for="descripcion">Descripción del servicio solicitado o falla a reparar del Solicitante:</label>
                                    <textarea id ="descripcion" maxlength="255" name ="descripcion" placeholder="Ingresa la descripción lo más detallada posible, en caso de no hacerlo tu solicitud será rechazada. Debe de contener la descripción del servicio solicitado o reparación de fallas identificadas en los equipos, y su ubicación precisa dentro del ITCG." required>')."".trim($value);
                            echo('</textarea>
                            </div>');
                            }
                            
                            $queryOb= "SELECT observacion FROM solicitudes WHERE folio = '{$folio}' ";
                            $resultadoOb = mysqli_query($db, $queryOb);
                            $aux2 = mysqli_fetch_assoc($resultadoOb);
                            foreach ($aux2 as $key => $value) {
                                echo('<div class="observacion">
                                <label for="observacion">Correcciones para que su solicitud sea valida:</label>
                                <textarea id ="observacion" maxlength="255" name ="observacion" placeholder="Aquí aparecerán las correcciones pertinentes para que su solicitud sea válida, en caso de ser RECHAZADA." disabled> ')."".trim($value);  
                            echo('</textarea>
                            </div>');
                            }
                            echo('
                            <div class="btnMS">
                                <input type="submit" value="Modificar Solicitud">
                            </div>
                            <div class="btnCS">
                                <input type="button"  onclick="mostrarContenido4();" value="Cancelar Solicitud">
                            </div>
                            ');
                        }
                    }
                ?>
            </form>
        </section>
    </main>
</div>
<div id = "cancelar">
    <main class="CancelarSolicitudFormato">
        <section class="w80">
            <h1>Cancelar Solicitud</h1>
                <input type="hidden" name ="cancelar" value="cancelar">
                <?php 
                    if ($_SERVER['REQUEST_METHOD']==="GET") {
                        //Obtengo los datos del form
                        foreach($_GET as $fl => $value){
                        }
                        $folio = $fl;
                        $query = "SELECT folio FROM solicitudes";
                        $resultado = mysqli_query($db, $query);
                        $ngg = substr($folio, 0, 2);
                        if ($ngg == "CC"){
                            echo('<form method="POST" action ="SolicitudesCC.php">
                            <input type="hidden" name ="cancelar" value="cancelar">');
                        }else {
                            echo('<form method="POST" action ="SolicitudesME.php">
                            <input type="hidden" name ="cancelar" value="cancelar">');
                        }
                        
                        $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
                        $resultadoIdUs = mysqli_query($db, $queryIdUs);
                        
                        foreach ($resultadoIdUs as $value) {
                            foreach ($value as $idU) {       
                            }
                        }

                        if ($_SESSION['idUser'] == $idU){
                            $ban2 = true;
                            $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $idU ";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $row = mysqli_fetch_assoc($resultadoDatos);
                            
                            $queryDpto ="SELECT s.idDpto, s.idSolicitud, s.fecha FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
                            $resultadoDpto = mysqli_query($db, $queryDpto);//Departamento para imprimir los formularios
                            $row3 = mysqli_fetch_assoc($resultadoDpto);
                            
                            $queryDpto = "SELECT * FROM departamentos WHERE idDpto = $row[idDpto]";
                            $resultadoDpto = mysqli_query($db, $queryDpto);
                            $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
                            
                            
                            echo ('<div class="folio">
                                        <label for="folio">Folio</label>
                                        <input type="text" name="'.$folio.'" id="folio" value="'.$folio.'" disabled>           
                            </div>');  
                            echo ('<input type="hidden" name="tipoForm2" value="'.$folio.'" >');    //Envia el folio 
                            echo ('
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value = "'.$row["email"].'" pattern="[A-Za-z 0-9]+" disabled>           
                            </div>');
                            echo('
                            <div class="nombreUser">
                                <label for="nombre">Nombre del Solicitante</label>
                                <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"]." ".$row["apellidoUsuario"].'" maxlength="50" pattern="[A-Za-z]+" disabled >           
                                <input type="hidden" name="nombre" value="'.$row["nomUsuario"]." ".$row["apellidoUsuario"].'" >
                            </div>');

                            echo('
                            <div class="departamento">
                                <label for="departamento">Dpto del solicitante</label>
                                <input type="text" name="departamento" id="departamento" value = "'.$row2["nomDpto"].'" disabled>           
                                <input type="hidden" name="dpto" value="'.$row2["nomDpto"].'" >
                                <input type="hidden" name="idDpto" value="'.$row2["idDpto"].'" >
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
                            echo('
                                <div class="opciones">
                                    <label for="opciones">Clasificación de la falla a reparar:</label>
                                </div>');
                            
                            $queryDetalles = "SELECT d.idFalla FROM detalles as d WHERE d.idSolicitud = $row3[idSolicitud] ";
                            $resultadoDetalles =  mysqli_query($db, $queryDetalles);
                            $detalles = array();
                            
                            foreach ($resultadoDetalles as $key => $value) {
                                array_push($detalles,$value["idFalla"]);
                            }
                            
                            $Marcado = ' checked="checked"';
                            $queryFallaCP ="SELECT * FROM fallas WHERE idFalla <=7";
                            $resultadoFallaCP= mysqli_query($db, $queryFallaCP);
                        
                            $queryFallaCP2 ="SELECT * FROM fallas WHERE idFalla >7";
                            $resultadoFallaCP2= mysqli_query($db, $queryFallaCP2);
                            if($row3['idDpto'] == 20){//Formulario del centro de computo
                                
                                echo('<div class="fallas">');
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
                                <input type="hidden" name="descripcion" value="'."".trim($value).'" >
                            </div>');
                            }
                            echo('
                            <div class="observacion">
                                <label for="observacion">Razones de la concelación:</label>
                                <textarea id ="observacion" maxlength="255" name ="observacion" placeholder="Ingresa las razones de la cancelación de tu solicitud" required></textarea>
                            </div>'); 

                            echo('
                            <div class="btnCS">
                                <input type="submit" value="Cancelar Solicitud">
                            </div>
                            <div class="btnMS">
                                <input type="button"  onclick="mostrarContenido5();" value="Modificar Solicitud">
                            </div>
                            ');
                        }
                    }
                ?>
            </form>
        </section>
    </main>
</div>
<?php 
    inlcuirTemplate('footer');
?>