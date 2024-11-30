<?php
   include_once "Soporte.php";
    class CintaVideo extends Soporte {
        private $duracion;
        
        public function __construct($titulo, $numero, $precio, $duracion) {
            parent::__construct($titulo, $numero, $precio);
            $this->duracion = $duracion;
        }
        
        public function getDuracion() {
            return $this->duracion;
        }
        
        public function setDuracion($duracion) {
            $this->duracion = $duracion;
        }
        
        public function muestraResumen() {
            echo "<br>".parent::muestraResumen() ."duracion: $this->duracion";
        }
}

        ?>