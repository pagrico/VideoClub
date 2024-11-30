<?php
include_once "Soporte.php";

class CintaVideo extends Soporte {
    private $duracion;

    // Constructor: hereda de Soporte y añade la duración
    public function __construct($titulo, $numero, $precio, $duracion) {
        parent::__construct($titulo, $numero, $precio); // Llamada al constructor de la clase padre
        $this->duracion = $duracion;
    }

    // Getter para la duración
    public function getDuracion(): int {
        return $this->duracion;
    }

    // Setter para la duración
    public function setDuracion(int $duracion): void {
        $this->duracion = $duracion;
    }

    // Método para mostrar un resumen de la cinta de video
    public function muestraResumen(): void {
        // Se muestra el resumen heredado y luego la duración
        echo "<br>" . parent::muestraResumen() . " | Duración: $this->duracion minutos";
    }
}
?>
