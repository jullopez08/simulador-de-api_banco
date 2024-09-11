<?php
header('Content-Type: application/json');
include 'db.php'; // Asegúrate de que la ruta a db.php sea correcta

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            // Implementa una función si necesitas manejar solicitudes GET con ID
        } else {
            get_usuarios();
        }
        break;

    case 'POST':
        login_usuarios();
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        break;
}

function get_usuarios() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users"); 
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($usuarios);
}

function login_usuarios() {
    global $pdo;

    // Leer la entrada JSON
    $input = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'JSON inválido.']);
        return;
    }

    if (isset($input['username']) && isset($input['password'])) {
        $username = $input['username'];
        $password = $input['password'];

        try {
            // Validación de usuario
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso.']);
                session_start();
                $_SESSION['username'] = $username;
            } else {
                echo json_encode(['success' => false, 'message' => 'Nombre de usuario o contraseña incorrectos.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error en la consulta: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    }
}
?>