<?php
  include "../conexion.php";

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $id =$_POST["id"];

    $sql = "SELECT * FROM proveedor WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows>=0) {
        $deletesql = " DELETE FROM proveedor WHERE id=?";
        $smtm = $conn->prepare($deletesql);
        $smtm->bind_param("i", $id);
        if ($smtm->execute()){
            echo "su proveedor se elimino correctamente";
        }
        else {
            echo "ERROR al intentar eliminar al Proveedor ". $stmt->error; 
        }

    }
    else {
        echo "no existe proveedor";
    }
  }

?>