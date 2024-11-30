<?php
include_once "Cliente.php"; // Asegúrate de incluir la clase Cliente

class Videoclub {
    private $nombre;
    private $productos = []; // Array de soportes
    private $numProductos = 0;
    private $clientes = []; // Array de clientes (ahora objetos de Cliente)
    private $numClientes = 0;

    // Constructor
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    // Método privado para incluir un producto
    private function incluirProducto($producto) {
        $this->productos[] = $producto;
        $this->numProductos++;
        return $this; // Retorna $this para encadenamiento
    }

    // Métodos públicos para incluir soportes específicos
    public function incluirCintaVideo($titulo, $precio, $duracion) {
        $cinta = [
            'tipo' => 'CintaVideo',
            'titulo' => $titulo,
            'precio' => $precio,
            'duracion' => $duracion,
            'alquilado' => false, // estado de alquiler
        ];
        return $this->incluirProducto($cinta);
    }

    public function incluirDvd($titulo, $precio, $idiomas, $pantalla) {
        $dvd = [
            'tipo' => 'Dvd',
            'titulo' => $titulo,
            'precio' => $precio,
            'idiomas' => $idiomas,
            'pantalla' => $pantalla,
            'alquilado' => false, // estado de alquiler
        ];
        return $this->incluirProducto($dvd);
    }

    public function incluirJuego($titulo, $precio, $consola, $minJugadores, $maxJugadores) {
        $juego = [
            'tipo' => 'Juego',
            'titulo' => $titulo,
            'precio' => $precio,
            'consola' => $consola,
            'minJugadores' => $minJugadores,
            'maxJugadores' => $maxJugadores,
            'alquilado' => false, // estado de alquiler
        ];
        return $this->incluirProducto($juego);
    }

    // Método para incluir un cliente
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3) {
        $cliente = new Cliente($nombre, $maxAlquileresConcurrentes);
        $this->clientes[] = $cliente;
        $this->numClientes++;
        return $this; // Retorna $this para encadenamiento
    }

    // Método para listar productos
    public function listarProductos() {
        echo "Productos disponibles en '$this->nombre':<br>";
        foreach ($this->productos as $index => $producto) {
            echo "[$index] {$producto['titulo']} ({$producto['tipo']}) - " . 
                ($producto['alquilado'] ? 'Alquilado' : 'Disponible') . "<br>";
        }
        return $this; // Retorna $this para encadenamiento
    }

    // Método para listar clientes
    public function listarSocios() {
        echo "Clientes registrados en '$this->nombre':<br>";
        foreach ($this->clientes as $cliente) {
            echo $cliente . "<br>"; // Usando el método __toString de Cliente
        }
        return $this; // Retorna $this para encadenamiento
    }

    // Método para alquilar un producto a un cliente
    public function alquilaSocioProducto($numeroCliente, $numeroSoporte) {
        // Verificar que el índice del cliente existe
        if (!isset($this->clientes[$numeroCliente])) {
            echo "Error: El cliente con índice $numeroCliente no existe.<br>";
            return $this;
        }
    
        // Verificar que el índice del producto existe
        if (!isset($this->productos[$numeroSoporte])) {
            echo "Error: El producto con índice $numeroSoporte no existe.<br>";
            return $this;
        }
    
        $cliente = &$this->clientes[$numeroCliente]; // Referencia al cliente
        $producto = &$this->productos[$numeroSoporte]; // Referencia al producto
    
        // Verificar si el producto ya está alquilado
        if ($producto['alquilado']) {
            echo "El producto '{$producto['titulo']}' ya está alquilado.<br>";
            return $this;
        }
    
        // Verificar si el cliente ha alcanzado el límite de alquileres concurrentes
        if ($cliente->getNumSoportesAlquilados() >= $cliente->getmaxAlquilerConcurrente()) {
            echo "El cliente '{$cliente->nombre}' ha alcanzado el límite de alquileres concurrentes.<br>";
            return $this;
        }
    
        // Realizar el alquiler
        $producto['alquilado'] = true;
        $cliente->alquilar($producto); // Usar el método alquilar del cliente para añadir el producto
    
        echo "El cliente '{$cliente->nombre}' alquiló el producto '{$producto['titulo']}'.<br>";
        return $this;
    }
    
}
?>
