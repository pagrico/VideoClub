<?php
 include_once "Soporte.php";
    class Cliente {
    public $nombre;
    private $numero;
    private $soporteAlquilados=[];
    private $numSoportesAlquilados=0;
    private $maxAlquilerConcurrente;

    public function __construct($nombre, $numero, $maxAlquilerConcurrente=3) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }
 
    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }
    public function getnumSoportesAlquilados() {
        return $this->numSoportesAlquilados;
    }
    public function tieneAlquilado($soporte){
        $contiene=true;
        foreach ($this->soporteAlquilados as $sop) {
            if($sop===$soporte){
                echo "<br>El cliente ya tiene alquilado este producto";
                $contiene=false;
            }
            
        }
        return $contiene;


    }
    public function alquilar($soporte) {
        if($this->tieneAlquilado($soporte)&&($this->numSoportesAlquilados<$this->maxAlquilerConcurrente)){

            echo "<br><br>Alquilado soporte a:$this->nombre<br>Producto añadido correctamente a su lista";
            $this->soporteAlquilados[]=$soporte;
            $this->numSoportesAlquilados++;
            return true;
        }
        else{

            echo "<br>No se puede alquilar ya que tiene el maximo de alquiler concurrente";
            return false;
        }
    }
    
    public function devolver($numSoporte){
        foreach ($this->soporteAlquilados as $indice=>$soporte) {
            if($soporte->getnumero()==$numSoporte){
                echo "Devuelto correctamente";
                unset($this->soporteAlquilados[$indice]);
                $this->numSoportesAlquilados--; 
                
            }
        }
    }

    public function listaAlquileres(){
        
    }
    

    public function __toString() {
        $soportesInfo = ''; // Variable para almacenar la información de los soportes alquilados
        
        // Recorremos los soportes alquilados y los añadimos a la cadena
        foreach ($this->soporteAlquilados as $soporte) {
            $soportesInfo .= "Nombre: " . $soporte->nombre . "<br> Cantidad: " . $soporte->getCantidad() . "<br>";
        }
    
        // Devolvemos el resultado completo concatenado
        return "Nombre: $this->nombre, Numero: $this->numero, Soportes Alquilados: " . $soportesInfo .
               "Num Soportes Alquilados: $this->numSoportesAlquilados, Max Alquiler Concurrente: $this->maxAlquilerConcurrente";
    }
}

