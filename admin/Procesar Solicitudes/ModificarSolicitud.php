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
        
            $querySol = "
            INSERT INTO solicitudes (idSolicitud, idUser, idDpto, folio, fecha, descripcion, observacion, Etapa, Prioridad, Estado) 
            VALUES ('{$idSol}','{$id}','{$area}','{$folio}', '{$fecha}','{$descripcion}','{$descripcion}','{$etapa}','{$prioridad}','{$estado}')";
            $resultadoUs =mysqli_query($db, $querySol);

            $query1 = "SET FOREIGN_KEY_CHECKS=1";
            $resultadoLlave0 = mysqli_query($db, $query1);
        }
    }
?>
<main class="ModificarSolicitud">
    <section class="w80">
        <h1>Modificar Solicitud</h1>
        <form method="GET" class="tipoSol" >
           
        <div class="folioS">
                <label for="folioS">Ingrese el número de folio</label>
                <input required type="text" name="folioS" id="folioS" pattern="[0-9]+">           
                <div class="btnBus">
                    <input type="submit" value="Buscar Usuario">
                </div> 
            </div>
        
            <input type="hidden" name="tipoForm" value="bandera">
        </form>



        <form method="POST">
            <?php 

                if ($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['tipoForm'])) {
                    //Obtengo los datos del form
                    $folio = $_GET['folioS']?? null;;
                   
                    $query = "SELECT * FROM users";
                    $resultado = mysqli_query($db, $query);
                    var_dump($folio);
                    $queryIdUs ="SELECT s.idUser FROM solicitudes as s WHERE s.folio = '{$folio}' ";
                    $resultadoIdUs = mysqli_query($db, $queryIdUs);// guardo el id del usuario

                    foreach ($resultadoIdUs as $value) {//Envío el id en un input tipo hidden
                        foreach ($value as $key) {
                            echo ('<input type="hidden" name="tipoForm" value="'.$key.'" >');//Envío el id sel usuario
                            $aux = $key;
                        }
                    }

                    if($resultadoIdUs){
                        $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.idDpto FROM users as u WHERE u.idUser = $aux ";
                        $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                        $ban = true; 
                        foreach ($resultadoId as $value) {//Envío el id en un input tipo hidden
                            foreach ($value as $key) {
                                echo ('<input type="hidden" name="tipoForm" value="'.$key.'" >');
                            }
                        }
                        $row = mysqli_fetch_assoc($resultadoDatos);

                        echo ('
                        <div class="email">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" value = "'.$row["email"].'" pattern="[A-Za-z 0-9]+" disabled>           
                        </div>');
                        $Year = date("Y");



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
                    }else{
                        $ban = false;
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