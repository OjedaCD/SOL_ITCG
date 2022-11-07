<?php  
 require "../../includes/funciones.php";  $auth = estaAutenticado();
 require "../../includes/config/database.php";
 if (!$auth) {
    header('location: /'); die();
 }
 
 inlcuirTemplate('header');
 $db =conectarDB();

?>
<main class="TableroKanban">
    <section class="w80">
        <h1>Kanban</h1>
        <div class="KanbanContent">
            
            <div class="container top">
            <link href="/build/css/bootstrap.css" rel="stylesheet">
                <?php $Query = ("SELECT * FROM `solicitudes` WHERE Etapa = 'PENDIENTE' ORDER BY Prioridad ASC");
                $resultadodrag_drop  = mysqli_query($db, $Query);
                //aqui va la bd 
                ?>

                <div class="row sortable"  id="drop-items">
                <?php while ($dataDrag_Drop = mysqli_fetch_assoc($resultadodrag_drop)) { ?>
                    <div class="col-md-6 col-lg-4" data-index="<?php echo $dataDrag_Drop['idSolicitud']; ?>" data-position="<?php echo $dataDrag_Drop['posicion']; ?>">
                        <div class="drop__card">
                            <div class="drop__data">
                                <div>
                                    <h1 class="drop__name"><?php echo $dataDrag_Drop['fecha']; ?></h1>
                                    <span class="drop__profession"><?php echo $dataDrag_Drop['descripcion']; ?></span>
                                </div>
                            </div>
           
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <script type="text/javascript" charset="utf-8" src="/build/js/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" charset="utf-8" src="/build/js/jquery-ui.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                $('.sortable').sortable({
                    update: function (event, ui) {
                        $(this).children().each(function (index) {
                                if ($(this).attr('data-position') != (index+1)) {
                                    $(this).attr('data-position', (index+1)).addClass('updated');
                                }
                        });
                        guardandoPosiciones();
                    }
                });
                });

                function guardandoPosiciones() {
                    var positions = [];
                    $('.updated').each(function () {
                    positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                    $(this).removeClass('updated');
                    });

                    $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        update: 1,
                        positions: positions
                    }, success: function (response) {
                            console.log(response);
                    }
                    });
                }
            </script>
        </div>
    </section>
</main>
<?php 
    inlcuirTemplate('footer');
?>