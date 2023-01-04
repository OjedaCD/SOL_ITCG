<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
    if ($_SESSION['idRole'] != '1' && $_SESSION['idRole'] != '2' ) {
        header('location: /admin/index.php'); 
        die();
    }
    $db = conectarDB();

    $ban = null;
    $queryDep ="SELECT * FROM departamentos ORDER BY nomDpto";//Query para mostrar la el select con los departamentos
    $resultadoDep= mysqli_query($db, $queryDep);

?>
<main class="ConsultarUsuario">
    <section class="w80">
        <h1>Consultar Usuarios</h1>
        <div class="btnsLista">
            <input type="button" onclick="mostrarContenido();" value="Consultar usuarios por departamento" class="btnChoseD">
            <input type="button" onclick="mostrarContenido3();" value="Consulta general" class="btnChoseG" >
            <input type="button" onclick="mostrarContenido2();" value="Consultar usuarios por correo" class="btnChoseC" >
        </div>
        <form method="POST" id="content1" class="content1">
            <!--Aquí muestro las dos opciones y dos inputs tipo hiden-->
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
                <div class="btnCOUD">
                    <input type="hidden" name="tipoForm" value="departamento">
                    <input type="submit" value="Buscar" name="btnCOUD">
                </div>        
            </div>
        </form>

        <form method="POST" id="content2" class="content2">
            <!--Dependiendo de la opción mostrada y el input hidden aquí presento o el usuario o la lista-->
            <div class="emailS">
                <label for="emailS">Email</label>
                <input required type="text" name="emailS" id="emailS" required maxlength="25" pattern="[A-Za-z 0-9.]+">           
           </div>
           <div class="emailD">
                <input disabled type="text" name="emailD" id="emailD"  placeholder="@cdguzman.tecnm.mx" value="@cdguzman.tecnm.mx" pattern=".+@cdguzman.tecnm.mx">           
           </div>
           <div class="btnCOUC">
            <input type="hidden" name="tipoForm" value="correo">
                <input type="submit" value="Buscar Usuario">
            </div>
        </form>

        <div class="correo" id="correo"><?php
            if ($_SERVER['REQUEST_METHOD']==="POST" && $_POST['tipoForm']=="correo") {
                //Obtengo los datos del form de consultar usuario por correo
                $email = $_POST['emailS']?? null;;
                $email = "".trim($email)."@cdguzman.tecnm.mx";
                $query = "SELECT * FROM users";
                $resultado = mysqli_query($db, $query);
                while($usuario = mysqli_fetch_assoc($resultado)){//Comprueba si existe el email en la BD
                    if( $email == $usuario['email']) {
                        $ban = true;
                        //Aquí va el envia el codigo a los inputs
                        $queryDatos= "SELECT u.email, u.nomUsuario, u.apellidoUsuario, u.edoUser, u.telefono, u.idDpto, r.nomRole FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole WHERE u.email = '$email'";
                        $resultadoDatos =mysqli_query($db, $queryDatos);//Se obtienen los datos del usuario de usuarios y roles
                        $row = mysqli_fetch_assoc($resultadoDatos);//Toma los datos de usuarios y roles

                        $queryDpto = "SELECT nomDpto FROM departamentos WHERE idDpto = $row[idDpto]";
                        $resultadoDpto = mysqli_query($db, $queryDpto);
                        $row2 = mysqli_fetch_assoc($resultadoDpto);//Toma los datos de accesos y departamentos

                        echo ('
                        <div class="email">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" value = "'.$row["email"].'" disabled>           
                        </div>');
                        echo('
                        <div class="nombreUser">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value = "'.$row["nomUsuario"]." ".$row["apellidoUsuario"].'" disabled>           
                        </div>');
                        echo('
                        <div class="telefono">
                            <label for="telefono">Teléfono de Usuario</label>
                            <input type="text" name="telefono" id="telefono" value = "'.$row["telefono"].'" disabled>           
                        </div>');
                        echo('
                        <div class="departamento">
                            <label for="departamento">Departamento</label>
                                <input type="text" name="departamento" id="departamento" value = "'.$row2["nomDpto"].'" disabled>           
                        </div>');
                        echo('
                        <div class="rolUsuario">
                            <label for="rolUsuario">Rol de Usuario</label>
                            <input type="text" name="rolUsuario" id="rolUsuario" value = "'.$row["nomRole"].'" disabled>           
                        </div>');
                        echo('
                        <div class="edoUsuario">
                            <label for="edoUsuario">Estado de Usuario</label>
                            <input type="text" name="edoUsuario" id="rolUsuario" value = "'.$row["edoUser"].'" disabled>           
                        </div>');
                        break;
                    }else{
                        $ban = false;
                    }
                }
            }?>
        </div>
        <div id = "general">
            <div class = "container-table2">
                <?php  
                    $queryDpto1 ="SELECT * FROM departamentos ORDER BY nomDpto ASC";
                    $resultadoDpto1 = mysqli_query($db, $queryDpto1);
                    while($row3 = mysqli_fetch_assoc($resultadoDpto1)){
                        echo ('<div class="table__title">');
                        echo ($row3 ["nomDpto"]);
                        echo ('</div>');
                        echo ('<div class="table__header">Email</div>');
                        echo ('<div class="table__header">Nombre</div>');
                        echo ('<div class="table__header">Teléfono</div>');
                        echo ('<div class="table__header">Rol</div>');
                        echo ('<div class="table__header">Estado</div>');
                        $queryDpto2 = ("SELECT u.edoUser, u.email, u.nomUsuario, u.apellidoUsuario, u.telefono, r.nomRole FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole INNER JOIN departamentos as d ON d.idDpto = u.idDpto WHERE d.idDpto = $row3[idDpto] ORDER BY u.apellidoUsuario DESC"); 
                        $resultadoDpto2 =mysqli_query($db, $queryDpto2);
                        while($row4 = mysqli_fetch_assoc($resultadoDpto2)){
                            if($row4['email']) { 
                                echo ('<div class="table__item">'.$row4["email"].'</div>');
                                echo ('<div class="table__item">'.$row4["nomUsuario"]." ".$row4["apellidoUsuario"].'</div>');
                                echo ('<div class="table__item">'.$row4["telefono"].'</div>');
                                echo ('<div class="table__item">'.$row4["nomRole"].'</div>');
                                echo ('<div class="table__item">'.$row4["edoUser"].'</div>');
                                $ban = true;
                            }else{
                                $ban = false;
                            }
                        }
                        echo "<br>";
                    }

                ?>
            </div>
        </div>

        <div class="departamento">
            <div class = "container-table">
            <?php if ($_SERVER['REQUEST_METHOD']=="POST" && $_POST['tipoForm']=="departamento") {          
                    $departamento =$_POST['departamento'];
                    $queryDpto1 ="SELECT nomDpto FROM departamentos WHERE idDpto = $departamento";
                    $resultadoDpto1 = mysqli_query($db, $queryDpto1);
                        
                    while($row3 = mysqli_fetch_assoc($resultadoDpto1)){
                        echo ('<div class="table__title">');
                        echo ($row3 ["nomDpto"]);
                        echo ('</div>');
                    }
                    echo ('<div class="table__header">Email</div>');
                    echo ('<div class="table__header">Nombre</div>');
                    echo ('<div class="table__header">Teléfono</div>');
                    echo ('<div class="table__header">Rol</div>');
                    echo ('<div class="table__header">Estado</div>');

                    $queryDpto2 = ("SELECT u.edoUser, u.email, u.nomUsuario, u.apellidoUsuario, u.telefono, r.nomRole FROM users as u INNER JOIN roles as r ON u.idRole = r.idRole INNER JOIN departamentos as d ON d.idDpto = u.idDpto WHERE d.idDpto = $departamento ORDER BY u.apellidoUsuario DESC");                       
                    $resultadoDpto2 =mysqli_query($db, $queryDpto2);
                    while($row4 = mysqli_fetch_assoc($resultadoDpto2)){
                        if($row4['email']) { 
                            echo ('<div class="table__item">'.$row4["email"].'</div>');
                            echo ('<div class="table__item">'.$row4["nomUsuario"]." ".$row4["apellidoUsuario"].'</div>');
                            echo ('<div class="table__item">'.$row4["telefono"].'</div>');
                            echo ('<div class="table__item">'.$row4["nomRole"].'</div>');
                            echo ('<div class="table__item">'.$row4["edoUser"].'</div>');
                            $ban = true;
                        }else{
                            $ban = false;
                        }
                    }
                }?>
            </div>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true && $_POST['tipoForm']=="correo") {
        echo "<script>exito('Usuario Encontrado');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false && $_POST['tipoForm']=="correo"){
        echo "<script>fracaso('Error! El email no existe');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == true && $_POST['tipoForm']=="departamento"){
        echo "<script>exito('Usuarios Encontrados');</script>";
    }elseif($_SERVER['REQUEST_METHOD'] === "POST" && $ban == false && $_POST['tipoForm']=="departamento"){
        echo "<script>fracaso('Error! No hay usuarios registrados');</script>";
    }
?>