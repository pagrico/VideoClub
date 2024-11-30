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
        $this->incluirProducto($cinta);
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
        $this->incluirProducto($dvd);
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
        $this->incluirProducto($juego);
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
    }

    // Método para listar productos
    public function listarProductos() {
        foreach ($this->productos as $producto) {
            echo $producto['titulo'] . " - " . ($producto['alquilado'] ? 'Alquilado' : 'Disponible') . "<br>";
        }
    }

    // Método para listar socios
    public function listarSocios() {
        foreach ($this->socios as $socio) {
            echo $socio['nombre'] . " - Alquileres: " . count($socio['alquileres']) . "<br>";
        }
    }

    // Método para alquilar un producto a un socio
    public function alquilarSocioProducto($numeroCliente, $numeroSoporte) {
        // Validar si el índice del socio y producto existen
        if (!isset($this->socios[$numeroCliente]) || !isset($this->productos[$numeroSoporte])) {
            echo "Error: socio o producto no encontrado.<br>";
            return;
        }

        $socio = &$this->socios[$numeroCliente];
        $producto = &$this->productos[$numeroSoporte];

        // Verificar si el producto ya está alquilado
        if ($producto['alquilado']) {
            echo "El producto '{$producto['titulo']}' ya está alquilado.<br>";
            return;
        }

        // Verificar si el socio tiene el número máximo de alquileres
        if (count($socio['alquileres']) >= $socio['maxAlquileresConcurrentes']) {
            echo "El socio '{$socio['nombre']}' ha alcanzado el límite de alquileres concurrentes.<br>";
            return;
        }

        // Verificar si el socio ya tiene alquilado el mismo producto
        if (in_array($numeroSoporte, $socio['alquileres'])) {
            echo "El socio '{$socio['nombre']}' ya tiene alquilado el producto '{$producto['titulo']}'.<br>";
            return;
        }

        // Realizar el alquiler
        $producto['alquilado'] = true;
        $socio['alquileres'][] = $numeroSoporte;

        echo "El socio '{$socio['nombre']}' alquiló el producto '{$producto['titulo']}'.<br>";
    }
}

