<?php

ob_start(); // Inicia el almacenamiento en búfer de salida
session_start(); // Inicia o reanuda la sesión
include_once "app/ProyectoVideoclub/Videoclub.php";
include_once "app/ProyectoVideoclub/Cliente.php";



// Simulación de usuarios y contraseñas (puedes reemplazar esto con una base de datos en el futuro)


//inicio3.php


$vc = new Videoclub("Severo 8A");

//voy a incluir unos cuantos soportes de prueba 
$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1);
$vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);
$vc->incluirDvd("Torrente", 4.5, "es", "16:9");
$vc->incluirDvd("Origen", 4.5, "es,en,fr", "16:9");
$vc->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9");
$vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107);
$vc->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);
$vc->incluirJuego("Fornite", 0, "PC", 1, 100);

//listo los productos 



$vc->incluirSocio("Amancio Ortega");
$vc->incluirSocio("Pablo Picasso", 2);
$vc->incluirSocio("Admin");
$vc->userPassword(3, "admin", "admin");
$vc->userPassword(1, "Cliente", "1234");


$vc->alquilaSocioProducto(1, 2);
$vc->alquilaSocioProducto(1, 3);
//alquilo otra vez el soporte 2 al socio 1. 
// no debe dejarme porque ya lo tiene alquilado 
$vc->alquilaSocioProducto(1, 2);
//alquilo el soporte 6 al socio 1. 
//no se puede porque el socio 1 tiene 2 alquileres como máximo 
$vc->alquilaSocioProducto(1, 6);

$vc->alquilaSocioProducto(2, 7);
$_SESSION["video"] = $vc; // Guardar el usuario en la sesión

//listo los socios 

$usuarios = [];
foreach ($vc->getClientes() as $value) {
    $usuarios[$value->getuser()] = $value->getpassword();
}

// Obtener los datos del formulario
$user = $_POST["user"] ?? null;
$password = $_POST["password"] ?? null;

// Verificar si el usuario y contraseña son correctos
if ($user !== null && $password !== null) {
    if (array_key_exists($user, $usuarios) && $usuarios[$user] === $password) {
        correcto($user); // Llamar a la función de redirección según el rol
    } else {
        denegado(); // Llamar a la función de acceso denegado
    }
} else {
    // En caso de datos incompletos
    denegado();
}

// Función para redirigir al usuario según su rol
function correcto($user)
{
    // Asegúrate de iniciar la sesión
    $_SESSION["user"] = $user; // Guardar el usuario en la sesión

    if ($user === "admin") {
        header("Location: mainAdmin.php");
    } else {
        header("Location: mainCliente.php");
    }
    exit; // Detener la ejecución del script después de redirigir
}


// Función para manejar el acceso denegado
function denegado()
{
    header("Location: index.php?error=error"); // Redirigir al login con un mensaje de error
    exit; // Detener la ejecución del script después de redirigir
}
?>