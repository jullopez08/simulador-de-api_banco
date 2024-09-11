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
    <title>Página Principal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido</h1>
        <a href="usuarios.php">USUARIOS</a>
        <a href="transacciones.php">MOVIMIENTOS</a>
        <a href="cerrarsesion.php">CERRAR SESION</a>    
    </div>
</body>
</html>
