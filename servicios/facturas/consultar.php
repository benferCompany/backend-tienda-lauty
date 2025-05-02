<?php
include "../conexion.php";

$sql = "SELECT * FROM facturaCompra";
$stmt = $conn->prepare($sql);
$todoLosDetalles = [];
$objeto["success"] =false;
if ($stmt) {
    if ($stmt->execute()) {
        $resultado = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $sqlFactura = "SELECT * FROM detalleCompra WHERE idFacturaCompra = ?";
        $stmtFacturaCompra = $conn->prepare($sqlFactura);
        if ($stmtFacturaCompra) {

            foreach ($resultado as $fila) {
                $idFacturaCompra  = (int) $fila["id"];

                $stmtFacturaCompra->bind_param("i", $idFacturaCompra);
                if ($stmtFacturaCompra->execute()) {

                    $resultadoDetalleFactura = $stmtFacturaCompra->get_result()->fetch_all(MYSQLI_ASSOC);
                    $fila['detalleCompra'] = $resultadoDetalleFactura;
                    $todoLosDetalles[] = $fila;
                } else {
                    $objeto["message"] ="Hubo un problema al intentar executar la consulta de obtener detalles de producto por id de factura" . $stmtFacturaCompra->error;
                }
            }
            $objeto["data"] =$todoLosDetalles;
            $objeto["success"] = true;
        } else {
            $objeto["message"] ="hubo un error al querer obtener el detalle de compra por id de factura" . $conn->error;
        }
    }
} else {
    $objeto["message"] ="hubo un error al cargar los datos" . $conn->error;
}

echo json_encode($objeto,JSON_UNESCAPED_UNICODE);

