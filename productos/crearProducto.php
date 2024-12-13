<?php
header('Content-Type: application/json');

// Incluir la conexión
require_once '../connection.php';

// Verificar si se envió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : null;
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null;
    $costo = isset($_POST['costo']) ? floatval($_POST['costo']) : null;
    $pvp = isset($_POST['pvp']) ? floatval($_POST['pvp']) : null;
    $img = isset($_POST['img']) ? trim($_POST['img']) : null;

    // Validar los datos
    if ($titulo && $descripcion && $costo && $pvp && $img) {
        // Preparar la consulta
        $sql = "INSERT INTO productos (titulo, descripcion, costo, pvp, img) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdds", $titulo, $descripcion, $costo, $pvp, $img);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Producto creado correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al crear el producto"]);
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
