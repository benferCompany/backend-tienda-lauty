<?php
header('Content-Type: application/json'); // Responder en formato JSON

// Incluir la conexión
require_once '../connection.php';

// Verificar si el parámetro de búsqueda está definido
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $query = trim($_GET['query']); // Obtener la consulta de búsqueda
    $keywords = explode(' ', $query); // Dividir la consulta en palabras clave

    // Construir la consulta dinámica con múltiples palabras clave
    $conditions = [];
    foreach ($keywords as $word) {
        $word = $conn->real_escape_string($word); // Escapar cada palabra clave
        $conditions[] = "LOWER(Titulo) LIKE '%$word%' OR LOWER(Descripcion) LIKE '%$word%'";
    }
    $sqlCondition = implode(' AND ', $conditions); // Combinar las condiciones con AND

    // Consulta SQL para buscar en título y descripción
    $sql = "SELECT * FROM productos WHERE $sqlCondition";``
    $result = $conn->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row; // Agregar cada fila al array
        }
        echo json_encode($rows); // Responder con los resultados
    } else {
        echo json_encode([]); // Responder con un array vacío si no hay resultados
    }
} else {
    echo json_encode(["error" => "Parámetro de búsqueda no proporcionado"]); // Parámetro faltante
}

// Cerrar la conexión
$conn->close();
?>
