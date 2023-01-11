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
<main class="SolicitudesPendientesFormato">
    <section class="w80">
        <h1>Solicitud Pendiente</h1>

        <form method="POST" action ="SolicitudesPendientes.php">
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
                    $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $idU ";
                    $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                    $row = mysqli_fetch_assoc($resultadoDatos);
                    
                    $queryDpto ="SELECT s.idDpto, s.idSolicitud, s.descripcion, s.fecha FROM solicitudes as s WHERE s.folio = '{$folio}'  ";
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
                    
                    echo('<div class="descripcion">
                            <label for="descripcion">Descripción del servicio solicitado o falla a reparar del Solicitante:</label>
                            <textarea id ="descripcion" name ="descripcion" placeholder="'.$row3['descripcion'].'" disabled></textarea>
                        </div>'); 

                    $queryOb= "SELECT observacion, Prioridad, tipo FROM solicitudes WHERE folio = '{$folio}' ";
                    $resultadoOb = mysqli_query($db, $queryOb);
                    $aux2 = mysqli_fetch_assoc($resultadoOb);
                    if($_SESSION['idRole'] != 4){
                        echo('<div class="observacion">
                        <label for="observacion">Coloque las observaciones o comentarios pertinentes a la solicitud:</label>
                        <textarea id ="observacion" maxlength="255" name ="observacion" placeholder="Aquí aparecerán las correcciones pertinentes para que su solicitud sea válida, en caso de ser RECHAZADA."> ')."".trim($aux2['observacion']);  
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
                                    </select></div>');
                                }elseif($aux2['tipo'] == "EXTERNO"){
                                    echo('                                
                                    <option value="INTERNO">INTERNO</option>
                                    <option selected="selected" value="'.$aux2['tipo'].'">EXTERNO</option>
                                    </select></div>');
                                }
                            }else{
                                echo('                                
                                    <option value="INTERNO">INTERNO</option>
                                    <option value="EXTERNO">EXTERNO</option>
                                    </select></div>');
                            }
                        echo('</div>');

                        echo('
                        <div class = "Botones">
                            <div class="btnRS">
                                <input type="submit" name = "btn"  value="Rechazar Solicitud">
                            </div>
                            <div class="btnAC">
                                <input type="submit" name = "btn" value="Actualizar Comentario">
                            </div>
                            <div class="btnAS">
                                <input type="submit" name = "btn" value="Aceptar Solicitud">
                            </div>
                        </div>
                        <input type="hidden" name="tipoForm3" value="X" >
                        ');
                        
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