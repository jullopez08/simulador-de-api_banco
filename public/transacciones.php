<?php
session_start();

// Verificar si la sesión del usuario está activa
if (!isset($_SESSION['username'])) {
    // Si no hay sesión, redirigir al usuario al formulario de login
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cuentas Bancarias</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="containerTrans">
        <div>
        <input type="submit" id="backButton" value="Atrás">

        </div>
        <h1>Gestión de Cuentas Bancarias</h1>
        
        
        <!-- Formulario para crear una cuenta -->
        <div class="left">
            <h2>Crear Cuenta</h2>
            <form id="cuentaForm">
                <input type="hidden" id="cuentaId">
                
                <label for="nombre_titular">Nombre del Titular:</label>
                <input type="text" id="nomTitular" name="nomTitular" required>
                
                <label for="numero_cuenta">Número de Cuenta:</label>
                <input type="text" id="numCuenta" name="numCuenta" required>
                
                <label for="saldo">Saldo:</label>
                <input type="number" id="saldo" name="saldo" step="0.01" value="0.00" required>
                
                <input type="submit" value="Crear Cuenta">
            </form>
            <h2>Lista de Cuentas</h2>
            <ul id="cuentaList"></ul>
        </div>

        <!-- Formulario para realizar una transacción -->
        <div class="right">
    <h2>Gestión de Transacciones</h2>
    <form id="form-transaccion">
        <input type="hidden" id="idTransaccion">
        
        <label for="cuenta_id">Seleccione la Cuenta:</label>
        <select id="cuenta_id" name="cuenta_id" required>
            <!-- Los números de cuenta serán insertados aquí -->
        </select>

        <label for="tipo">Tipo de Transacción:</label>
        <select id="tipo" name="tipo" required>
            <option value="deposito">Depósito</option>
            <option value="retiro">Retiro</option>
        </select>

        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" step="0.01" required>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" readonly>

        <input type="submit" value="Crear Transacción">
    </form>
    <h2>Lista de Transacciones</h2>
    <ul id="transaccionList"></ul>
</div>

        

 

    </div>
    <script src="script.js"></script>
    <script src="transacciones.js"></script>
</body>

</html>
