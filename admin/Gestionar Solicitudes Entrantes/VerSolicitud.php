<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
    if ($_SESSION['idRole'] != '1') {
        header('location: /admin/index.php'); 
        die();
    }
    $db = conectarDB();


    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";
    $resultadoDep= mysqli_query($db, $queryDep);
    
    $queryFallaCP ="SELECT * FROM fallas WHERE idFalla <=7";
    $resultadoFallaCP= mysqli_query($db, $queryFallaCP);

    $queryFallaCP2 ="SELECT * FROM fallas WHERE idFalla >7";
    $resultadoFallaCP2= mysqli_query($db, $queryFallaCP2);
    if($_SERVER['REQUEST_METHOD']==="GET"){
        
        $folio = $_GET['tipoForm2']?? null;;
        $observacion = $_GET['observacion']?? null;;
        $btn= $_GET['btn']?? null;;

        echo($folio."<br>".$observacion."<br>".$btn);
    }

?>
<main class="VerSolicitud">
    <section class="w80">
        <h1>Ver Solicitud</h1>

        <form method="GET">
            <?php 
                if ($_SERVER['REQUEST_METHOD']==="POST") {
                    //Obtengo los datos del form
                    foreach($_POST as $key => $value){
                    }
            
                    $folio = $key;
                    $query = "SELECT folio FROM solicitudes";
                    $resultado = mysqli_query($db, $query);
                    
                    while($usuario = mysqli_fetch_assoc($resultado)){
                        if( $folio == $usuario['folio']){//valida si existe en la bd
                            $ban = true;
                            $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
                            $resultadoIdUs = mysqli_query($db, $queryIdUs);// guardo el id del usuario

                            foreach ($resultadoIdUs as $value) {//Envío el id en un input tipo hidden
                                foreach ($value as $key) {
                                    
                                }
                            }
                            if ($_SESSION['idUser'] == $key){
                                $ban2 = true;
                                $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $key ";
                                $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                                $row = mysqli_fetch_assoc($resultadoDatos);
                                
                                $queryDpto ="SELECT s.idDpto, s.idSolicitud, s.descripcion FROM solicitudes as s WHERE s.folio = $folio  ";
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

                                echo('
                                <div class="fecha">
                                    <label for="fecha">Fecha de elaboración</label>
                                    <input id="fechaActual" name="fecha" type="date" disabled>
                                </div>');

                                echo('<script> window.onload = function(){
                                    var fecha = new Date(); //Fecha actual
                                    var mes = fecha.getMonth()+1; //obteniendo mes
                                    var dia = fecha.getDate(); //obteniendo dia
                                    var ano = fecha.getFullYear(); //obteniendo año
                                    if(dia<10)
                                    dia=\'0\'+dia; //agrega cero si el menor de 10
                                    if(mes<10)
                                    mes=\'0\'+mes //agrega cero si el menor de 10
                                    document.getElementById(\'fechaActual\').value=ano+"-"+mes+"-"+dia;
                                }</script>');
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
                                        <label for="descripcion">Descripción del servicio solicitado o falla a reparar:</label>
                                        <textarea id ="descripcion" name ="descripcion" placeholder="'.$row3['descripcion'].'" disabled></textarea>
                                    </div>'); 
                                echo('
                                <div class="observacion">
                                    <label for="observacion">Observaciones o Comentarios </label>
                                    <textarea id ="observacion" name ="observacion" placeholder="Los administradores deben de colocar de manera obligatoria las observaciones o comentarios para que el solicitante de seguimiento a su solicitud." required></textarea>
                                </div>'); 

                                echo('
                                <div class = "Botones">
                                    <div class="btnRS">
                                        <input type="submit" name = "btn"  value="Rechazar Solicitud">
                                    </div>
                                    <div class="btnAS">
                                        <input type="submit" name = "btn" value="Aceptar Solicitud">
                                    </div>
                                </div>
                                
                                ');
                                
                            
                            }else{
                                $ban3 = false;
                            } 
                        }else{
                            $ban0 = false;
                        }
                    }
                }
            ?>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>