<?php
include_once "Resumible.php"; // Incluir la interfaz Resumible

class Soporte implements Resumible {
    public $titulo;
    protected $numero;
    private $precio;

    public function __construct(string $titulo, int $numero, float $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function getNumero(): int {
        return $this->numero;
    }

    public function getPrecio(): float {
        return $this->precio;
    }

    public function getPrecioConIVA(): float {
        return $this->precio * 1.21;
    }

    // Implementación del método muestraResumen() de la interfaz Resumible
    public function muestraResumen(): void {
        echo "<br>Titulo: $this->titulo, <br>Precio: $this->precio, <br>Precio IVA incluido: " . $this->getPrecioConIVA() . "<br>";
    }

    public function __toString(): string {
        return "Titulo: $this->titulo, Numero: $this->numero, Precio: $this->precio";
    }
}
?>
