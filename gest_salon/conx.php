<?php
function getConnection() {
    $host = "localhost"; 
    $user = "DaniJay10"; 
    $pass = "git123"; 
    $db = "Colegio"; 

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}
?>
