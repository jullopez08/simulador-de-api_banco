document.addEventListener("DOMContentLoaded", function () {
  // select de los numeros de cuenta 
  fetch("../api/transaccion.php?action=numeros_cuenta")
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la respuesta de la API");
      }
      return response.json();
    })
    .then((data) => {
      const select = document.getElementById("cuenta_id");
      data.forEach((cuenta) => {
        const option = document.createElement("option");
        option.value = cuenta.numero_cuenta;
        option.textContent = cuenta.numero_cuenta;
        select.appendChild(option);
      });
    });
});


//fecha automatica
window.addEventListener("load", function () {
  const today = new Date();
  const formattedDate = today.toISOString().slice(0, 10);
  document.getElementById("fecha").value = formattedDate;
})
// Manejar el envío del formulario
document
  .getElementById("form-transaccion")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const id = document.getElementById("idTransaccion").value;
    const numero_cuenta = document.getElementById("cuenta_id").value;
    const tipo = document.getElementById("tipo").value;
    const monto = document.getElementById("monto").value;
    const fecha = document.getElementById("fecha").value;

    const transaccion = {
      cuenta_id: numero_cuenta,
      tipo: tipo,
      monto: monto,
      fecha: fecha
    };
    if (id) {
      // Actualizar transacción existente
      updateTransaccion(id, transaccion);
    } else {
      // Crear nueva transacción
      createTransaccion(transaccion);
    }
  });

// Función para crear una nueva transacción
function createTransaccion(transaccion) {
  console.log(transaccion);

  fetch("../api/transaccion.php", {
    method: "POST",
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(transaccion),
  }).then((response) => response.json())
    .then((data) => {
      console.log(data);
      loadTransacciones();
    });
  location.reload();

}

// Función para actualizar una transacción existente
function updateTransaccion(id, transaccion) {
  fetch(`../api/transaccion.php?id=${id}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(transaccion),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      loadTransacciones();
      document.getElementById("idTransaccion").value = "";
    })
    .catch((error) => {
      console.error("Error al actualizar la transacción:", error);
    });
}

// Función para eliminar una transacción
function deleteTransaccion(id) {
  fetch(`../api/transaccion.php?id=${id}`, {
    method: "DELETE",
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      loadTransacciones();
    });
}

// Función para cargar transacciones
function loadTransacciones() {
  fetch("../api/transaccion.php")
    .then((response) => response.json())
    .then((transacciones) => {
      const transaccionList = document.getElementById('transaccionList');
      transaccionList.innerHTML = '';
      transacciones.forEach((transaccion) => {
        const li = document.createElement('li');
        li.textContent = `${transaccion.numero_cuenta} (${transaccion.tipo}) (${transaccion.monto}) (${transaccion.fecha})`;
        li.appendChild(createDeleteButtonTr(transaccion.id)); // Asumiendo que cada transacción tiene un ID único
        transaccionList.appendChild(li);
      });
    });
}

// Función para crear un botón de eliminación
function createDeleteButtonTr(id) {
  const button = document.createElement("button");
  button.textContent = "Eliminar";
  button.onclick = () => deleteTransaccion(id);
  return button;
}

// Cargar transacciones al inicio

loadTransacciones();                                                              
