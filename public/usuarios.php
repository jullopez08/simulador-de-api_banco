
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
    <title>Gestión lista de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
    <h2>Lista de Usuarios</h2>
    <ul id="loginList"></ul>
    <input type="submit" id="backButton" value="Atrás">
</div>

        

 

    </div>
    <script src="login.js" defer></script>
</body>

</html>
