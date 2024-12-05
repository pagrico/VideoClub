<?php
include_once "app/ProyectoVideoclub/Videoclub.php";
include_once "app/ProyectoVideoclub/Cliente.php";
session_start();

if (isset($_POST["nombre"]) && isset($_POST["usuario"]) && isset($_POST["password"]) && isset($_POST["numero"])) {
    $vc = $_SESSION["video"];
    $vc->incluirSocio($_POST["nombre"], $_POST["numero"]);
    $vc->userPassword(count($vc->getclientes()), $_POST["usuario"], $_POST["password"]);
    header("Location: mainAdmin.php");
}

?>