<?php
    $user=$_POST["user"];
    $password=$_POST["password"];

    ($user==="user" && $password ==="user"|| $user==="admin" && $password ==="admin" )?correcto($user):denegado();

    function correcto($user){
        session_start();
        $_SESSION["user"]=$user;
        header("Location: main.php");    
    }
    function denegado() {
        header("Location: index.php?error=error");
        
    }

?>