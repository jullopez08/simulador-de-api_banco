<?php
header('Content-Type: application/json');
include 'db.php';

$request_method = $_SERVER['REQUEST_METHOD'];


switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_cuenta($id);
        } else {
            get_cuentas();
        }
        break;

    case 'POST':
        create_cuentas();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        update_cuenta($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        delete_cuenta($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
function get_cuentas() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM cuentas");
    $cuentas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cuentas);
}

function get_cuenta($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM cuentas WHERE id = ?");
    $stmt->execute([$id]);
    $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($cuenta);
}

function create_cuentas() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));

    // Preparar la sentencia SQL con NOW() para la fecha de creación automática
    $stmt = $pdo->prepare("INSERT INTO cuentas (nombre_titular, numero_cuenta, saldo, fecha_creacion) VALUES (?, ?, ?, NOW())");

    // Ejecutar la sentencia con los datos proporcionados
    $stmt->execute([$data->nombre_titular, $data->numero_cuenta, $data->saldo]);

    echo json_encode(["message" => "Cuenta created successfully"]);
}

function update_cuenta($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));
    $stmt = $pdo->prepare("UPDATE cuentas SET nombre_titular = ?, numero_cuenta = ?, saldo= ? WHERE id = ?");
    $stmt->execute([$data->nombre_titular, $data->numero_cuenta, $data->saldo, $id]);
    echo json_encode(["message" => "cuenta updated successfully"]);
}

function delete_cuenta($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM cuentas WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "cuentas deleted successfully"]);
}
?>