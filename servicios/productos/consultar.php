<?php

include "../conexion.php";

$sql = "SELECT * FROM producto";



if($conn->query($sql)){

    $resultado  = $conn->query($sql);
    if($resultado->num_rows>0){
        while($fila = $resultado->fetch_assoc()){
            echo "ID" . $fila["id"] . " - Decripción " . $fila["descripcion"] . " - Costo " . $fila["costo"] . " - pvp " . $fila["pvp"] . "<br>";   
        }
    }

}else{
    echo "Error: " . $conn->error;
}
?>