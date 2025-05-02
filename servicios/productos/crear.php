<?php
  include "../conexion.php";  

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $descripcion =$_POST["descripcion"];
    $costo =$_POST["costo"];
    $pvp =$_POST["pvp"];

       $sql = "INSERT INTO producto (descripcion, costo, pvp) VALUES ('$descripcion', '$costo', '$pvp')";

    if ($conn -> query($sql) === TRUE){
        echo "Producto creado exitosamente";
    } else {
        echo "Error: " . $conn->error;
    }
  }
?>