<?php
include_once "Soporte.php";

class Dvd extends Soporte {
    protected $idioma;              // Propiedad protegida, puede ser accesible desde clases hijas
    private $formatPantalla;        // Propiedad privada

    // Constructor con tipos especificados para los parámetros
    public function __construct(string $titulo, int $numero, float $precio, string $idioma, string $formatPantalla) {
        parent::__construct($titulo, $numero, $precio); // Llamada al constructor de la clase padre
        $this->idioma = $idioma;
        $this->formatPantalla = $formatPantalla;
    }

    // Getter para idioma
    public function getIdioma(): string {
        return $this->idioma;
    }

    // Setter para idioma
    public function setIdioma(string $idioma): void {
        $this->idioma = $idioma;
    }

    // Getter para el formato de pantalla
    public function getFormatPantalla(): string {
        return $this->formatPantalla;
    }

    // Setter para el formato de pantalla
    public function setFormatPantalla(string $formatPantalla): void {
        $this->formatPantalla = $formatPantalla;
    }
    
    // Método para mostrar un resumen de la clase
    public function muestraResumen(): void {
        // Llama al método muestraResumen() de la clase padre y agrega detalles específicos del DVD
        echo parent::muestraResumen() . "<br>Idioma: $this->idioma, <br>Formato Pantalla: $this->formatPantalla";
    }
}
?>
