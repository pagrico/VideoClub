<?php
include_once "Soporte.php";
include_once "Dvd.php";
include_once "Juego.php";
include_once "CintaVideo.php";


class Cliente
{
    public $nombre;
    private $numero;
    private $soportesAlquilados = [];  // Asegúrate de que este nombre sea consistente
    private $numSoportesAlquilados = 0;
    private $maxAlquilerConcurrente;
    private $user;
    private $password;

    // Constructor para inicializar el cliente con nombre, número y máximo alquiler concurrente
    public function __construct($nombre, $numero, $maxAlquilerConcurrente = 3)
    {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }
    public function setuser($user)
    {
        $this->user = $user;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setMaxAlquilerConcurrente($numeromax)
    {
        $this->maxAlquilerConcurrente = $numeromax;
    }
    public function getNumero()
    {
        return $this->numero;

    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getuser()
    {
        return $this->user;
    }
    public function setpassword($password)
    {
        $this->password = $password;
    }
    public function getpassword()
    {
        return $this->password;
    }

    // Getter para maxAlquilerConcurrente
    public function getMaxAlquilerConcurrente(): int
    {
        return $this->maxAlquilerConcurrente;
    }

    // Método para obtener el número de soportes alquilados
    public function getNumSoportesAlquilados(): int
    {
        return $this->numSoportesAlquilados;
    }

    // Método para alquilar un producto
    public function alquilar($soporte)
    {

        if (!$this->tieneAlquilado($soporte) && $this->numSoportesAlquilados < $this->maxAlquilerConcurrente) {
            echo "<br>Producto añadido correctamente a la lista de alquileres del cliente $this->nombre";
            $this->soportesAlquilados[] = $soporte;
            $this->numSoportesAlquilados++;
            $soporte->alquilado(True);

        } else {
            echo "<br>No se puede alquilar el producto al cliente $this->nombre.";
        }
        return $this; // Retorna el objeto actual para permitir el encadenamiento
    }


    // Verificar si el cliente ya tiene alquilado el producto
    public function tieneAlquilado($soporte)
    {
        foreach ($this->soportesAlquilados as $sop) {
            if ($sop->getNumero() === $soporte->getNumero()) {  // Compara por el número del soporte
                echo "<br>El cliente $this->nombre ya tiene alquilado este producto.";
                return true; // Cambiar a true para indicar que lo tiene alquilado
            }
        }
        return false; // Si no se encuentra, retorna false
    }



    // Método para devolver un soporte
    public function devolver(int $numSoporte): void
    {

        foreach ($this->soportesAlquilados as $indice => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                echo "<br>Devuelto correctamente";
                unset($this->soportesAlquilados[$indice]);
                $this->numSoportesAlquilados--;
                $soporte->alquilado(False);
                return;
            }
        }
        echo "<br>No se encontró el soporte con el número $numSoporte";
    }

    // Método para mostrar la lista de alquileres del cliente
    public function listaAlquileres(): void
    {
        if ($this->numSoportesAlquilados > 0) {
            echo "<br>Listado de soportes alquilados por $this->nombre:";
            foreach ($this->soportesAlquilados as $soporte) {
                echo "<br>- " . $soporte->titulo;
            }
        } else {
            echo "<br>No tiene alquileres en curso.";
        }
    }

    // Método para representar al cliente como string
    public function __toString(): string
    {
        $soportesInfo = ''; // Variable para almacenar la información de los soportes alquilados

        // Recorremos los soportes alquilados y los añadimos a la cadena
        foreach ($this->soportesAlquilados as $soporte) {
            // Concatenar los detalles del soporte en la variable $soportesInfo
            $soportesInfo .= "<br>Titulo: " . $soporte->getTitulo() . "<br> Numero: " . $soporte->getNumero() . "<br> Precio: " . $soporte->getPrecio() . "<br>";
        }

        // Devolvemos el resultado completo concatenado
        return "Nombre: $this->nombre, Número: $this->numero, Soportes Alquilados: $soportesInfo" .
            "Num Soportes Alquilados: $this->numSoportesAlquilados, Max Alquiler Concurrente: $this->maxAlquilerConcurrente";
    }

}
