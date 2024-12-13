<?php
require_once("vendor/autoload.php");
use app\ProyectoVideoclub\Videoclub;
session_start();

// Obtenemos el cliente actual desde la sesión
$vc = $_SESSION["video"];
$clienteActual = null;

// Buscamos el cliente en la lista para actualizarlo
foreach ($vc->getClientes() as $cliente) {
    if ($cliente->getuser() === $_SESSION["user"]) {
        $clienteActual = $cliente;
        break;
    }
}

// Procesamos el formulario solo si se ha enviado
$error = null;
$mensaje = null;

// Comprobamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos y procesamos los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $numero = trim($_POST['numero'] ?? '');

    // Validación de los campos
    if (empty($nombre) || empty($usuario) || empty($password) || empty($numero)) {
        // Redirigimos con el mensaje de error utilizando el método GET
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=Todos%20los%20campos%20son%20obligatorios.");
        exit;
    } elseif (!is_numeric($numero) || (int) $numero <= 0) {
        // Redirigimos con el mensaje de error utilizando el método GET
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=El%20campo%20'n%C3%BAmero%20de%20alquileres%20m%C3%A1ximos'%20debe%20ser%20un%20n%C3%BAmero%20positivo.");
        exit;
    } else {
        // Si no hay errores, actualizamos los datos del cliente
        $clienteActual->setNombre($nombre);
        $clienteActual->setUser($usuario);
        $clienteActual->setPassword($password);
        $clienteActual->setMaxAlquilerConcurrente((int) $numero);

        // Guardamos el videoclub actualizado en la sesión
        $_SESSION["video"] = $vc;

        // Redirigimos con un mensaje de éxito
        header("Location: " . $_SERVER['PHP_SELF'] . "?mensaje=Datos%20actualizados%20correctamente.");
        exit;
    }
}

// Obtenemos los posibles mensajes de error o éxito desde la URL
$error = $_GET['error'] ?? null;
$mensaje = $_GET['mensaje'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <div class="max-w-md mx-auto" style="margin-top:7%">

        <!-- Mostrar mensajes de error o éxito si están presentes en los parámetros GET -->
        <?php if (!empty($error)): ?>
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($mensaje)): ?>
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                <?= htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para actualizar los datos del cliente -->
        <form method="POST">
            <!-- Campo Nombre -->
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="nombre" id="nombre"
                    value="<?= htmlspecialchars($clienteActual?->getNombre() ?? ''); ?>"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="nombre"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
            </div>

            <!-- Campo Número de Alquileres Máximos -->
            <div class="relative z-0 w-full mb-5 group">
                <input type="number" name="numero" id="numero"
                    value="<?= htmlspecialchars($clienteActual?->getMaxAlquilerConcurrente() ?? ''); ?>"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="numero"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Número
                    de Alquileres Máximos</label>
            </div>

            <!-- Campo Usuario -->
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="usuario" id="usuario"
                    value="<?= htmlspecialchars($clienteActual?->getUser() ?? ''); ?>"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="usuario"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Usuario</label>
            </div>

            <!-- Campo Contraseña -->
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="password" id="password"
                    value="<?= htmlspecialchars($clienteActual?->getPassword() ?? ''); ?>"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="password"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Contraseña</label>
            </div>

            <!-- Botón Actualizar -->
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Actualizar
            </button>
            <!-- Botón Volver -->
            <a href="mainCliente.php"
                class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                Volver
            </a>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>