<?php

include "../conexion.php";
$objeto["success"] = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoLosDatos = [];
    $fechaApertura =  $_POST["fechaApertura"];
    $fechaCierre = $_POST["fechaCierre"];

    $sql = "SELECT * FROM facturaCompra WHERE fecha BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $fechaApertura, $fechaCierre);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                foreach ($resultado->fetch_all(MYSQLI_ASSOC) as $fila) {
                    $sqlDetalleCompra = "SELECT * FROM detalleCompra WHERE idFacturaCompra = ?";
                    $stmtDetalleCompra = $conn->prepare($sqlDetalleCompra);
                    if ($stmtDetalleCompra) {
                        $stmtDetalleCompra->bind_param("i", $fila["id"]);
                        if ($stmtDetalleCompra->execute()) {
                            $fila["detalleCompra"] = $stmtDetalleCompra->get_result()->fetch_all(MYSQLI_ASSOC);
                            $todoLosDatos[] = $fila;
                            $objeto["success"] = true;
                            $objeto["data"] = $todoLosDatos;
                        } else {
                            $objeto["message"] = "Hubo un problema al intentar executar detalleCompra" . $stmtDetalleCompra->error;
                        }
                    } else {
                        $objeto["message"] = "Hubo un error en la sintax del sql detalleCompra" . $conn->error;
                    }
                }
            }
        } else {
            $objeto["message"] = "Hubo un error al intenter executar la consula de facturaCompra" . $stmt->error;
        }
    } else {
        $objeto["message"] = "Hubo un problema en la sintaxis en la consulta sql" . $conn->error;
    }
}
echo json_encode($objeto, JSON_UNESCAPED_UNICODE);
$conn->close();
