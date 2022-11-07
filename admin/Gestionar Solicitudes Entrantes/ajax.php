<?php
require "../../includes/config/database.php";

    if (isset($_POST['update'])) {
        foreach($_POST['positions'] as $position) {
           $index = $position[0];
           $newPosition = $position[1];

          $UpdatePosition = ("UPDATE drag_drop SET posicion = '$newPosition' WHERE id='$index' ");
          $result = mysqli_query($db, $UpdatePosition);
          print_r($UpdatePosition);


        }
    }
?>

