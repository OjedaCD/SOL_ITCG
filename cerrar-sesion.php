<?php

session_start();

$_SESSION = [];
//Manda un parametro vacío y se cierra la sesión
header('Location: /sol_itcg/');
//Vuelve a la página principal
