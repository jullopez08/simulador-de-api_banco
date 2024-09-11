document.addEventListener('DOMContentLoaded', function () {
    var backButton = document.getElementById('backButton');

    if (backButton) {
        backButton.addEventListener('click', function () {
            // Regresa a la página anterior en el historial del navegador
            window.history.back();
        });
    }
});


//EVENTO
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Encriptar la contraseña con MD5
        const hashedPassword = CryptoJS.MD5(password).toString();

        const user = {
            username,
            password: hashedPassword
        };
        console.log(username, password);
        registerUser(user);

    });
});


function registerUser(user) {
    fetch('../api/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(user)
    })
        .then(response => response.text())  // Cambia a text() para ver la respuesta sin parsear
        .then(text => {
            console.log('Respuesta del servidor:', text);
            return JSON.parse(text);  // Luego convierte el texto a JSON
        })
        .then(data => {
            if (data.success) {
                alert('Usuario registrado exitosamente.');
                window.location.href = 'index.php'; // Ajusta esto según tu flujo
            } else {
                alert('Error al registrar usuario: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al registrar usuario:', error);
        });
}

