<?php
header('Content-Type: application/json');
include 'db.php'; // Asegúrate de que la ruta a db.php sea correcta

$request_method = $_SERVER['REQUEST_METHOD'];

// Leer la entrada JSON
$input = json_decode(file_get_contents('php://input'), true);

if ($request_method === 'POST') {
    if (isset($input['username']) && isset($input['password'])) {
        $username = $input['username'];
        $password = $input['password'];

        try {
            // Registro de usuario
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registro exitoso.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar usuario.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
