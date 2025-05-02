<?php 
$host ="localhost";
$usuario ="root";
$clave ="";
$db ="gestionprueba";

$conn = new mysqli($host, $usuario, $clave, $db);
$conn->set_charset("utf8");

if ($conn -> connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>