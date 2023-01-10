<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    inlcuirTemplate('header');
    $db = conectarDB();

    $ban = null;
    $queryDep ="SELECT * FROM departamentos ORDER BY nomDpto";//Query para mostrar la el select con los departamentos
    $resultadoDep= mysqli_query($db, $queryDep);

?>
<main class="DatosUsuario">
    <section class="w80">
        <h1>Datos de Usuario</h1>
        <div class="correo" id="correo"><?php
            //Obtengo los datos del form de consultar usuario por correo
            $email = $_SESSION['email'];
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
                    
                }
            }?>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>