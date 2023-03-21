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
    $ban = null;
    $ban2 = null;
    if ($_SERVER['REQUEST_METHOD']==="POST" ){
        
        
        $id = $_POST['tipoForm'];
        $falla =$_POST['checkbox'];
        $descripcion = $_POST['descripcion']; 
        $observacion = " ";
        $area = $_GET['area']?? null;
        $etapa = "1PENDIENTE";
        $prioridad = "3BAJA";
        $estado = "ESPERA";
        $tipo = "INTERNO";
        $validacion = 0;
        $mantenimiento = "CORRECTIVO";
        $lugar = "CÓMPUTO";
        
        date_default_timezone_set("America/Mexico_City");
        $fecha = date('Y-m-d');
        $Year = date("Y");

        $queryIdSolCC = "SELECT MAX(idSolicitudCC)+1 FROM solicitudes WHERE idDpto = 20 ";
        $resultadoIdSolCC =mysqli_query($db, $queryIdSolCC);
        $idSolicitudCC = mysqli_fetch_assoc($resultadoIdSolCC);//Guarda el id de la solicitud

        $queryIdSolME = "SELECT MAX(idSolicitudME)+1 FROM solicitudes WHERE idDpto = 21 ";
        $resultadoIdSolME =mysqli_query($db, $queryIdSolME);
        $idSolicitudME = mysqli_fetch_assoc($resultadoIdSolME);//Guarda el id de la solicitud

        $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
        $resultadoLlave0 = mysqli_query($db, $query0);
        $folio;
        if($area == 20){//Centro de Cómputo 
            foreach($idSolicitudCC as $idSolCC){
                if($idSolCC< 1){
                    $idSolCC += 1;
                }
                foreach($idSolicitudME as $idSolME){
                    $folio = $Year.$area."CC".$idSolCC;
                    if($idSolME > 0){
                        $idSolME -= 1;
                    }
                    $querySol = "INSERT INTO solicitudes (idSolicitudCC, idSolicitudME, idUser, idDpto, folio, fecha, tipo, mantenimiento, lugar, descripcion, observacion, Etapa, Prioridad, Estado, validacion) 
                    VALUES ('{$idSolCC}','{$idSolME}','{$id}','{$area}','{$folio}', '{$fecha}','{$tipo}','{$mantenimiento}','{$lugar}','{$descripcion}','{$observacion}','{$etapa}','{$prioridad}','{$estado}','{$validacion}')";
                    $resultadoUs =mysqli_query($db, $querySol);
                }
            }
        }
        if ($area == 21){//Mantenimiento de Equipo
            foreach($idSolicitudME as $idSolME){
                if($idSolME< 1){
                    $idSolME += 1;
                }
                foreach($idSolicitudCC as $idSolCC){
                    $folio = $Year.$area."ME".$idSolME;
                    if($idSolCC > 0){
                        $idSolCC -= 1;
                    }
                    $querySol = "INSERT INTO solicitudes (idSolicitudCC, idSolicitudME, idUser, idDpto, folio, fecha, tipo, mantenimiento, lugar, descripcion, observacion, Etapa, Prioridad, Estado, validacion) 
                    VALUES ('{$idSolCC}','{$idSolME}','{$id}','{$area}','{$folio}', '{$fecha}','{$tipo}','{$mantenimiento}','{$lugar}','{$descripcion}','{$observacion}','{$etapa}','{$prioridad}','{$estado}','{$validacion}')";
                    $resultadoUs =mysqli_query($db, $querySol);
                }
            }
        }      

        foreach ($falla as $key => $fallas) {
            $queryFalla = "INSERT INTO detalles (folio, idFalla) VALUES ('{$folio}','{$fallas}')";
            $resultadoFalla =mysqli_query($db, $queryFalla);
        }
        
        if($resultadoUs && $resultadoFalla){
            $ban3 = true;
        }else{
            $ban3 = false;
        }

        $query1 = "SET FOREIGN_KEY_CHECKS=1";
        $resultadoLlave0 = mysqli_query($db, $query1);
    }
?>
<main class="CrearNuevaSolicitud">
    <section class="w80">
        <h1>Crear Nueva Solicitud</h1>
        <form method="GET" class="tipoSol" >
            <div class="area">
            <label for="area">Área</label>
                <select name="area" id="area" required>
                    <option value=""disabled selected>--Seleccione Área Solicitante--</option>  
                    <?php while($dpto = mysqli_fetch_assoc($resultadoDep)):?>
                        <option value="<?php echo $dpto['idDpto'];?>">
                            <?php echo $dpto['nomDpto'];?>
                        </option>
                    <?php endwhile;?>  
                </select>         
            </div>
            <div class="emailS">
                <label for="emailS">Email</label>
                <input required type="text" name="emailS" id="emailS" required  maxlength="25" pattern="[A-Za-z 0-9.]+">           
           </div>
           <div class="emailD">
                <input disabled type="text" name="emailD" id="emailD"  placeholder="@cdguzman.tecnm.mx" value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
           </div>
           <div class="btnBus">
                <input type="submit" value="Generar Formulario">
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
                    $email = $_GET['emailS']?? null;;
                    $area = $_GET['area']?? null;;
                    $email = "".trim($email)."@cdguzman.tecnm.mx";
                    
                    
                    $query = "SELECT * FROM users";
                    $resultado = mysqli_query($db, $query);
                    while($usuario = mysqli_fetch_assoc($resultado)){//Comprueba si existe el email en la BD
                        $queryId = "SELECT u.idUser FROM users as u WHERE u.email = '{$email}'";//se necesita el id del usuario para relacionarlo con accesos
                        $resultadoId = mysqli_query($db, $queryId);
                        foreach ($resultadoId as $value) {//Envío el id en un input tipo hidden
                            foreach ($value as $key) {
                                echo ('<input type="hidden" name="tipoForm" value="'.$key.'" >');
                            }
                        }
                        if( $email == $usuario['email']) {//Comprueba el email dentro de la BD
                            $ban = true; 
                            if($_SESSION['idUser'] == $key){//Compruba que el usuario que genera la solicitud sea el mismo que inicio sesion
                                $ban2 = true;
                                $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.email = '$email'";
                                $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                                $row = mysqli_fetch_assoc($resultadoDatos);

                                $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
                                $resultadoDpto = mysqli_query($db, $queryDpto);
                                $row2 = mysqli_fetch_assoc($resultadoDpto);//departamento al que pertenece el usuario
                                
                                if($area == 20){//Centro de Cómputo 
                                    $queryIdSol = "SELECT MAX(idSolicitudCC)+1 FROM solicitudes WHERE idDpto = 20 ";
                                    $resultadoIdSol =mysqli_query($db, $queryIdSol);
                                }else{//Mantenimiento de Equipo
                                    $queryIdSol = "SELECT MAX(idSolicitudME)+1 FROM solicitudes WHERE idDpto = 21 ";
                                    $resultadoIdSol =mysqli_query($db, $queryIdSol);
                                }
                                $idSolicitud = mysqli_fetch_assoc($resultadoIdSol);
                                $Year = date("Y");
                                foreach($idSolicitud as $value){
                                    if($value < 1){
                                        $value += 1;
                                    }  
                                    if($area == 20){
                                        $aux = $Year.$area."CC".$value;
                                    }elseif($area == 21){
                                        $aux = $Year.$area."ME".$value;
                                    }
                                    echo ('
                                    <div class="folio">
                                        <label for="folio">Folio</label>
                                        <input type="text" name= "folio" id= "folio" value="'.$aux.'" disabled>           
                                    </div>'); 
                                    
                                }
                                echo ('<input type="hidden" name="tipoForm2" value="'.$aux.'" >');
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
                                
                                if($area == 20){//Formulario del centro de computo
                                    echo('<div class="fallas" ">');
                                        while($falla = mysqli_fetch_assoc($resultadoFallaCP)){
                                            echo('<input type = "checkbox" name ="checkbox[]" value="'.$falla['idFalla'].'"><label>'.$falla['nomFalla'].'</label><br>');
                                        }
                                echo('</div>'); 
                                
                                }elseif($area == 21){//Formulario de servicios de mantenimiento
                                    echo('<div class="fallas2" >');
                                        while($falla = mysqli_fetch_assoc($resultadoFallaCP2)){
                                            echo('<input type = "checkbox" name ="checkbox[]" value="'.$falla['idFalla'].'"><label>'.$falla['nomFalla'].'</label><br>');
                                        }
                                echo('</div>'); 
                                }

                                echo('
                                <div class="descripcion">
                                    <label for="descripcion">Descripción del servicio solicitado o falla a reparar:</label>
                                    <textarea id ="descripcion" maxlength="255" name ="descripcion" placeholder="Ingresa la descripción lo más detallada posible, en caso de no hacerlo tu solicitud será rechazada. Debe de contener la descripción del servicio solicitado o reparación de fallas identificadas en los equipos, y su ubicación precisa dentro del ITCG." required></textarea>
                                </div>'); 

                                echo('
                                <div class="btnCS">
                                    <input type="submit" value="Crear Solicitud">
                                </div>');
                                break;
                            }else{
                                $ban2 = false;
                            }
                        }else{
                            $ban = false;
                        }
                    }
                }
            ?>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
    if ($_SERVER['REQUEST_METHOD'] === "GET" && $ban == true && isset($_GET['tipoForm']) && $ban2 == true) {
        echo "<script>exito('Usuario Encontrado se ha generado el formulario');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "GET" && $ban == false && isset($_GET['tipoForm'])){
        echo "<script>fracaso('Error! Email invalido');</script>";
    }if($_SERVER['REQUEST_METHOD'] === "POST" && $ban3 == true){
        echo "<script>exito('Se ha generado su solicitud');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban3 == false){
        echo "<script>fracaso('Intente otra vez, su solicitud no se ha generado');</script>";
    }
?>