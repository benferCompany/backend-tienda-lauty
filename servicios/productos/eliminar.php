<?php
   include  "../conexion.php";

   if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $id = $_POST["id"];
    $checksql = "SELECT id FROM producto WHERE id = ?";
    $stmt = $conn-> prepare($checksql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ( $result->num_rows > 0) {
     $deletesql = "DELETE  FROM producto WHERE id =?";
     $stmt =$conn->prepare($deletesql);
     $stmt->bind_param("i", $id);
      if ($stmt->execute()) {
         echo "el producto se elimino";
      }
      else {
        echo "hubo un error". $conn->error;
      }
   }else{
    echo "No exite producto con ese código";
   }

   }
?>
