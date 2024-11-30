<?php
    include_once "Soporte.php";
    class Juego extends Soporte {
    protected $consola;
    protected $minNumJugadores;
    protected $maxNumJugadores;

    public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {
        parent::__construct($titulo, $numero, $precio);
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

   
    public function muestraJugadoresPosibles(){
        switch($this->maxNumJugadores){
            case 1:
                echo "Para un jugador";
            break;
            case 2:
                echo"Para dos Jugadores";
                break;
            default:
            echo "Desde $this->minNumJugadores hasta $this->maxNumJugadores";
            break;

        }
    }
    public function muestraResumen() {
        echo parent::muestraResumen() ."<br>consola: $this->consola, <br>minNumJugadores: $this->minNumJugadores, <br>maxNumJugadores: $this->maxNumJugadores<br>";
    }
}

?>