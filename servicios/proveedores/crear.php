<?php
  include "../conexion.php";

  if( $_SERVER ["REQUEST_METHOD"] == "POST") {

    $razonsocial = $_POST["razonsocial"];

    $cuit = $_POST["cuit"];
  
    $nombrecontacto = $_POST["contacto"];
  
    $telefono = $_POST["telefono"];
  
    $direccion = $_POST["direccion"];      

    $sql = "INSERT INTO proveedor (RazonSocial, Cuit, NombreContacto, Telefono, Direccion) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    
    if($stmt) {
       $stmt->bind_param("sssss", $razonsocial,$cuit,$nombrecontacto,$telefono,$direccion);
       if($stmt->execute()){
        echo "esta todo correcto mi loco";
       }else{
        echo "ta to mal hace devuelta" . $stmt->error;
       }
    }
    else {
      echo "hay un error fijate bien cara pulpo" . $conn->error;
    }
  }
?>