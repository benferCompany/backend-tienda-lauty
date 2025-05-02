<?php
include "..//conexion.php";


/*$jsonData = '[
{"id":3, "idProducto": 3, "costo":100, "descripcion": "producto actualizado", "cantidad": 4.0, "descuento": 0.0},
{"id":4,"idProducto": 3, "costo":100, "descripcion": "producto actualizado", "cantidad": 4.0, "descuento": 0.0}
]';*/
       
$objeto["success"] = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // Variables de factura
   $id = $_POST["id"];
   $data =json_decode($_POST["jsonData"],true);
   $idproveedor  = $_POST["idproveedor"];
   $descuento = $_POST["descuento"];
   $total = $_POST["total"];
   $fecha = $_POST["fecha"];


   // variable de detalles de productos.




   $sql = "UPDATE facturacompra SET idProveedor = ?, Descuento = ?, Total = ?, Fecha =? WHERE id=?";
   $stmt = $conn->prepare($sql);
   if ($stmt) {
      $stmt->bind_param("iddsi", $idproveedor, $descuento, $total,$fecha, $id);
      if ($stmt->execute()) {
         
         echo "numero de factura " . $id;
         if(is_array($data)){
            $sqlData = "UPDATE detalleCompra SET idProducto = ?, Costo =?, Descripcion=?, Cantidad= ?, Descuento=? WHERE id=? ";
            $stmtData = $conn->prepare($sqlData);
            if ($stmtData) {
               foreach ($data as $factura) {
                  $idDetalle = (int) $factura["id"];
                   $idProducto = (int) $factura["idProducto"];
                   $costo = (float) $factura["costo"];
                   $descripcion = $factura["descripcion"];
                   $cantidad = (float) $factura["cantidad"];
                   $descuento = (float) $factura["descuento"];

                   $stmtData->bind_param("idsddi", $idProducto, $costo, $descripcion, $cantidad, $descuento,$idDetalle);
                   if ($stmtData->execute()) {
                       $objeto["success"] = true;
                       $objeto["message"] = "Se Actualizó con exito la factuara:" . $id . "<br>";

                   } else {
                       $objeto["message"] = "Error al insertar detalle: " . $stmtData->error . "<br>";
                   }
               }
            }else{
               $objeto["message"] ="ocurrio algo con la consulta preparada" . $conn->error;
            }
         }
      } else {
         $objeto["message"] = "Ocurrio un problema con la consulta prepara de factura de compra" . $stmt->error;
      }
   } else {
      $objeto["message"] = "Ocurrio un problema con la consulta factura de compra" . $conn->error;
   }
}
echo json_encode($objeto,JSON_UNESCAPED_UNICODE);
$conn->close();