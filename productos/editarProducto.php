<?php
header('Content-Type: application/json'); // Responder con JSON

// Incluir la conexión
require_once '../connection.php';

// Verificar la conexión
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Error en la conexión con la base de datos"]);
    exit;
}

// Verificar si se envió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : null;
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null;
    $costo = isset($_POST['costo']) ? floatval($_POST['costo']) : null;
    $pvp = isset($_POST['pvp']) ? floatval($_POST['pvp']) : null;
    $img = isset($_POST['img']) ? trim($_POST['img']) : null;
    $categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : null;

    // Validar los datos
    if ($id !== null && $titulo && $descripcion && $costo !== null && $pvp !== null && $img && $categoria !== null) {
        // Preparar la consulta
        $sql = "UPDATE productos SET titulo = ?, descripcion = ?, costo = ?, pvp = ?, img = ?, categoria_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssddsii", $titulo, $descripcion, $costo, $pvp, $img, $categoria, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Producto actualizado correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el producto"]);
        }

        $stmt->close(); // Cerrar la consulta preparada
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}

// Cerrar la conexión
$conn->close();
?>
