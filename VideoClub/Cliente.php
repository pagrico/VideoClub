<?php
include_once "Soporte.php";

class Cliente {
    public $nombre;
    private $numero;
    private $soportesAlquilados = [];
    private $numSoportesAlquilados = 0;
    private $maxAlquilerConcurrente;

    // Constructor para inicializar el cliente con nombre, número y máximo alquiler concurrente
    public function __construct($nombre, $numero, $maxAlquilerConcurrente = 3) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }

    // Getters y setters
    public function getNumero(): int {
        return $this->numero;
    }

    public function setNumero(int $numero): void {
        $this->numero = $numero;
    }

    public function getNumSoportesAlquilados(): int {
        return $this->numSoportesAlquilados;
    }

    // Verifica si el cliente ya tiene alquilado un soporte específico
    public function tieneAlquilado(Soporte $soporte): bool {
        foreach ($this->soportesAlquilados as $sop) {
            if ($sop === $soporte) {
                echo "<br>El cliente ya tiene alquilado este producto";
                return false;
            }
        }
        return true;
    }

    // Método para alquilar un soporte, si el cliente no supera el máximo de alquileres concurrentes
    public function alquilar(Soporte $soporte): bool {
        if ($this->tieneAlquilado($soporte) && $this->numSoportesAlquilados < $this->maxAlquilerConcurrente) {
            echo "<br><br>Alquilado soporte a: $this->nombre<br>Producto añadido correctamente a su lista";
            $this->soportesAlquilados[] = $soporte;
            $this->numSoportesAlquilados++;
            return true;
        } else {
            echo "<br>No se puede alquilar ya que tiene el máximo de alquiler concurrente";
            return false;
        }
    }

    // Método para devolver un soporte
    public function devolver(int $numSoporte): void {
        foreach ($this->soportesAlquilados as $indice => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                echo "<br>Devuelto correctamente";
                unset($this->soportesAlquilados[$indice]);
                $this->numSoportesAlquilados--;
                return;
            }
        }
        echo "<br>No se encontró el soporte con el número $numSoporte";
    }

    // Método para mostrar la lista de alquileres del cliente
    public function listaAlquileres(): void {
        if ($this->numSoportesAlquilados > 0) {
            echo "<br>Listado de soportes alquilados por $this->nombre:";
            foreach ($this->soportesAlquilados as $soporte) {
                echo "<br>- " . $soporte->nombre;
            }
        } else {
            echo "<br>No tiene alquileres en curso.";
        }
    }

    // Método para representar al cliente como string
    public function __toString(): string {
        $soportesInfo = ''; // Variable para almacenar la información de los soportes alquilados

        // Recorremos los soportes alquilados y los añadimos a la cadena
        foreach ($this->soportesAlquilados as $soporte) {
            $soportesInfo .= "Nombre: " . $soporte->nombre . "<br> Cantidad: " . $soporte->getCantidad() . "<br>";
        }

        // Devolvemos el resultado completo concatenado
        return "Nombre: $this->nombre, Número: $this->numero, Soportes Alquilados: " . $soportesInfo . 
               "Num Soportes Alquilados: $this->numSoportesAlquilados, Max Alquiler Concurrente: $this->maxAlquilerConcurrente";
    }
}
?>
