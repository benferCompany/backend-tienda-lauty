<?php
include "..//conexion.php";


$jsonData = '[
{"idProducto": 3, "pvp":100, "descripcion": "producto actualizado", "cantidad": 4.0, "descuento": 0.0},
{"idProducto": 3, "pvp":100, "descripcion": "producto actualizado", "cantidad": 4.0, "descuento": 0.0}
]';
$data =json_decode($jsonData,true);
       
$objeto["success"] = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // Variables de factura
   $id = $_POST["id"];
   $idproveedor  = $_POST["idproveedor"];
   $descuento = $_POST["descuento"];
   $total = $_POST["total"];
   $fecha = $_POST["fecha"];

   // variable de detalles de productos.




   $sql = "UPDATE facturaVenta SET idProveedor = ?, Descuento = ?, Total = ?, Fecha =? WHERE id=?";
   $stmt = $conn->prepare($sql);
   if ($stmt) {
      $stmt->bind_param("iddsi", $idproveedor, $descuento, $total,$fecha, $id);
      if ($stmt->execute()) {
         
         echo "numero de factura " . $id;
         if(is_array($data)){
            $sqlData = "UPDATE detalleVenta SET idProducto = ?, PVP =?, Descripcion=?, Cantidad= ?, Descuento=? WHERE idFacturaCompra=? ";
            $stmtData = $conn->prepare($sqlData);
            if ($stmtData) {
               foreach ($data as $factura) {
                   $idProducto = (int) $factura["idProducto"];
                   $PVP = (float) $factura["pvp"];
                   $descripcion = $factura["descripcion"];
                   $cantidad = (float) $factura["cantidad"];
                   $descuento = (float) $factura["descuento"];

                   $stmtData->bind_param("idsddi", $idProducto, $PVP, $descripcion, $cantidad, $descuento,$id);
                   if ($stmtData->execute()) {
                        $objeto["message"] = "Se Actualizó con exito la factuara:" . $id . "<br>";  
                       
                   } else {
                       $objeto["message"] = "Error al insertar detalle: " . $stmtData->error . "<br>";
                   }
               }
            }else{
                $objeto["message"] = "ocurrio algo con la consulta preparada" . $conn->error; 
               
            }
         }
      } else {
            $objeto["message"] = "Ocurrio un problema con la consulta prepara de factura de venta" . $stmt->error;
         
      }
   } else {
        $objeto["message"] = "Ocurrio un problema con la consulta factura de compra" . $conn->error;
      
   }
}
echo json_encode($objeto);
$conn->close();