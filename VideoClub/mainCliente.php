<?php
    session_start();
    include_once "app/ProyectoVideoclub/Videoclub.php"; 
    echo("Hola de nuevo " . $_SESSION["user"] . "<br>");

    
    ?>