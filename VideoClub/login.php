<?php
session_start(); // Inicia o reanuda la sesión

// Simulación de usuarios y contraseñas (puedes reemplazar esto con una base de datos en el futuro)
$usuarios = [
    "admin" => "admin123",  // Usuario administrador
    "cliente1" => "cliente123",
    "cliente2" => "clave456"
];

// Obtener los datos del formulario
$user = $_POST["user"] ?? null;
$password = $_POST["password"] ?? null;

// Verificar si el usuario y contraseña son correctos
if ($user !== null && $password !== null) {
    if (array_key_exists($user, $usuarios) && $usuarios[$user] === $password) {
        correcto($user); // Llamar a la función de acceso permitido
    } else {
        denegado(); // Llamar a la función de acceso denegado
    }
} else {
    // En caso de datos incompletos
    denegado();
}

// Función para redirigir al usuario según su rol
function correcto($user) {
    $_SESSION["user"] = $user; // Guardar el usuario en la sesión
    if ($user === "admin") {
        header("Location: mainAdmin.php");
    } else {
        header("Location: mainCliente.php");
    }
    exit; // Detener la ejecución del script después de redirigir
}

// Función para manejar el acceso denegado
function denegado() {
    header("Location: index.php?error=error"); // Redirigir al login con un mensaje de error
    exit; // Detener la ejecución del script después de redirigir
}
?>
