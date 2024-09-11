document.addEventListener('DOMContentLoaded', function () {
    var backButton = document.getElementById('backButton');

    if (backButton) {
        backButton.addEventListener('click', function () {
            // Regresa a la página anterior en el historial del navegador
            window.history.back();
        });
    }
});

// Manejar la creación y actualización de cuentas
document.getElementById('cuentaForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('cuentaId').value;
    const nombre_titular = document.getElementById('nomTitular').value;
    const numero_cuenta = document.getElementById('numCuenta').value;
    const saldo = document.getElementById('saldo').value;
    if (id) {
        updateCuenta(id, { nombre_titular, numero_cuenta, saldo });
        console.log('entra aca a actualizar');
        console.log(id, nombre_titular, numero_cuenta, saldo);
    } else {
        createCuenta({ nombre_titular, numero_cuenta, saldo });
        console.log('entra aca a crear cuenta');
    }
});



function createCuenta(cuenta) {
    fetch('../api/cuenta.php',
        {
            method: 'POST',
            headers: {
                'Content_type': 'application/json'
            },
            body: JSON.stringify(cuenta)
        }
    ).then(response => response.json()).then(data => {
        console.log(data);
        loadCuentas()
    });
    location.reload();
}
function updateCuenta(id, cuenta) {
    fetch(`../api/cuenta.php?id=${id}`,
        {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(cuenta)
        }).then(response => response.json()).then(data => {
            console.log(data);
            loadCuentas();
            document.getElementById('cuentaId').value = '';
        });
}

function deleteCuenta(id) {
    fetch(`../api/cuenta.php?id=${id}`, {
        method: 'DELETE'
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            loadCuentas();
        });
}


function loadCuentas() {
    fetch('../api/cuenta.php')
        .then(response => response.json())
        .then(cuentas => {
            const cuentaList = document.getElementById('cuentaList');
            cuentaList.innerHTML = '';
            cuentas.forEach(cuenta => {
                const li = document.createElement('li');
                li.textContent = `${cuenta.nombre_titular} (${cuenta.numero_cuenta}) - Saldo: ${cuenta.saldo} - Fecha: ${cuenta.fecha_creacion}`;
                li.appendChild(createDeleteButton(cuenta.id));
                li.appendChild(createEditButton(cuenta));
                cuentaList.appendChild(li);
            });
        });
}

function createDeleteButton(id) {
    const button = document.createElement('button');
    button.textContent = 'Eliminar';
    button.onclick = () => deleteCuenta(id);
    return button;
}

function createEditButton(cuenta) {
    const button = document.createElement('button');
    button.textContent = 'Editar';
    button.onclick = () => {
        document.getElementById('cuentaId').value = cuenta.id;
        document.getElementById('nomTitular').value = cuenta.nombre_titular;
        document.getElementById('numCuenta').value = cuenta.numero_cuenta;
        document.getElementById('saldo').value = cuenta.saldo;
        console.log(`EDITAR `)
    };

    return button;
}

// Cargar cuentas al inicio
loadCuentas();