<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    if (!$auth) {
        header('location: /');
    }
    inlcuirTemplate('header');
    require "../../includes/config/database.php";//Dirección relativa donde se encuentra la conexion a la db
    $db =conectarDB();//Funcion dentro que permite la conexión
    $queryCar ="SELECT * FROM carreras";//Las variables empiezan por $ y pueden almacenar instrucciones SQL
    $queryMat ="SELECT * FROM materias";
    $queryGru ="SELECT * FROM grupos";

    $resultadoCar =mysqli_query($db, $queryCar);//mysqli_query necesita de un parametro para establecer la conexion y de otro 
    $resultadoMat =mysqli_query($db, $queryMat);//en forma de un query sql para interactuar con la db
    $resultadoGru =mysqli_query($db, $queryGru);

    $materia="";//variables de tipo cadena
    $carrera="";
    $grupo="";
    

    if ($_SERVER['REQUEST_METHOD']=="POST") {//$_SERVER es una variable para determinar si en el formulario se ha enviado algo
        $materia=$_POST['materiaS'];//Aquí identificamos la accion pulsada del formulario en base al id de la funcionalidad con la que se interctua
        $carrera=$_POST['carreraS'];//Dependeindo del select se mostrara un resultado u otro
        $grupo = $_POST['GrupoS'];
    }
?>
<main class="registrarCal">
    <section>
        <h1>Registrar Calificaciones</h1>
        <form method="POST"><!-- Se debe de poner el metodo post como si fuese un formulario-->
            <div class="linea">
                <div class="carrera">
                    <label for="">Selecciona Carrera</label>
                    <select name="carreraS" id="carreraS">
                        <option value="">--Seleccione Carrera--</option>  
                        <?php while($carrera = mysqli_fetch_assoc($resultadoCar)):?><!--como es son varias carreras se guarda la seleccionada en una variable -->
                            <option value="<?php echo $carrera['idCar'];?>"><!--la variable contiene referenciando a la db y el query que se esta realizando-->
                                <?php echo $carrera['nombcar'];?><!---para mostrar el resultado en pantalla se muestra en una etiqueta del mismo tipo-->
                            </option><!--con la impresion de la variable de la carrera dentro del while mediante el nombre del campo de la tabla-->
                            <!--cuando se selecciona una opcion se presenta el nombre en base a su id, primero se acede al id y despues al nombre-->
                        <?php endwhile;?>  
                    </select>
                </div>
                <div class="materia">
                    <label for="">Selecciona Materia</label>
                    <select name="materiaS" id="materiaS">
                        <option value="">--Seleccione Materia--</option>    
                        <?php while($materia = mysqli_fetch_assoc($resultadoMat)):?>
                            <option value="<?php echo $materia['idMateria'];?>"><!---El valor contiene el id de la materia que seleccionemos-->
                                <?php echo $materia['nombre_Mat'];?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>
                <div class="grupo">
                    <label for="">Grupo</label>
                    <select name="GrupoS" id="GrupoS">
                        <option value="">--Seleccione Grupo--</option>
                        <?php while($grupo = mysqli_fetch_assoc($resultadoGru)):?>
                            <option value="<?php echo $grupo['idGrupo'];?>">
                                <?php echo $grupo['letraGrupo'];?>
                            </option>
                        <?php endwhile;?>  
                    </select>
                </div>
                <input type="submit" value="Buscar" name="btnBuscarR">
                <?php       
                    
                    if(isset($_POST['carreraS'])){
                        $estado =$_POST ['carreraS'];
                        echo "
                        <table class = \"tabla\">
                        <tr>
                            <td>Ficha</td>
                            <td>Nombre</td>
                            <td>Calificación</td>
                        </tr>
                        <tr>
                            <td>".$estado."</td>
                        </tr>
                    </table>                    
                        ";

                    }//Tambien se pueden invocar los diseños scss pero php interpreta los "" como \"\"
                ?>
                
            </div>
        </form>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>