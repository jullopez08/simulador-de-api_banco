<?php
session_start();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm">
            <label for="loginUsername">Nombre de usuario:</label>
            <input type="text" id="loginUsername" required>

            <label for="loginPassword">Contraseña:</label>
            <input type="password" id="loginPassword" required>

            <input type="submit" value="Iniciar Sesión"><br>

        </form>
        <input type="submit" id='registrar' value="Registrarse"><br>
    </div>

    <!-- Incluye el archivo de CryptoJS para encriptación MD5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <!-- Incluye el archivo JS de login -->
    <script src="login.js" defer></script>
</body>
</html>
