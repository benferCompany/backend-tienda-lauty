<?php 
include "../conexion.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"];
    $descripcion = $_POST["descripcion"];
    $costo = $_POST["costo"];
    $pvp = $_POST["pvp"];


    $sql = "UPDATE producto SET descripcion='$descripcion', costo='$costo', pvp='$pvp' WHERE id=$id";
    if($conn->query($sql) ===TRUE){
        echo "El producto se actulizó correctamente";
    }else{
        echo "error" . $conn->error; 
    }
}

?>