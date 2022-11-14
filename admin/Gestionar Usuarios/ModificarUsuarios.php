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

    $queryDep ="SELECT * FROM departamentos ORDER BY nomDpto";//Query para mostrar la el select con los departamentos
    $resultadoDep= mysqli_query($db, $queryDep);
    $ban = null;

    if ($_SERVER['REQUEST_METHOD']==="POST" ){
        
        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $departamento = $_POST['departamento'];
        $rolU = $_POST['rolUsuario'];
        $id = $_POST['tipoForm2'];

        $email = "".trim($email)."@cdguzman.tecnm.mx";

        $query0 = "SET FOREIGN_KEY_CHECKS=0";// Se desactivan el chequeo de las llaves foraneas
        $resultadoLlave0 = mysqli_query($db, $query0);
        
        $queryModificar= "UPDATE users SET `email`='$email',`nomUsuario`='$nombre', `apellidoUsuario`='$apellidos',`telefono`='$telefono',idRole='$rolU', idDpto ='$departamento' WHERE idUser = '$id'";
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
<main class="ModificarUsuarios">
    <section class="w80">
        <h1>Modificar Usuarios</h1>
        <!--Es un tipo de formulario -->
        <form method="GET" class="buscarUs" >
            
            <div class="emailS">
                <label for="emailS">Email</label>
                <input type="text" name="emailS" id="emailS" required onkeypress= "return letrasNumeros(event)" maxlength="10" pattern="[A-Za-z 0-9]+">           
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
                            $queryDatos= "SELECT u.idUser, u.email, u.nomUsuario, u.apellidoUsuario, u.edoUser, u.telefono, u.idDpto, r.nomRole FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole WHERE u.email = '$email'";
                            $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                            $row = mysqli_fetch_assoc($resultadoDatos);//Toma los datos de usuarios y roles
                            echo ('
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value = "'.rtrim($row["email"],"@cdguzman.tecnm.mx").'" required onkeypress= "return letrasNumeros(event)" maxlength="10" pattern="[A-Za-z 0-9]+" >           
                                <input type="hidden" name="tipoForm2" value="'.$row["idUser"].'">
                            </div>');
                        
                            echo('
                            <div class="nombreUser">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"].'" maxlength="50" pattern="[A-Za-z áéíóí]+" required onkeypress= "return letrasYespaciosModificar(event)" >           
                            </div>');
                            echo('
                            <div class="apellidoUser">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" value = "'.$row["apellidoUsuario"].'" maxlength="50" pattern="[A-Za-z áéíóí]+" required onkeypress= "return letrasYespaciosModificar(event)">           
                            </div>');
                             
                            echo('
                            <div class="telefono">
                                <label for="telefono">Telefono</label>
                                    <input type="text" name="telefono" id="telefono" value = "'.$row["telefono"].'" placeholder="Introduce tú número de teléfono" minlength="0" maxlength="10" pattern="[0-9]+" onkeypress="return ValidaNumeros(event)">           
                            </div>');
                            echo('
                            <div class="departamento">
                                <label for="departamento">Departamento</label>
                                <select name="departamento" id="departamento" required>
                                    <option value=""disabled selected>--Seleccione Departamento--</option>');
                                     while($dpto = mysqli_fetch_assoc($resultadoDep)){
                                        echo('<option value="'.$dpto['idDpto'].'">');
                                        echo $dpto['nomDpto'];
                                        echo ('</option>');
                                     }
                                echo('
                                </select> 
                            </div>');  
                            echo('
                            <div class="rolUsuario">
                                <label for="rolUsuario">Rol de Usuario</label>
                                <select name="rolUsuario" id="rolUsuario" required>
                                    <option value=""disabled selected>--Seleccione Rol--</option>');
                                    while($rol = mysqli_fetch_assoc($resultadoRol)){
                                        echo('<option value="'.$rol['idRole'].'">');
                                        echo $rol['nomRole'];
                                        echo ('</option>');
                                    }
                                    echo('
                                </select> 
                            </div>');                           
                            echo('
                            <div class="btnMU">
                                <input type="submit" value="Modificar Usuario">
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
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true){
        echo "<script>exito('El usuario se ha modificado');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false){
        echo "<script>fracaso('No se ha podido modificar el usuario');</script>";
    }
?>