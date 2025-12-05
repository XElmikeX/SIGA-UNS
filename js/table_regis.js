/*CAMPOS DECLARADOS */
const formRegister = document.getElementById("form");
const userName = document.querySelector("form input[type='text']");
const userEmail = document.querySelector("form input[type='email']");
const userPassword = document.querySelector("form input[type='password']");

/*REGLAS DE LOS CAMPOS */
const reglaName = /^[a-zA-Z0-9\_\-]{3,16}$/;
const reglaEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9]+$/;
const reglaPassword = /^.{4,16}$/;

/*VERIFICACION DE QUE TODO CUMPLA */
const envioDeFormulario = {
    userName: false,
    userEmail: false,
    userPassword: false,
};

// Clave para el localStorage
const STORAGE_KEY = 'usuarios_registrados';

document.addEventListener("DOMContentLoaded", () => {
    // Cargar usuarios existentes al iniciar la página
    cargarUsuariosGuardados();
    
    formRegister.addEventListener("submit", e => {
        e.preventDefault(); // Prevenir envío normal del formulario
        enviarFormulario(e);
    });

    userName.addEventListener("input", () => {
        validarCampo(reglaName, userName, "El nombre acepta de 3 a 16 digitos( + - . _ )");
    });
    userEmail.addEventListener("input", () => {
        validarCampo(reglaEmail, userEmail, 'Debe contener un arroba "@","."');
    });
    userPassword.addEventListener("input", () => {
        validarCampo(reglaPassword, userPassword, "Debe tener de 4 a 16 cifras");
    });
});

function validarCampo(regla, campo, mensaje) {
    const verificacion = regla.test(campo.value);
    if (verificacion) {
        envioDeFormulario[campo.name] = true;
        eliminarAlerta(campo.parentElement.parentElement);
        campo.parentElement.classList.remove("border");
        return;
    }
    mostrarAlerta(campo.parentElement.parentElement, mensaje);
    envioDeFormulario[campo.name] = false;
    campo.parentElement.classList.add("border");
}

function mostrarAlerta(referencia, mensaje) {
    eliminarAlerta(referencia);
    const crearDiv = document.createElement("div");
    crearDiv.classList.add("alertaError");
    crearDiv.textContent = mensaje;
    referencia.appendChild(crearDiv);
}

function eliminarAlerta(referencia) {
    const alerta = referencia.querySelector(".alertaError");
    if (alerta) {
        alerta.remove();
    }
}

/*ENVIO DEL FORMULARIO CORRECTAMENTE*/ 
const alertaExito = document.querySelector("form div .alerta-correct");
const alertaError = document.querySelector("form div .alerta-deneg");

function enviarFormulario(e) {
    if (envioDeFormulario.userName && envioDeFormulario.userEmail && envioDeFormulario.userPassword) {
        
        // Enviar datos en AJAX
        const formData = new FormData(formRegister);
        
        // Asegúrate de que la URL sea correcta
        fetch('php/proceso-register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            /*convierte a json la respuesta */
            return response.json();
        })
        /*Data agarra lo convertido */
        .then(data => {
            if (data.success) {
                // Éxito - mostrar alerta y agregar a la tabla
                envioDeFormulario.userName = false;
                envioDeFormulario.userEmail = false;
                envioDeFormulario.userPassword = false;

                alertaExito.classList.add("envioExito");
                alertaError.classList.remove("envioError");
                alertaExito.textContent = data.message;

                // Agregar a la tabla Y guardar en localStorage
                insertRowInTransactionTable(data.user);
                guardarUsuarioEnStorage(data.user);

                // Limpiar formulario
                formRegister.reset();

                setTimeout(() => {
                    alertaExito.classList.remove("envioExito");
                }, 3500);
            } else {
                // Error del servidor
                alertaExito.classList.remove("envioExito");
                alertaError.classList.add("envioError");
                alertaError.textContent = data.message;

                setTimeout(() => {
                        alertaError.classList.remove("envioError");
                }, 3500);
            }
        })
        .catch(error => {
            /*error externo(base de datos, ID, CLASS,...) */
            alertaExito.classList.remove("envioExito");
            alertaError.classList.add("envioError");
            alertaError.textContent = "Error de conexión: " + error.message;

            setTimeout(() => {
                alertaError.classList.remove("envioError");
            }, 3500);
        });

    } else {
        // Validación local falló
        alertaExito.classList.remove("envioExito");
        alertaError.classList.add("envioError");
        alertaError.textContent = "Completa todos los campos correctamente";

        setTimeout(() => {
            alertaError.classList.remove("envioError");
        }, 3500);
    }
}

/*CREACION DE LA FILA (SIMULADOR BASE DE DATOS) */
function insertRowInTransactionTable(transactionObj) {
    let transactionTableRef = document.getElementById("registro");
    let newTransactionRowRef = transactionTableRef.insertRow(-1);

    let newTypeCellRef = newTransactionRowRef.insertCell(0);
    newTypeCellRef.textContent = transactionObj["userName"];

    newTypeCellRef = newTransactionRowRef.insertCell(1);
    newTypeCellRef.textContent = transactionObj["userEmail"];

    newTypeCellRef = newTransactionRowRef.insertCell(2);
    newTypeCellRef.textContent = transactionObj["userPassword"];
}

/* FUNCIONES PARA PERSISTENCIA EN LOCALSTORAGE */

// Guardar un usuario en el localStorage
function guardarUsuarioEnStorage(usuario) {
    // Obtener usuarios existentes
    const usuariosGuardados = obtenerUsuariosDelStorage();
    
    // Agregar el nuevo usuario
    usuariosGuardados.push(usuario);
    
    // Guardar en localStorage
    localStorage.setItem(STORAGE_KEY, JSON.stringify(usuariosGuardados));
    /*objeto - texto */
}

// Obtener todos los usuarios del localStorage
function obtenerUsuariosDelStorage() {
    const usuariosJSON = localStorage.getItem(STORAGE_KEY);
    /*condicion ? true : else */
    return usuariosJSON ? JSON.parse(usuariosJSON) : [];
    /*texto - objeto */
}

// Cargar usuarios guardados al iniciar la página
function cargarUsuariosGuardados() {
    const usuarios = obtenerUsuariosDelStorage();
    
    usuarios.forEach(usuario => {
        insertRowInTransactionTable(usuario);
    });
}

// Función para limpiar todos los datos
function limpiarTabla() {
    localStorage.removeItem(STORAGE_KEY);
    
    // Recargar la tabla
    const transactionTableRef = document.getElementById("registro");

    // Eliminar todas las filas excepto el header
    while (transactionTableRef.rows.length > 1) {
        transactionTableRef.deleteRow(1);
    }
}

// colocar en la consola para eliminar la tabla
window.limpiarTabla = limpiarTabla;

