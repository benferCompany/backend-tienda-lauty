<?php
  include "../conexion.php";

  if($_SERVER ["REQUEST_METHOD"]=="POST"){
    $id = $_POST["id"];
    $razonSocial = $_POST["razonSocial"];
    $cuit = $_POST["cuit"];
    $nombreContacto = $_POST["nombreContacto"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];

    $sql = "UPDATE proveedor SET RazonSocial = ?, Cuit = ?, nombreContacto = ?, Telefono = ?, Direccion = ? WHERE id = ? ";

    $stmt = $conn->prepare($sql);
    if($stmt) {
      $stmt->bind_param("sssssi",$razonSocial,$cuit,$nombreContacto,$telefono,$direccion,$id);

      if($stmt->execute()){
        echo "El proveedor se actualizó correctamente";
      }else{
        echo "Hubo un error al quere ejecutar la consulta" . $stmt->error;
      }
    }else{
      echo "Hubo un error al preparar la consulta de proveedor" . $conn->error;
    }
  }
?>