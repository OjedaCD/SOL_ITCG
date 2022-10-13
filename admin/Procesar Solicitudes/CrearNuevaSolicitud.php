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

    $queryRol ="SELECT * FROM roles WHERE idRole != 1";
    $resultadoRol=mysqli_query($db, $queryRol);

    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";//Query para mostrar la el select con los departamentos
    $resultadoDep= mysqli_query($db, $queryDep);
    
    $ban = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){
        
        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $departamento = $_POST['departamento'];
        $rolU = $_POST['rolUsuario'];
        $id = $_POST['tipoForm'];

        $email = "".trim($email)."@cdguzman.tecnm.mx";

        $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
        $resultadoLlave0 = mysqli_query($db, $query0);
        
        $queryModificar= "UPDATE users u INNER JOIN accesos a on u.idUser = a.idUser SET `email`='$email',`nomUsuario`='$nombre', `apellidoUsuario`='$apellidos',`telefono`='$telefono',u.idRole='$rolU', a.idRole = u.idRole, a.idDpto ='$departamento' WHERE u.idUser = '$id'";
        $resultadoModificar = mysqli_query($db, $queryModificar);

        if($resultadoModificar) {
            $ban = true;
        } else{
            $ban = false;
        }
        $query1 = "SET FOREIGN_KEY_CHECKS=1";
        $resultadoLlave0 = mysqli_query($db, $query1);
    }
?>
<main class="CrearNuevaSolicitud">
    <section class="w80">
        <h1>Crear Nueva Solicitud</h1>
        <!--Es un tipo de formulario -->
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
        <!--Es un tipo de formulario -->
        <form method="POST">
            <?php 
                if ($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['tipoForm'])) {
                    //Obtengo los datos del form
                    $email = $_GET['emailS']?? null;;
                    $email = "".trim($email)."@cdguzman.tecnm.mx";
                    $query = "SELECT * FROM users";
                    $resultado = mysqli_query($db, $query);
                    while($usuario = mysqli_fetch_assoc($resultado)){//Comprueba si existe el email en la BD
                        if( $email == $usuario['email']) {
                            $ban = true;
                            //Aquí va el envia el codigo a los inputs
                            $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario,u.telefono, r.nomRole FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole WHERE u.email = '$email'";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $queryId = "SELECT u.idUser FROM users as u WHERE u.email = '{$email}'";//se necesita el id del usuario para relacionarlo con accesos
                            $resultadoId = mysqli_query($db, $queryId);
                            //Recorre un arregelo el foreach, y el value as key es para utilizar la llave principal
                            foreach ($resultadoId as $value) {
                                foreach ($value as $key) {
                                    $queryDpto = "SELECT  d.nomDpto FROM departamentos as d INNER JOIN accesos as ac ON ac.idDpto = d.idDpto WHERE ac.idUser = '{$key}'";
                                    $resultadoDpto = mysqli_query($db, $queryDpto);
                                    echo ('<input type="hidden" name="tipoForm" value="'.$key.'">');
                                }
                            }
                            $row = mysqli_fetch_assoc($resultadoDatos);//Toma los datos de usuarios y roles
                            $row2 = mysqli_fetch_assoc($resultadoDpto);//Toma los datos de accesos y departamentos
                            echo ('
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value = "'.$row["email"].'" pattern="[A-Za-z 0-9]+" disabled>           
                            </div>');
                            echo ('
                            <div class="folio">
                                <label for="folio">Folio</label>
                                <input type="text" name="folio" id="folio" value = "" disabled>           
                            </div>');
                            echo('
                            <div class="nombreUser">
                                <label for="nombre">Nombre del Solicitante</label>
                                <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"].$row["apellidoUsuario"].'" maxlength="50" pattern="[A-Za-z]+" disabled >           
                            </div>');
                            echo('
                            <div class="fecha">
                                <label for="fecha">Fecha de elaboración</label>
                                <input type="date"  name="fecha" id"fecha">           
                            </div>');
                            echo('
                            <div class="falla">
                            <label><input type="checkbox" id="cbox1" value="first_checkbox"> Este es mi primer checkbox</label><br>

                            </div>');

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