<?php
include_once "app/ProyectoVideoclub/Videoclub.php";
include_once "app/ProyectoVideoclub/Cliente.php";


session_start();

echo ("Hola de nuevo " . $_SESSION["user"] . "<br>");
$vc = $_SESSION["video"];
foreach ($vc->getClientes() as $cliente) {
    $cliente->getuser() === $_SESSION["user"] ? muestraProductos($cliente) : null;
}
function muestraProductos($cliente)
{
    $cliente->listaAlquileres();
} {

}

?>