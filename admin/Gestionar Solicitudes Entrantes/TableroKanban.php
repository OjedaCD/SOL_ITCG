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

    $ban = null;
    $ban0 = null;
    $ban2 = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){

        //idSolicitud con el folio
        $id = $_POST['tipoForm'];//el id de usuario se ocupa para validar que quien modifique la persona sea la misma que la creó
        $folio = $_POST['tipoForm2'];
        $falla =$_POST['checkbox'];
        $descripcion = $_POST['descripcion']; 
        $fecha = date('Y-m-d');

        $queryIdSol = "SELECT s.idSolicitud FROM solicitudes as s WHERE s.folio = $folio";
        $resultadoIdSol =mysqli_query($db, $queryIdSol);
        $aux3 = mysqli_fetch_assoc($resultadoIdSol);//Guarda el id de la solicitud

        
        foreach ($aux3 as $key => $idSol) {
            
            $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
            $resultadoLlave0 = mysqli_query($db, $query0);
    
            $queryBorrar ="DELETE FROM detalles WHERE idSolicitud = '{$idSol}' ";
            $resultadoBorrar= mysqli_query($db, $queryBorrar);

            $query1 = "SET FOREIGN_KEY_CHECKS=1";
            $resultadoLlave0 = mysqli_query($db, $query1);

            foreach ($falla as $key => $fallas) {
                $queryFalla = "INSERT INTO detalles (idSolicitud, idFalla) VALUES ('{$idSol}','{$fallas}')";
                $resultadoFalla =mysqli_query($db, $queryFalla);
            }
            $querySol = "UPDATE solicitudes SET `folio`='$folio', `fecha`='$fecha', `descripcion`='$descripcion'
            WHERE idSolicitud = '$idSol'";
            $resultadoUs =mysqli_query($db, $querySol);

            if($resultadoUs && $resultadoFalla && $resultadoBorrar){
                $ban3 = true;
            }else{
                $ban3 = false;
            }
        }
        
    }
?>
<main class="ModificarSolicitud">
    <section class="w80">
        <h1>Modificar Solicitud</h1>
        <form method="GET" class="tiposSol" >
            <div class="folioS">
                <label for="folioS">Ingrese el número de folio</label>
                <input required type="text" name="folioS" id="folioS" pattern="[0-9]+">           
            </div>
            <div class="btnBus">
                <input type="submit" value="Buscar Solicitud">
            </div> 
            <input type="hidden" name="tipoForm" value="bandera">
        </form>
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
        <form method="POST" onsubmit="return validar(this)">
            <?php 
                if ($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['tipoForm'])) {
                    //Obtengo los datos del form
                    $folio = $_GET['folioS']?? null;;
                    $query = "SELECT folio FROM solicitudes";
                    $resultado = mysqli_query($db, $query);
                    
                    while($usuario = mysqli_fetch_assoc($resultado)){
                        if( $folio == $usuario['folio']){//valida si existe en la bd
                            $ban = true;
                            $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
                            $resultadoIdUs = mysqli_query($db, $queryIdUs);// guardo el id del usuario

                            foreach ($resultadoIdUs as $value) {//Envío el id en un input tipo hidden
                                foreach ($value as $key) {
                                    echo ('<input type="hidden" name="tipoForm" value="'.$key.'" >');//Envío el id sel usuario 
                                }
                            }
                            if ($_SESSION['idUser'] == $key){
                                $ban2 = true;
                                $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $key ";
                                $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                                $row = mysqli_fetch_assoc($resultadoDatos);
                                
                                $queryDpto ="SELECT s.idDpto, s.idSolicitud FROM solicitudes as s WHERE s.folio = $folio  ";
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
                                
                                echo('<div class="descripcion">
                                        <label for="descripcion">Descripción del servicio solicitado o falla a reparar:</label>
                                        <textarea id ="descripcion" name ="descripcion" placeholder="Ingresa la descripción lo más detallada posible, en caso de no hacerlo tu solicitud será rechazada. Debe de contener la descripción del servicio solicitado o reparación de fallas identificadas en los equipos, y su ubicación precisa dentro del ITCG." required></textarea>
                                    </div>'); 
                                echo('
                                <div class="observacion">
                                    <label for="observacion">Correcciones para que su solicitud sea valida:</label>
                                    <textarea id ="observacion" disabled name ="observacion" placeholder="Aquí aparecerán las correcciones pertinentes para que su solicitud sea válida, en caso de ser RECHAZADA."></textarea>
                                </div>'); 

                                echo('
                                <div class="btnCS">
                                    <input type="submit" value="Modificar Solicitud">
                                </div>');
                            
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
    if ($_SERVER['REQUEST_METHOD'] === "GET" && $ban == true && isset($_GET['tipoForm']) ) {
        echo "<script>exito('Folio Encontrado');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "GET" && $ban0 == false && isset($_GET['tipoForm'])){
        echo "<script>fracaso('Error! El folio no existe');</script>";
    }if($ban2 == false && isset($_GET['tipoForm']) && $_SERVER['REQUEST_METHOD'] === "GET"){
        echo "<script>fracaso('Error! la solicitud no le pertenece, ingrese una propia');</script>";
    }
    if($_SERVER['REQUEST_METHOD'] === "POST" && $ban3 == true){
        echo "<script>exito('Se ha modificado su solicitud');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban3 == false){
        echo "<script>fracaso('Intente otra vez, su solicitud no se ha modificado');</script>";
    }
?>