<?php
header('Content-Type: application/json');
include 'db.php';

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_transaccion($id);
        }elseif (!empty($_GET["action"]) && $_GET["action"] === "numeros_cuenta") {
            numeros_cuenta();
        } else{
            get_transacciones();
        }
        break;
    case 'POST':
        create_transacciones();
        break;
    case 'PUT':
        $id = intval($_GET["id"]);
        update_transaccion($id);
        break;    
    case 'DELETE':
        $id = intval($_GET["id"]);
        delete_transaccion($id);
        break;
    default:
    header("HTTP/1.0 405 Method Not Allowed");
        break;
};
function get_transacciones(){
    global $pdo;
    // CAMBIE c.numero_cuenta por c.id
    $stmt = $pdo -> query("SELECT t.id, c.numero_cuenta, t.tipo, t.monto, t.fecha FROM transacciones t INNER JOIN cuentas c ON t.cuenta_id = c.id"); 
    $transacciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($transacciones);
};


function get_transaccion($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM transacciones WHERE id = ?");
    $stmt->execute([$id]);
    $transaccion = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($transaccion);
};
function numeros_cuenta(){
    global $pdo;
    $stmt = $pdo->query("SELECT numero_cuenta FROM cuentas");
    $numeros_cuenta = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($numeros_cuenta);
};
function create_transacciones() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));

    // Paso 1: Obtener cuenta_id basado en numero_cuenta
    
        
        $stmt = $pdo->prepare("SELECT id FROM cuentas WHERE numero_cuenta = ?");
        $stmt->execute([$data->cuenta_id]);
        $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cuenta) {
            $cuenta_id = $cuenta['id'];
            $saldo_actual = $cuenta['saldo'];

            
            $stmt = $pdo->prepare("INSERT INTO transacciones (cuenta_id, tipo, monto, fecha) VALUES (?, ?, ?, ?)");
            $stmt->execute([$cuenta_id, $data->tipo, $data->monto, $data->fecha]);

            if ($data->tipo === 'deposito') {
                $nuevo_saldo = $saldo_actual + $data->monto;
                $stmt = $pdo->prepare("UPDATE cuentas SET saldo = saldo+? WHERE id = ?");
                $stmt->execute([$nuevo_saldo, $cuenta_id]);
                
            }
            if ($data->tipo === 'retiro') {
                $nuevo_saldo = $saldo_actual + $data->monto;
                $stmt = $pdo->prepare("UPDATE cuentas SET saldo = saldo-? WHERE id = ?");
                $stmt->execute([$nuevo_saldo, $cuenta_id]);
                
            }

            echo json_encode(["message" => "Transacción creada exitosamente"]);
        } 
}


function update_transaccion($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));

    $stmt = $pdo->prepare("UPDATE transacciones SET cuenta_id = ?, tipo = ?, monto = ?, fecha = ? WHERE id = ?");
    $stmt->execute([$data->cuenta_id, $data->tipo, $data->monto, $data->fecha, $id]);

    // Responder con un mensaje de éxito
    echo json_encode(["message" => "Transacción actualizada exitosamente"]);
};

function delete_transaccion($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM transacciones WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "cuentas deleted successfully"]);
};
?>