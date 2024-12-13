<?php
header('Content-Type: application/json'); // Responder con JSON

// Incluir la conexión
require_once '../connection.php';

// Verificar si se pasó un parámetro "id"
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener un usuario por ID
    $sql = "SELECT * FROM clientes WHERE ID = ?";
    $stmt = $conn->prepare($sql); // Preparar la consulta
    $stmt->bind_param("i", $id);  // Asociar el parámetro
    $stmt->execute();            // Ejecutar la consulta
    $result = $stmt->get_result(); // Obtener el resultado

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc()); // Devolver el usuario como JSON
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]); // Usuario no encontrado
    }

    $stmt->close(); // Cerrar la consulta preparada
} else {
    echo json_encode(["error" => "ID inválido o no proporcionado"]); // Parámetro faltante o inválido
}

// Cerrar la conexión
$conn->close();
?>
