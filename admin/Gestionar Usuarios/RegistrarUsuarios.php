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
    
    $queryId = "SELECT MAX(idUser)+1 FROM users ";//Query para obtener el último id de la la tabla users + 1
    $resultadoId =mysqli_query($db, $queryId);
    
    $email ="";
    $token = "";
    $nombre="";
    $apellidoP="";
    $apellidoS="";
    $rolUsuario = "";
    $departamento = "";
    $password = "";
    $ban = true;
    if ($_SERVER['REQUEST_METHOD']==="POST") {
        //Obtengo los datos del form
        
        $idUser = mysqli_fetch_assoc($resultadoId);//Guarda el id
        $email = $_POST['emailS'];
        $token = $_POST['password'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoS = $_POST['apellidoS'];
        $telefono = $_POST['telefono'];
        $rolUsuario =$_POST['rolUsuario'];
        $departamento =$_POST['departamento'];
        $password =$_POST['password'];
        $edo = "HABILITADO";

        $email = "".trim($email)."@cdguzman.tecnm.mx";
        foreach($idUser as $value){//Recorro una vez y lo inserto en users
            if($value < 1){
                $value += 1;
            }
            if(empty($telefono)){//Valida que no sea nulo
                $telefono = 0;
            }
            $apellidoUsuario = $apellidoP ." ".$apellidoS;//El apellido primero y segundo se concatenan
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);//Se encripta la contraseña con un costo elevado a la 10
            $queryUs ="INSERT INTO users (idUser, email, token, nomUsuario, apellidoUsuario, telefono, edoUser, idRole, idDpto) VALUES ('{$value}','{$email}','{$passwordhash}','{$nombre}','{$apellidoUsuario}','{$telefono}','{$edo}','{$rolUsuario}','{$departamento}')";
            $resultadoUs =mysqli_query($db, $queryUs);
        }
    }
?>
<main class="RegistroNuevoUsuario">
    <section class="w80">
        <h1>Registrar Nuevo Usuario</h1>
        <form method="POST">
            <div class="user">
                <div class="emailS">
                    <label for="emailS">Email</label>
                    <input required type="text" name="emailS" id="emailS" required onkeypress= "return letrasNumeros(event)" maxlength="10" pattern="[A-Za-z 0-9]+">           
                </div>
                <div class="emailD">
                    <input disabled type="text" name="emailD" id="emailD"  placeholder="@cdguzman.tecnm.mx" value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
                </div>
            </div>
            
            <div class="nombreUser">
                <label for="nombre">Nombre</label>
                <input required type="text" name="nombre" id="nombre"  maxlength="50"  pattern="[A-Za-z áéíóí]+" required onkeypress= "return letrasYespacios(event)">           
            </div>
            <div class="apellidoP">
                <label for="apellido">Primer Apellido</label>
                <input required type="text" name="apellidoP" id="apellidoP"maxlength="50"  pattern="[A-Za-z áéíóí]+" required onkeypress= "return letrasYespacios(event)">           
            </div>
            <div class="apellidoS">
                <label for="apellido">Segundo Apellido</label>
                <input required type="text" name="apellidoS" id="apellidoS"maxlength="50"  pattern="[A-Za-z áéíóí]+" required  onkeypress= "return letrasYespacios(event)">           
            </div>
            <div class="tel">
                <label for="tel">Teléfono</label>
                <input type="tel" name="telefono" placeholder="--Opcional--Introduce tú número de teléfono" minlength="0" maxlength="10" pattern="[0-9]+" onkeypress="return ValidaNumeros(event)">
            </div>
            <div class="rolUsuario">
                <label for="rolUsuario">Rol de Usuario</label>
                <select name="rolUsuario" id="rolUsuario" required>
                    <option value=""disabled selected>--Seleccione Rol--</option>  
                    <?php while($rol = mysqli_fetch_assoc($resultadoRol)):?>
                        <option value="<?php echo $rol['idRole'];?>">
                            <?php echo $rol['nomRole'];?>
                        </option>
                    <?php endwhile;?>  
                </select>
            </div>
            <div class="departamento">
            <label for="departamento">Departamento</label>
                <select name="departamento" id="departamento" required>
                    <option value=""disabled selected>--Seleccione Departamento--</option>  
                    <?php while($dpto = mysqli_fetch_assoc($resultadoDep)):?>
                        <option value="<?php echo $dpto['idDpto'];?>">
                            <?php echo $dpto['nomDpto'];?>
                        </option>
                    <?php endwhile;?>  
                </select>         
            </div>
            <div class="eye">
                <label for="password">Contraseña</label>
                <input required type="password" name="password" id="password" maxlength="8" minlength="8" placeholder="Ingrese una contraseña de 8 caracteres"> 
                <img src="/src/img/Show.png" alt="" class="icon" id="ojo">
            </div>
            <div class="btnRU">
                <input type="submit" value="Registrar Usuario">
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
    if ($ban && $_SERVER['REQUEST_METHOD']==="POST") {
        echo "<script>exito('Usuario Registrado');</script>";
    }
?>