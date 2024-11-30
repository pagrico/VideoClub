<?php
    
    class Soporte {
    public $titulo;
    protected $numero;
    private $precio;

    public function __construct($titulo, $numero, $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    public function getTitulo() {
        return $this->titulo;
    }

   

    public function getNumero() {
        return $this->numero;
    }

  
    public function getPrecio() {
        return $this->precio;
    }

    public function getprecioConIVA():float{
        return $this->precio*1.21;
    } 
    public function muestraResumen(){
        echo "<br>$this->titulo, <br>precio: $this->precio<br> Precio IVA incluido: ".$this->getprecioConIVA() ;

    }

    public function __toString() {
        return "titulo: $this->titulo, numero: $this->numero, precio: $this->precio";
    }
}

?>