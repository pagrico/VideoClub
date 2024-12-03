<?php
include_once "app/ProyectoVideoclub/Videoclub.php";
include_once "app/ProyectoVideoclub/Cliente.php";

session_start();



// Validar sesión
if (!isset($_SESSION["video"])) {
    die("Error: No se encontró el objeto Videoclub en la sesión.");
}

// Restaurar objeto de la sesión
$vc = $_SESSION["video"];

if (!($vc instanceof Videoclub)) {
    die("Error: El objeto en la sesión no es de la clase Videoclub.");
}

// Mostrar información
echo "Hola de nuevo, " . htmlspecialchars($_SESSION["user"]) . "<br>";
$vc->listarSocios();
$vc->listarProductos();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

</head>

<body>
    <div data-dial-init class="fixed end-6 bottom-6 group">
        <div id="speed-dial-menu-default" class="flex flex-col items-center hidden mb-4 space-y-2">
            <!-- Botón de añadir cliente -->
            <form action="formCreateCliente.php" method="POST">
                <button type="submit" data-tooltip-target="tooltip-add" data-tooltip-placement="left"
                    class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M10 5V15M5 10H15" stroke="#000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">Add Client</span>
                </button>
            </form>
            <div id="tooltip-add" role="tooltip"
                class="absolute z-10 invisible inline-block w-auto px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Add Client
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <!-- Botón de eliminar cliente -->
            <form action="eliminar_cliente.php" method="POST">
                <button type="submit" data-tooltip-target="tooltip-delete" data-tooltip-placement="left"
                    class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M6 18L14 6M6 6l8 12" stroke="#000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">Delete Client</span>
                </button>
            </form>
            <div id="tooltip-delete" role="tooltip"
                class="absolute z-10 invisible inline-block w-auto px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Delete Client
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>

        <!-- Botón flotante principal para abrir las opciones -->
        <button type="button" data-dial-toggle="speed-dial-menu-default" aria-controls="speed-dial-menu-default"
            aria-expanded="false"
            class="flex items-center justify-center text-white bg-blue-700 rounded-full w-14 h-14 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-45" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
            <span class="sr-only">Open actions menu</span>
        </button>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>


</html>