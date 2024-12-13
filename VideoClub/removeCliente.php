<?php
require_once("vendor/autoload.php");
use app\ProyectoVideoclub\Videoclub;
session_start();

$vc = $_SESSION["video"];

// Manejo de solicitudes POST para eliminar un cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $vc->eliminarCliente($id); // Método que elimina al cliente por ID
    $mensaje = "El cliente con ID $id ha sido eliminado correctamente.";
    header("Location: mainAdmin.php");
}

// Obtener la lista de clientes para mostrar
$clientes = $vc->getClientes();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Incluimos TailwindCSS -->
</head>

<body>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Lista de Clientes</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                <?= htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <table class="min-w-full border-collapse border border-gray-200">
            <thead>
                <tr>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        ID
                    </th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        Nombre
                    </th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-700">
                            <?= htmlspecialchars($cliente->getNumero()); ?>
                        </td>
                        <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-700">
                            <?= htmlspecialchars($cliente->getNombre()); ?>
                        </td>
                        <td class="px-6 py-4 border-b border-gray-200 text-sm">
                            <form method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($cliente->getNumero()); ?>">
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>