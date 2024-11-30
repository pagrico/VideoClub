<?php

class Soporte {
    public $titulo;          // Propiedad pública
    protected $numero;      // Propiedad protegida
    private $precio;        // Propiedad privada

    // Constructor con tipo de datos especificado para los parámetros
    public function __construct(string $titulo, int $numero, float $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    // Método getter para el título
    public function getTitulo(): string {
        return $this->titulo;
    }

    // Método getter para el número
    public function getNumero(): int {
        return $this->numero;
    }

    // Método getter para el precio
    public function getPrecio(): float {
        return $this->precio;
    }

    // Método para calcular el precio con IVA
    public function getPrecioConIVA(): float {
        return $this->precio * 1.21;
    }

    // Método para mostrar un resumen del soporte
    public function muestraResumen(): void {
        echo "<br>$this->titulo, <br>Precio: $this->precio<br>Precio con IVA incluido: " . $this->getPrecioConIVA();
    }

    // Método mágico __toString para representar el objeto como una cadena
    public function __toString(): string {
        return "Título: $this->titulo, Número: $this->numero, Precio: $this->precio";
    }
}

?>
