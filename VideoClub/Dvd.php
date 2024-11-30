<?php
include_once "Soporte.php";
class Dvd extends Soporte {
    public $idioma;
    private $formatPantalla;

    public function __construct($titulo, $numero, $precio, $idioma, $formatPantalla) {
        parent::__construct($titulo, $numero, $precio);
        $this->idioma = $idioma;
        $this->formatPantalla = $formatPantalla;
    }

    public function getIdioma() {
        return $this->idioma;
    }

    public function setIdioma($idioma) {
        $this->idioma = $idioma;
    }

    public function getFormatPantalla() {
        return $this->formatPantalla;
    }

    public function setFormatPantalla($formatPantalla) {
        $this->formatPantalla = $formatPantalla;
    }
    
    public function muestraResumen() {
        echo parent::muestraResumen()."<br>idioma: $this->idioma, <br>formatPantalla: $this->formatPantalla";
        
    }
}

?>