<?php

class Videoclub {
    private $nombre;
    private $productos = []; // Array de soportes
    private $numProductos = 0;
    private $socios = []; // Array de clientes
    private $numSocios = 0;

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

    // Método para incluir un socio
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3) {
        $socio = [
            'nombre' => $nombre,
            'maxAlquileresConcurrentes' => $maxAlquileresConcurrentes,
            'alquileres' => [] // Array de productos alquilados
        ];
        $this->socios[] = $socio;
        $this->numSocios++;
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

    // Método para listar socios
    public function listarSocios() {
        echo "Socios registrados en '$this->nombre':<br>";
        foreach ($this->socios as $index => $socio) {
            echo "[$index] {$socio['nombre']} - Alquileres: " . count($socio['alquileres']) . "<br>";
        }
        return $this; // Retorna $this para encadenamiento
    }

    // Método para alquilar un producto a un socio
    public function alquilarSocioProducto($numeroCliente, $numeroSoporte) {
        // Validar si el índice del socio y producto existen
        if (!isset($this->socios[$numeroCliente]) || !isset($this->productos[$numeroSoporte])) {
            echo "Error: socio o producto no encontrado.<br>";
            return $this; // Retorna $this para encadenamiento
        }

        $socio = &$this->socios[$numeroCliente];
        $producto = &$this->productos[$numeroSoporte];

        // Verificar si el producto ya está alquilado
        if ($producto['alquilado']) {
            echo "El producto '{$producto['titulo']}' ya está alquilado.<br>";
            return $this;
        }

        // Verificar si el socio tiene el número máximo de alquileres
        if (count($socio['alquileres']) >= $socio['maxAlquileresConcurrentes']) {
            echo "El socio '{$socio['nombre']}' ha alcanzado el límite de alquileres concurrentes.<br>";
            return $this;
        }

        // Realizar el alquiler
        $producto['alquilado'] = true;
        $socio['alquileres'][] = $numeroSoporte;

        echo "El socio '{$socio['nombre']}' alquiló el producto '{$producto['titulo']}'.<br>";
        return $this; // Retorna $this para encadenamiento
    }
}
?>
