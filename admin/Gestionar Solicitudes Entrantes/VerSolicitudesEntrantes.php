<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    $db =conectarDB();

    $queryDep ="SELECT * FROM departamentos WHERE idDpto = 20 OR idDpto = 21";
    $resultadoDep= mysqli_query($db, $queryDep);
    
?>
<main class="VerSolicitudesEntrantes">
    <section class="w80">
        <h1>Ver Solicitudes Entrantes</h1>
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
           <div class="btnBus">
                <input type="submit" value="Ver Solicitudes">
            </div>
            <input type="hidden" name="tipoForm" value="bandera">
        </form>

        <?php
        //necesito 
            if($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['tipoForm'])){
                $area = $_GET['area']?? null;;
                $query ="SELECT * FROM solicitudes WHERE idDpto = $area";
                $resultado = mysqli_query($db, $query);
                

                echo('
                <table class="tabla">
                <tr>
                    <th>DEPARTAMENTO</th>
                    <th>NOMBRE</th>
                    <th>FECHA DE ENVÍO</th>
                    <th>ESTADO</th>
                    <th>DETALLES</th>
                </tr>'); 
                while ($row = mysqli_fetch_array($resultado)){
                    $queryId ="SELECT u.nomUsuario, u.apellidoUsuario FROM users as u
                    INNER JOIN solicitudes as s ON u.idUser = s.idUser WHERE s.idUser = $row[idUser]";//Selecciono el id del usurio
                    $resultadoId = mysqli_query($db, $queryId);
                    $row2 = mysqli_fetch_array($resultadoId);

                    $queryDpto ="SELECT d.nomDpto FROM departamentos as d
                    INNER JOIN users as u ON u.idDpto = d.idDpto WHERE u.idUser = $row[idUser]";//Selecciono el id del usurio
                    $resultadoDpto = mysqli_query($db, $queryDpto);
                    $row3 = mysqli_fetch_array($resultadoDpto);

                    echo('<form method="POST" action ="VerSolicitud.php">
                        <input name = "'.$row['folio'].'" type="hidden">
                        <tr>
                            <th>'.$row3['nomDpto'].'</th>
                            <th>'.$row2['nomUsuario'].$row2['apellidoUsuario'].'</th>
                            <th>'.$row['fecha'].'</th>
                            <th>'.$row['Estado'].'</th>
                            
                            <th><input type="submit" value="Ver detalles"></th>
                            
                        </tr>
                    </form>');
                }
                echo('</table>');

            }else{
                $ban = false;
            }

        ?>
    </section>
</main>

<?php 
    inlcuirTemplate('footer');
?>

