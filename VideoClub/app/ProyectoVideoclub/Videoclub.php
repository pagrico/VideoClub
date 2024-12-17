<?php
namespace app\ProyectoVideoclub;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Videoclub
{
    private $nombre;
    private $productos = []; // Array de soportes
    private $numProductos = 0;
    private $clientes = []; // Array de clientes (ahora objetos de Cliente)
    private $numClientes = 0;
    private $numProductosAlquilados;
    private $numTotalAlquileres;

    private $logger; // Logger de Monolog

    // Constructor
    public function __construct($nombre)
    {
        $this->nombre = $nombre;

        // Inicializar el logger
        $this->logger = new Logger('VideoclubLogger');
        $logPath = __DIR__ . '/logs/videoclub.log';
        $this->logger->pushHandler(new StreamHandler($logPath, Logger::DEBUG));

        $this->logger->info("Videoclub '$nombre' creado.");
    }

    // Método privado para incluir un producto
    private function incluirProducto(Soporte $producto): self
    {
        $this->productos[] = $producto;
        $this->logger->info("Producto incluido:", ['producto' => $producto]);
        return $this; // Retorna $this para encadenamiento
    }

    // Métodos públicos para incluir soportes específicos
    public function incluirCintaVideo($titulo, $precio, $duracion): self
    {
        $cinta = new CintaVideo($titulo, ++$this->numProductos, $precio, $duracion); // Crear objeto CintaVideo
        return $this->incluirProducto($cinta);
    }

    public function incluirDvd($titulo, $precio, $idiomas, $pantalla): self
    {
        $dvd = new Dvd($titulo, ++$this->numProductos, $precio, $idiomas, $pantalla); // Crear objeto Dvd
        return $this->incluirProducto($dvd);
    }

    public function incluirJuego($titulo, $precio, $consola, $minJugadores, $maxJugadores): self
    {
        $juego = new Juego($titulo, ++$this->numProductos, $precio, $consola, $minJugadores, $maxJugadores); // Crear objeto Juego
        return $this->incluirProducto($juego);
    }

    function prueba()
    {
        print_r($this->clientes);
    }

    // Método para incluir un cliente
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3)
    {
        $cliente = new Cliente($nombre, ++$this->numClientes, $maxAlquileresConcurrentes);
        $this->clientes[] = $cliente;
        $this->logger->info("Socio incluido:", ['cliente' => $cliente]);
        return $this; // Retorna $this para encadenamiento
    }

    // Método para listar productos
    public function listarProductos()
    {
        echo "Productos disponibles en '$this->nombre':<br>";
        foreach ($this->productos as $index => $producto) {
            $estado = $producto->getAlquilado() ? 'Alquilado' : 'Disponible';
            echo "[$index] {$producto->getTitulo()} - $estado<br>";
        }
        $this->logger->info("Listado de productos generado.");
        return $this; // Retorna $this para encadenamiento
    }

    // Método para listar clientes
    public function listarSocios()
    {
        echo "Clientes registrados en '$this->nombre':<br>";
        foreach ($this->clientes as $cliente) {
            echo $cliente . "<br>"; // Usando el método __toString de Cliente
        }
        $this->logger->info("Listado de clientes generado.");
        return $this; // Retorna $this para encadenamiento
    }

    // Método para alquilar un producto a un cliente
    public function alquilaSocioProducto(int $numSocio, ...$numerosProductos): void
    {
        if (!isset($this->clientes[$numSocio - 1])) {
            $this->logger->error("Error: El cliente con índice $numSocio no existe.");
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return;
        }

        $cliente = $this->clientes[$numSocio - 1];

        foreach ($numerosProductos as $numeroProducto) {
            if (!isset($this->productos[$numeroProducto])) {
                $this->logger->error("Error: El producto con índice $numeroProducto no existe.");
                echo "Error: El producto con índice $numeroProducto no existe.<br>";
                continue; // Cambiar 'return' por 'continue'
            }

            $producto = $this->productos[$numeroProducto];

            if ($producto->getAlquilado()) {
                $this->logger->warning("El producto ya está alquilado:", ['producto' => $producto]);
                echo "Error: El producto " . $producto->getTitulo() . " ya está alquilado.<br>";
                continue; // Cambiar 'return' por 'continue'
            }

            $cliente->alquilar($producto);
            $this->logger->info("Producto alquilado:", ['cliente' => $cliente, 'producto' => $producto]);
        }
    }

    public function devolverSocioProducto(int $numSocio, int $numeroProducto): self
    {
        if (!isset($this->clientes[$numSocio])) {
            $this->logger->error("Error: El cliente con índice $numSocio no existe.");
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return $this;
        }

        if (!isset($this->productos[$numeroProducto])) {
            $this->logger->error("Error: El producto con índice $numeroProducto no existe.");
            echo "Error: El producto con índice $numeroProducto no existe.<br>";
            return $this;
        }

        $cliente = &$this->clientes[$numSocio];
        $producto = &$this->productos[$numeroProducto];

        if (!$producto['alquilado']) {
            $this->logger->warning("Intento de devolver un producto no alquilado:", ['producto' => $producto]);
            echo "Error: El producto '{$producto['titulo']}' no está alquilado.<br>";
            return $this;
        }

        $producto['alquilado'] = false;
        $cliente->devolver($numeroProducto);

        $this->logger->info("Producto devuelto:", ['cliente' => $cliente, 'producto' => $producto]);
        echo "El cliente '{$cliente->nombre}' devolvió el producto '{$producto['titulo']}'.<br>";
        return $this;
    }

    public function devolverSocioProductos(int $numSocio, ...$numerosProductos): self
    {
        if (!isset($this->clientes[$numSocio])) {
            $this->logger->error("Error: El cliente con índice $numSocio no existe.");
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return $this;
        }

        $cliente = &$this->clientes[$numSocio];

        foreach ($numerosProductos as $numeroProducto) {
            if (!isset($this->productos[$numeroProducto])) {
                $this->logger->error("Error: El producto con índice $numeroProducto no existe.");
                echo "Error: El producto con índice $numeroProducto no existe.<br>";
                continue;
            }

            $producto = &$this->productos[$numeroProducto];

            if (!$producto['alquilado']) {
                $this->logger->warning("Intento de devolver un producto no alquilado:", ['producto' => $producto]);
                echo "Error: El producto '{$producto['titulo']}' no está alquilado.<br>";
                continue;
            }

            $producto['alquilado'] = false;
            $cliente->devolver($numeroProducto);

            $this->logger->info("Producto devuelto:", ['cliente' => $cliente, 'producto' => $producto]);
            echo "El cliente '{$cliente->nombre}' devolvió el producto '{$producto['titulo']}'.<br>";
        }

        return $this;
    }

    public function getClientes()
    {
        return $this->clientes;
    }

    public function userPassword(int $numSocio, $user, $password): void
    {
        if (!isset($this->clientes[$numSocio - 1])) {
            $this->logger->error("Error: El cliente con índice $numSocio no existe.");
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return;
        }

        $cliente = $this->clientes[$numSocio - 1];

        $cliente->setuser($user);
        $cliente->setpassword($password);
        $this->logger->info("Usuario y contraseña configurados:", ['cliente' => $cliente]);
    }

    public function eliminarCliente(int $id): void
    {
        foreach ($this->clientes as $key => $cliente) {
            if ($cliente->getNumero() === $id) {
                unset($this->clientes[$key]);
                $this->clientes = array_values($this->clientes);
                $this->logger->info("Cliente eliminado:", ['cliente' => $id]);
                return;
            }
        }

        $this->logger->error("Error: Cliente con ID $id no encontrado.");
        throw new Exception("Cliente con ID $id no encontrado.");
    }
}
