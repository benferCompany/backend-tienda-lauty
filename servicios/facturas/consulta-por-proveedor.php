<?php

include "../conexion.php";
$objeto["success"] = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoLosDatos = [];
    $idProveedor = $_POST["idproveedor"];

    // Se utiliza una consulta preparada para evitar inyecciones SQL.
    $sql = "SELECT * FROM facturaCompra WHERE idProveedor = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $idProveedor); // Bind de parámetros de manera segura.
        
        // Ejecutar la consulta y comprobar si se obtienen resultados.
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $resultado = $result->fetch_all(MYSQLI_ASSOC);

                $sqlDetalleCompra = "SELECT * FROM detalleCompra WHERE idFacturaCompra = ?";
                // Se prepara la consulta para obtener los detalles de la compra.
                if ($stmtDetalleCompra = $conn->prepare($sqlDetalleCompra)) {
                    foreach ($resultado as $fila) {
                        $idFacturaCompra = $fila["id"];
                        
                        // Se asocia el parámetro de detalleCompra de manera segura.
                        $stmtDetalleCompra->bind_param("i", $idFacturaCompra);

                        if ($stmtDetalleCompra->execute()) {
                            // Almacenamos los detalles de la compra.
                            $fila["detalleCompra"] = $stmtDetalleCompra->get_result()->fetch_all(MYSQLI_ASSOC);
                            $todoLosDatos[] = $fila;
                        } else {
                            $objeto["message"] ="Hubo un error al ejecutar la sentencia de detalleCompra: " . $stmtDetalleCompra->error;
                        }
                    }
                } else {
                    $objeto["message"] ="Hubo un error al intentar preparar la sentencia de detalleCompra: " . $conn->error;
                }
                
                // Se devuelve el resultado como JSON.
                $objeto["data"] = $todoLosDatos;
                $objeto["success"] = true;
            } else {
                $objeto["message"] ="No hay datos disponibles.";
            }
        } else {
            $objeto["message"] ="Hubo un problema al ejecutar la sentencia SQL principal: " . $stmt->error;
        }
    } else {
        $objeto["message"] = "Hubo un problema al preparar la sentencia SQL principal: " . $conn->error;
    }
}
echo json_encode($objeto,JSON_UNESCAPED_UNICODE);

?>
