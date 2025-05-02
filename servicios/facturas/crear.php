<?php
include "..//conexion.php";


/*$jsonData = '[
{"idProducto": 3, "costo":100, "descripcion": "producto creado", "cantidad": 4.0, "descuento": 0.0},
{"idProducto": 4, "costo":100, "descripcion": "producto creado dos", "cantidad": 4.0, "descuento": 0.0}
]'*/;

       
$objeto["success"] = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // Variables de factura
   $data =json_decode($_POST["jsonData"],true);
   $idproveedor  = $_POST["idproveedor"];
   $descuento = $_POST["descuento"];
   $total = $_POST["total"];
   $fecha = $_POST["fecha"];

   // variable de detalles de productos.




   $sql = "INSERT INTO facturacompra (idproveedor, descuento, total, fecha) VALUES (?,?,?,?)";
   $stmt = $conn->prepare($sql);
   if ($stmt) {
      $stmt->bind_param("idds", $idproveedor, $descuento, $total,$fecha);
      if ($stmt->execute()) {
         $idFacturaCompra = $stmt->insert_id;
         echo "numero de factura " . $idFacturaCompra;
         if(is_array($data)){
            $sqlData = "INSERT INTO detalleCompra (idFacturaCompra, idProducto, Costo, Descripcion, Cantidad, Descuento) VALUES (?,?,?,?,?,?)";
            $stmtData = $conn->prepare($sqlData);
            if ($stmtData) {
               foreach ($data as $factura) {
                   $idProducto = (int) $factura["idProducto"];
                   $costo = (float) $factura["costo"];
                   $descripcion = $factura["descripcion"];
                   $cantidad = (float) $factura["cantidad"];
                   $descuento = (float) $factura["descuento"];

                   $stmtData->bind_param("iidsdd", $idFacturaCompra, $idProducto, $costo, $descripcion, $cantidad, $descuento);
                   if ($stmtData->execute()) {
                     $objeto["success"] = true;
                     $objeto["message"] = "Se creó el detalle con éxito para la factura:" . $idFacturaCompra . "<br>";
                   } else {
                     $objeto["message"] = "Error al insertar detalle: " . $stmtData->error . "<br>";
                   }
               }
            }else{
               $objeto["message"] = "ocurrio algo con la consulta preparada" . $conn->error;
            }
         }
      } else {
         $objeto["message"] = "Ocurrio un problema con la consulta prepara de factura de compra" . $stmt->error;
      }
   } else {
      $objeto["message"]= "Ocurrio un problema con la consulta factura de compra" . $conn->error;
   }
}
echo json_encode($objeto,JSON_UNESCAPED_UNICODE);
$conn->close();