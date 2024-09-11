<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Registrar</h2>
        <form id="registerForm">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" required>

            <input type="submit" value="Registrar"><br>
        </form>
        <input type="submit" id="backButton" value="Atrás">
    </div>

    <!-- Incluye el archivo de CryptoJS para encriptación MD5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <!-- Incluye el archivo JS de registro -->
    <script src="register.js"></script>
</body>
</html>
