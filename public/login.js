// login.js
document.addEventListener('DOMContentLoaded', function () {
    var backButton = document.getElementById('backButton');

    if (backButton) {
        backButton.addEventListener('click', function () {
            // Regresa a la página anterior en el historial del navegador
            window.history.back();
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
    var registrarButton = document.getElementById('registrar');

    if (registrarButton) {
        registrarButton.addEventListener('click', function (e) {
            // Previene el comportamiento por defecto si es necesario
            e.preventDefault();
            // Redirige a la página de registro
            window.location.href = 'register.php';
        });
    } else {
        console.log('El botón de registro no está presente en el DOM.');
    }
});

// Asegúrate de que el DOM esté completamente cargado antes de añadir el listener al formulario
document.addEventListener('DOMContentLoaded', function () {
    // Añade un listener para el evento submit del formulario de inicio de sesión
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        // Previene el envío del formulario
        e.preventDefault();

        // Obtiene los valores del formulario
        const username = document.getElementById('loginUsername').value;
        const password = document.getElementById('loginPassword').value;

        // Encripta la contraseña con MD5
        const hashedPassword = CryptoJS.MD5(password).toString();

        // Crea un objeto usuario
        const user = {
            username,
            password: hashedPassword
        };

        // Llama a la función para iniciar sesión
        loginUser(user);
    });
});

// Asegúrate de que la función loginUser esté definida en tu script
function loginUser(user) {
    // Implementa la lógica de inicio de sesión aquí
    console.log('Iniciando sesión con:', user);
}




function loginUser(user) {
    fetch('../api/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(user)
    })

        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            console.log(response);

            return response.json();


        })
        .then(data => {
            if (data.success) {
                alert('Inicio de sesión exitoso.');
                window.location.href = 'menu.php'; // Ajusta esto según tu flujo
            } else {
                alert('Error al iniciar sesión: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al iniciar sesión:', error);
            alert('Ocurrió un error al intentar iniciar sesión. Por favor, inténtelo de nuevo.');
        });
}


function loadUsuarios() {
    fetch("../api/login.php")
        .then((response) => response.json())
        .then((usuarios) => {
            const listUsers = document.getElementById('loginList');
            listUsers.innerHTML = '';
            usuarios.forEach((usuario) => {
                const li = document.createElement('li');
                li.textContent = `${usuario.id} (${usuario.username})`;
                listUsers.appendChild(li);
            });
        });
}

loadUsuarios();