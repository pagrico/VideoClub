<?php
include_once "Cliente.php"; // Asegúrate de incluir la clase Cliente

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
    private function incluirProducto($producto) {
        $this->productos[] = $producto;
        $this->numProductos++;
        return $this; // Retorna $this para encadenamiento
    }


    public function getNumProductosAlquilados(){
        return $this->getNumProductosAlquilados;
    }

    public function getNumTotalAlquileres(){
        return $this->getNumTotalAlquileres;
    }
    // Métodos públicos para incluir soportes específicos
    public function incluirCintaVideo($titulo, $precio, $duracion) {
        $cinta = [
            'tipo' => 'CintaVideo',
            'titulo' => $titulo,
            'precio' => $precio,
            'duracion' => $duracion,
            'alquilado' => false, // estado de alquiler
        ];
        return $this->incluirProducto($cinta);
    }

    public function incluirDvd($titulo, $precio, $idiomas, $pantalla) {
        $dvd = [
            'tipo' => 'Dvd',
            'titulo' => $titulo,
            'precio' => $precio,
            'idiomas' => $idiomas,
            'pantalla' => $pantalla,
            'alquilado' => false, // estado de alquiler
        ];
        return $this->incluirProducto($dvd);
    }

    public function incluirJuego($titulo, $precio, $consola, $minJugadores, $maxJugadores) {
        $juego = [
            'tipo' => 'Juego',
            'titulo' => $titulo,
            'precio' => $precio,
            'consola' => $consola,
            'minJugadores' => $minJugadores,
            'maxJugadores' => $maxJugadores,
            'alquilado' => false, // estado de alquiler
        ];
        return $this->incluirProducto($juego);
    }

    // Método para incluir un cliente
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3) {
        $cliente = new Cliente($nombre, $maxAlquileresConcurrentes);
        $this->clientes[] = $cliente;
        $this->numClientes++;
        return $this; // Retorna $this para encadenamiento
    }

    // Método para listar productos
    public function listarProductos() {
        echo "Productos disponibles en '$this->nombre':<br>";
        foreach ($this->productos as $index => $producto) {
            echo "[$index] {$producto['titulo']} ({$producto['tipo']}) - " . 
                ($producto['alquilado'] ? 'Alquilado' : 'Disponible') . "<br>";
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
        // Verificar que se ha proporcionado al menos un producto
        if (empty($numerosProductos)) {
            echo "Error: No se han proporcionado productos para alquilar.<br>";
            return;
        }
    
        // Verificar que el cliente existe
        if (!isset($this->clientes[$numSocio])) {
            echo "Error: El cliente con índice $numSocio no existe.<br>";
            return;
        }
    
        $cliente = &$this->clientes[$numSocio]; // Referencia al cliente
    
        // Verificar que todos los productos existen y están disponibles
        foreach ($numerosProductos as $numeroProducto) {
            if (!isset($this->productos[$numeroProducto])) {
                echo "Error: El producto con índice $numeroProducto no existe.<br>";
                return;
            }
    
            $producto = $this->productos[$numeroProducto];
    
            if ($producto['alquilado']) {
                echo "Error: El producto '{$producto['titulo']}' ya está alquilado.<br>";
                return;
            }
        }
    
        // Verificar si el cliente puede alquilar todos los productos
        $productosPorAlquilar = count($numerosProductos);
        $espacioDisponible = $cliente->getMaxAlquilerConcurrente() - $cliente->getNumSoportesAlquilados();
    
        if ($productosPorAlquilar > $espacioDisponible) {
            echo "Error: El cliente '{$cliente->nombre}' no puede alquilar $productosPorAlquilar productos. Solo puede alquilar $espacioDisponible más.<br>";
            return;
        }
    
        // Si todas las verificaciones pasan, proceder con los alquileres
        foreach ($numerosProductos as $numeroProducto) {
            $producto = &$this->productos[$numeroProducto];
            $producto['alquilado'] = true; // Marcar el producto como alquilado
            $cliente->alquilar($producto); // Añadir el producto al cliente
            echo "El cliente '{$cliente->nombre}' alquiló el producto '{$producto['titulo']}'.<br>";
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
