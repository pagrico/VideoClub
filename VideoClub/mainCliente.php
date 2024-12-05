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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <div data-dial-init class="fixed bottom-6 end-6 group">
        <!-- Menú de botones flotantes -->
        <div id="speed-dial-menu-default" class="flex flex-col items-center hidden mb-4 space-y-2">
            <!-- Botón para actualizar usuario -->
            <form action="formUpdateCliente.php" method="POST">
                <button type="submit" data-tooltip-target="tooltip-add" data-tooltip-placement="left"
                    class="flex justify-center items-center w-12 h-12 text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 shadow-sm dark:border-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M10 5V15M5 10H15" stroke="#000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">Actualizar Usuario</span>
                </button>
            </form>
            <div id="tooltip-add" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity tooltip dark:bg-gray-700">
                Actualizar Usuario
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>

        <!-- Botón flotante principal -->
        <button type="button" data-dial-toggle="speed-dial-menu-default" aria-controls="speed-dial-menu-default"
            aria-expanded="false"
            class="flex items-center justify-center w-14 h-14 text-white bg-blue-700 rounded-full shadow-lg hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-45" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 18">
                <path d="M9 1v16M1 9h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            <span class="sr-only">Abrir menú</span>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>