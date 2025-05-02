<?php
  include "../conexion.php";
$objeto["success"] = false;
  if($_SERVER["REQUEST_METHOD"]=="POST") {
    
    $id =$_POST["id"];
    $sql = "SELECT * FROM facturacompra WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0) {
        $deletesql = "DELETE FROM facturacompra WHERE id=?";
        $smtmDelete = $conn->prepare($deletesql);
        $smtmDelete->bind_param("i", $id);
        if ($smtmDelete->execute()){
          $objeto["message"] = "su factura se elimino correctamente";
          $objeto["success"] = true;
        }
        else {
          $objeto["message"] = "ERROR al intentar eliminar la factura ". $stmt->error; 
        }

    }
    else {
        $objeto["message"] = "no existe factura";
    }
  }
echo json_encode($objeto,JSON_UNESCAPED_UNICODE);

?>