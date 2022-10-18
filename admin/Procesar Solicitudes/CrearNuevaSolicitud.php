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

    $queryIdSol = "SELECT MAX(idSolicitud)+1 FROM solicitudes ";
    $resultadoIdSol =mysqli_query($db, $queryIdSol);

    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";
    $resultadoDep= mysqli_query($db, $queryDep);
    
    $queryFallaCP ="SELECT * FROM fallas WHERE idFalla <=7";
    $resultadoFallaCP= mysqli_query($db, $queryFallaCP);

    $queryFallaCP2 ="SELECT * FROM fallas WHERE idFalla >7";
    $resultadoFallaCP2= mysqli_query($db, $queryFallaCP2);

    $ban = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){
        
        $idSolicitud = mysqli_fetch_assoc($resultadoIdSol);//Guarda el id de la solicitud
        $id = $_POST['tipoForm'];
        $folio = $_POST['tipoForm2'];
        $falla =$_POST['checkbox'];
        $descripcion = $_POST['descripcion']; 
        $observacion = " ";
        $area = $_GET['area']?? null;
        $etapa = "PENDIENTE";
        $prioridad = "BAJA";
        $estado = "ESPERA";
        $fecha = date('Y-m-d');
        
        
        foreach($idSolicitud as $idSol){
            $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
            $resultadoLlave0 = mysqli_query($db, $query0);
        
            if($idSol< 1){
                $idSol += 1;
                
            }
            foreach ($falla as $key => $fallas) {
                $queryFalla = "INSERT INTO detalles (idSolicitud, idFalla) VALUES ('{$idSol}','{$fallas}')";
                $resultadoFalla =mysqli_query($db, $queryFalla);
            }
        
            $querySol = "INSERT INTO solicitudes (idSolicitud, idUser, idDpto, folio, fecha, descripcion, observacion, Etapa, Prioridad, Estado) 
            VALUES ('{$idSol}','{$id}','{$area}','{$folio}', '{$fecha}','{$descripcion}','{$observacion}','{$etapa}','{$prioridad}','{$estado}')";
            $resultadoUs =mysqli_query($db, $querySol);

            $query1 = "SET FOREIGN_KEY_CHECKS=1";
            $resultadoLlave0 = mysqli_query($db, $query1);
        }
    }
?>
<main class="CrearNuevaSolicitud">
    <section class="w80">
        <h1>Crear Nueva Solicitud</h1>
        <form method="GET" class="tipoSol" >
            <div class="area">
            <label for="area">Area</label>
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
                <input required type="text" name="emailS" id="emailS" pattern="[A-Za-z 0-9]+">           
           </div>
           <div class="emailD">
                <input disabled type="text" name="emailD" id="emailD"  placeholder="@cdguzman.tecnm.mx" value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
           </div>
           <div class="btnBus">
                <input type="submit" value="Buscar Usuario">
            </div>
            <input type="hidden" name="tipoForm" value="bandera">
        </form>
        <form method="POST">
            <?php 
                if ($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['tipoForm'])) {
                    //Obtengo los datos del form
                    $email = $_GET['emailS']?? null;;
                    $area = $_GET['area']?? null;;
                    $email = "".trim($email)."@cdguzman.tecnm.mx";

                    $query = "SELECT * FROM users";
                    $resultado = mysqli_query($db, $query);
                    while($usuario = mysqli_fetch_assoc($resultado)){//Comprueba si existe el email en la BD
                        if( $email == $usuario['email']) {
                            $ban = true; 
                            $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.email = '$email'";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $queryId = "SELECT u.idUser FROM users as u WHERE u.email = '{$email}'";//se necesita el id del usuario para relacionarlo con accesos
                            $resultadoId = mysqli_query($db, $queryId);
    
                            foreach ($resultadoId as $value) {//Envío el id en un input tipo hidden
                                foreach ($value as $key) {
                                    echo ('<input type="hidden" name="tipoForm" value="'.$key.'" >');
                                }
                            }

                            $idSolicitud = mysqli_fetch_assoc($resultadoIdSol);
                            $row = mysqli_fetch_assoc($resultadoDatos);

                            echo ('
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value = "'.$row["email"].'" pattern="[A-Za-z 0-9]+" disabled>           
                            </div>');
                            $Year = date("Y");

                            foreach($idSolicitud as $value){
                                if($value < 1){
                                    $value += 1;
                                }
                                $aux = $area.$value.$Year;
                                
                                echo ('<div class="folio">
                                            <label for="folio">Folio</label>
                                            <input type="text" name="'.$aux.'" id="folio" value="'.$aux.'" disabled>           
                                        </div>
                                        ');       
                            }
                            echo ('<input type="hidden" name="tipoForm2" value="'.$aux.'" >');

                            echo('
                            <div class="nombreUser">
                                <label for="nombre">Nombre del Solicitante</label>
                                <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"]." ".$row["apellidoUsuario"].'" maxlength="50" pattern="[A-Za-z]+" disabled >           
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

                            
                            if($area == 20){//Formulario del centro de computo
                                echo('<div class="fallas" ">');
                                     while($falla = mysqli_fetch_assoc($resultadoFallaCP)){
                                        echo('<input type = "checkbox" name ="checkbox[]" value="'.$falla['idFalla'].'">'.$falla['nomFalla'].'<br>');
                                     }
                            echo('</div>'); 
                            
                            }elseif($area == 21){//Formulario de servicios de mantenimiento
                                echo('<div class="fallas" >');
                                     while($falla = mysqli_fetch_assoc($resultadoFallaCP2)){
                                        echo('<input type = "checkbox" name ="checkbox[]" value="'.$falla['idFalla'].'">'.$falla['nomFalla'].'<br>');
                                     }
                            echo('</div>'); 
                            }

                            echo('
                            <div class="descripcion">
                                <textarea id ="descripcion" name ="descripcion" placeholder="Ingresa la descripción de la falla lo más detallada posible."></textarea>
                            </div>'); 

                            echo('
                            <div class="btnCS">
                                <input type="submit" value="Crear Solicitud">
                            </div>');
                            break;
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
    if ($_SERVER['REQUEST_METHOD'] === "GET" && $ban == true && isset($_GET['tipoForm'])) {
        echo "<script>exito('Usuario Encontrado');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "GET" && $ban == false && isset($_GET['tipoForm'])){
        echo "<script>fracaso('Error! El email no existe');</script>";
    }
?>