<?php
class Dvd extends Soporte {
    protected $idioma;
    private $formatPantalla;

    public function __construct(string $titulo, int $numero, float $precio, string $idioma, string $formatPantalla) {
        parent::__construct($titulo, $numero, $precio);
        $this->idioma = $idioma;
        $this->formatPantalla = $formatPantalla;
    }

    // Sobreescribir el método muestraResumen si se desea una implementación diferente
    public function muestraResumen(): void {
        parent::muestraResumen(); // Llamar al método de la clase base
        echo "Idioma: $this->idioma, <br>Formato Pantalla: $this->formatPantalla<br>";
    }
}
?>
