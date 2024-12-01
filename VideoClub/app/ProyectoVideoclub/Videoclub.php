<?php
include_once "Cliente.php";
include_once "Juego.php";
include_once "CintaVideo.php"; // Asegúrate de incluir la clase Cliente
include_once "Dvd.php"; // Asegúrate de incluir la clase Cliente
 // Asegúrate de incluir la clase Cliente

class Videoclub {
    private $nombre;
    private $productos = []; // Array de soportes
    private $numProductos = 0;
    private $clientes = []; // Array de clientes (ahora objetos de Cliente)
    private $numClientes = 0;
    private $numProductosAlquilados;
    private $numTotalAlquileres;

    // Constructor
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }
// Método privado para incluir un producto
private function incluirProducto(Soporte $producto): self {
    $this->productos[] = $producto;
    return $this; // Retorna $this para encadenamiento
}

// Métodos públicos para incluir soportes específicos
public function incluirCintaVideo($titulo, $precio, $duracion): self {
    $cinta = new CintaVideo($titulo, ++$this->numProductos, $precio, $duracion); // Crear objeto CintaVideo
    return $this->incluirProducto($cinta);
}

public function incluirDvd($titulo, $precio, $idiomas, $pantalla): self {
    $dvd = new Dvd($titulo, ++$this->numProductos, $precio, $idiomas, $pantalla); // Crear objeto Dvd
    return $this->incluirProducto($dvd);
}

public function incluirJuego($titulo, $precio, $consola, $minJugadores, $maxJugadores): self {
    $juego = new Juego($titulo, ++$this->numProductos, $precio, $consola, $minJugadores, $maxJugadores); // Crear objeto Juego
    return $this->incluirProducto($juego);
}


    
   
    // Método para incluir un cliente
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3) {
        $cliente = new Cliente($nombre,++$this->numClientes, $maxAlquileresConcurrentes);
        $this->clientes[] = $cliente;
        return $this; // Retorna $this para encadenamiento
    }

    // Método para listar productos
    public function listarProductos() {
        echo "Productos disponibles en '$this->nombre':<br>";
        foreach ($this->productos as $index => $producto) {
            $estado = $producto->getAlquilado() ? 'Alquilado' : 'Disponible';
            echo "[$index] {$producto->getTitulo()} - $estado<br>";
        }
        return $this; // Retorna $this para encadenamiento
    }
    

    // Método para listar clientes
    public function listarSocios() {
        echo "Clientes registrados en '$this->nombre':<br>";
        foreach ($this->clientes as $cliente) {
            echo $cliente . "<br>"; // Usando el método __toString de Cliente
        }
        return $this; // Retorna $this para encadenamiento
    }

    // Método para alquilar un producto a un cliente
    public function alquilaSocioProducto(int $numSocio, ...$numerosProductos): void {
        if (!isset($this->clientes[$numSocio])) {
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return;
        }
    
        $cliente = $this->clientes[$numSocio];
    
        foreach ($numerosProductos as $numeroProducto) {
            if (!isset($this->productos[$numeroProducto])) {
                echo "Error: El producto con índice $numeroProducto no existe.<br>";
                return;
            }
    
            $producto = $this->productos[$numeroProducto];
    
            if ($producto->getAlquilado()) {
                echo "Error: El producto ".$producto->getTitulo(). " ya está alquilado.<br>";
                return;
            }
            $cliente->alquilar($producto);
            echo "El cliente ". $cliente->nombre." alquiló el producto ".$producto->titulo.".<br>";
        }
    }
    
    
    public function devolverSocioProducto(int $numSocio, int $numeroProducto): self {
        // Verificar si el cliente existe
        if (!isset($this->clientes[$numSocio])) {
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return $this;
        }
    
        // Verificar si el producto existe
        if (!isset($this->productos[$numeroProducto])) {
            echo "Error: El producto con índice $numeroProducto no existe.<br>";
            return $this;
        }
    
        $cliente = &$this->clientes[$numSocio]; // Referencia al cliente
        $producto = &$this->productos[$numeroProducto]; // Referencia al producto
    
        // Verificar si el producto está alquilado por este cliente
        if (!$producto['alquilado']) {
            echo "Error: El producto '{$producto['titulo']}' no está alquilado.<br>";
            return $this;
        }
    
        // Devolver el producto
        $producto['alquilado'] = false; // Marcar el producto como disponible
        $cliente->devolver($numeroProducto); // Actualizar los alquileres del cliente
    
        echo "El cliente '{$cliente->nombre}' devolvió el producto '{$producto['titulo']}'.<br>";
        return $this; // Soporte para encadenamiento
    }
    
    
    public function devolverSocioProductos(int $numSocio, ...$numerosProductos): self {
        // Verificar si el cliente existe
        if (!isset($this->clientes[$numSocio])) {
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return $this;
        }
    
        $cliente = &$this->clientes[$numSocio]; // Referencia al cliente
    
        // Procesar cada producto
        foreach ($numerosProductos as $numeroProducto) {
            // Verificar si el producto existe
            if (!isset($this->productos[$numeroProducto])) {
                echo "Error: El producto con índice $numeroProducto no existe.<br>";
                continue; // Saltar este producto y continuar con el siguiente
            }
    
            $producto = &$this->productos[$numeroProducto]; // Referencia al producto
    
            // Verificar si el producto está alquilado por este cliente
            if (!$producto['alquilado']) {
                echo "Error: El producto '{$producto['titulo']}' no está alquilado.<br>";
                continue; // Saltar este producto y continuar con el siguiente
            }
    
            // Devolver el producto
            $producto['alquilado'] = false; // Marcar el producto como disponible
            $cliente->devolver($numeroProducto); // Actualizar los alquileres del cliente
    
            echo "El cliente '{$cliente->nombre}' devolvió el producto '{$producto['titulo']}'.<br>";
        }
    
        return $this; // Soporte para encadenamiento
    }
    


        
    

}
?>
