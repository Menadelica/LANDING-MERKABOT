<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Conexión a la base de datos
    $conn = new PDO("mysql:host=localhost;dbname=negocio", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del POST
    $data = json_decode(file_get_contents('php://input'), true);

    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO registro (nombre, celular, nombre_negocio) VALUES (:nombre, :celular, :nombre_negocio)");

    // Vincular los parámetros
    $stmt->bindParam(':nombre', $data['ownerName']);
    $stmt->bindParam(':celular', $data['phone']);
    $stmt->bindParam(':nombre_negocio', $data['businessName']);

    // Ejecutar la consulta
    $stmt->execute();

    // Responder con éxito
    echo json_encode([
        'success' => true,
        'message' => '¡Registro exitoso!'
    ]);

} catch(PDOException $e) {
    // Manejar errores
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al registrar: ' . $e->getMessage()
    ]);
}
?> 