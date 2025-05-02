<?php
include "..//conexion.php";


/*$jsonData = '[
{"idProducto": 3, "pvp":100, "descripcion": "producto creado", "cantidad": 4.0, "descuento": 0.0},
{"idProducto": 4, "pvp":100, "descripcion": "producto creado dos", "cantidad": 4.0, "descuento": 0.0}
]'*/;

       
$objeto["success"] = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // Variables de factura
   $data =json_decode($_POST["jsonData"],true);
   $idCliente  = $_POST["idCliente"];
   $descuento = $_POST["descuento"];
   $total = $_POST["total"];
   $fecha = $_POST["fecha"];

   // variable de detalles de productos.




   $sql = "INSERT INTO facturaVenta (idCliente, Descuento, Total, Fecha) VALUES (?,?,?,?)";
   $stmt = $conn->prepare($sql);
   if ($stmt) {
      $stmt->bind_param("idds", $idCliente, $descuento, $total,$fecha);
      if ($stmt->execute()) {
         $idFacturaVenta = $stmt->insert_id;
         echo "numero de factura " . $idFacturaVenta;
         if(is_array($data)){
            $sqlData = "INSERT INTO detalleVenta (idFacturaVenta, idProducto, PVP, Descripcion, Cantidad, Descuento) VALUES (?,?,?,?,?,?)";
            $stmtData = $conn->prepare($sqlData);
            if ($stmtData) {
               foreach ($data as $factura) {
                   $idProducto = (int) $factura["idProducto"];
                   $pvp = (float) $factura["pvp"];
                   $descripcion = $factura["descripcion"];
                   $cantidad = (float) $factura["cantidad"];
                   $descuento = (float) $factura["descuento"];

                   $stmtData->bind_param("iidsdd", $idFacturaVenta, $idProducto, $pvp, $descripcion, $cantidad, $descuento);
                   if ($stmtData->execute()) {
                     $objeto["success"] = true;
                     $objeto["message"] = "Se creó el detalle con éxito para la factura:" . $idFacturaVenta . "<br>";
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
      $objeto["message"]= "Ocurrio un problema con la consulta factura de compra" . $conn->error;
   }
}
echo json_encode($objeto,JSON_UNESCAPED_UNICODE);
$conn->close();