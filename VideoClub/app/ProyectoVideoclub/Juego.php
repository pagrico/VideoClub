<?php
namespace app\ProyectoVideoclub;


class Juego extends Soporte
{
    protected $consola;
    protected $minNumJugadores;
    protected $maxNumJugadores;

    // Constructor: inicializa las propiedades del juego
    public function __construct(string $titulo, int $numero, float $precio, string $consola, int $minNumJugadores, int $maxNumJugadores)
    {
        parent::__construct($titulo, $numero, $precio); // Llamada al constructor de la clase padre
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    // Muestra los jugadores posibles para el juego
    public function muestraJugadoresPosibles(): void
    {
        if ($this->maxNumJugadores === 1) {
            echo "Para un jugador.";
        } elseif ($this->maxNumJugadores === 2) {
            echo "Para dos jugadores.";
        } else {
            echo "Desde $this->minNumJugadores hasta $this->maxNumJugadores jugadores.";
        }
    }

    // Muestra el resumen del juego
    public function muestraResumen(): void
    {
        // Llama al método muestraResumen() de la clase padre y añade más información específica del juego
        echo parent::muestraResumen() . "<br>Consola: $this->consola, <br>Jugadores: Desde $this->minNumJugadores hasta $this->maxNumJugadores jugadores.<br>";
    }
}
?>