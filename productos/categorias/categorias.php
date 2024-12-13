<?php


require_once '../../connection.php';

// Verificar si se pasó un parámetro "id"

    // Consulta para obtener un usuario por ID
    $sql = "SELECT * FROM categoria";
    $stmt = $conn->prepare($sql); // Preparar la consulta
    $stmt->execute();            // Ejecutar la consulta
    $result = $stmt->get_result(); // Obtener el resultado

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
    $stmt->close(); // Cerrar la consulta preparada
// Cerrar la conexión
$conn->close();


?>