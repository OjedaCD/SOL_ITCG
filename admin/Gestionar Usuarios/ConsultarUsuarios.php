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

    $queryDep ="SELECT * FROM departamentos";//Query para mostrar la el select con los departamentos
    $resultadoDep= mysqli_query($db, $queryDep);
?>
<main class="ConsultarUsuario">
    <section class="w80">
        <h1>Consultar Usuarios</h1>
        <div class="btnsLista">
            <input type="button" onclick="mostrarContenido();" value="Consultar usuarios por departamento" class="btnChoseD">
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
            </div>
            <div class="COU">
                <input type="submit" value="Buscar" name="btnCOU" id="btnCOU">
            </div>
            
        </form>

        <form method="POST" id="content2" class="content2">
            <!--Dependiendo de la opción mostrada y el input hidden aquí presento o el usuario o la lista-->
            <div class="COU">
                <input type="submit" value="Buscar" name="btnCOU" id="btnCOU">
            </div>
        </form>


    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>