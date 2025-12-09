const formRegister = document.querySelector(".register .form-register");
const inputUser = document.querySelector(".form-register input[type='text']");
const inputEmail = document.querySelector(".form-register input[type='email']");
const inputPass = document.querySelector(".form-register input[type='password']");


//Permite como debe ser el input introducido
const userNameRegex = /^[a-zA-Z0-9\_\-]{4,16}$/;
export const emailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9]+\.[a-zA-Z0-9-.]+$/;
export const passwordRegex = /^.{4,16}$/;

/*VERIFICAR SI TODOS LOS INPUT SE LLENARON CORRECTAMENE */
export const estadoValidacionCampos = {
    userName: false,
    userEmail: false,
    userPassword: false,
};

//Para asegurarnos que primero carge la pagina
//y luego se pueda enviar los datos a la base de datos (correctamente)
document.addEventListener("DOMContentLoaded", ()=>{
    formRegister.addEventListener("submit",e=>{
        //hace que no cargue el envio(no demora en cargar)
        //e.preventDefault();
        enviarFormulario(formRegister,alertaExito,alertaError,e);
    });

    inputUser.addEventListener("input",()=>{
        validarCampo(userNameRegex,inputUser,"El usuario tiene que ser de 4 a 16 digitos y solo puede contener,letras y guión bajo");
    })
    inputEmail.addEventListener("input",()=>{
        validarCampo(emailRegex,inputEmail,"El gmail puede contener un arroba,punto,contener,letras y guión bajo");
    })
    inputPass.addEventListener("input",()=>{
        validarCampo(passwordRegex,inputPass,"La contraseña debe tener de 4 a 16 digitos");
    })
});

export function validarCampo(regularExpresion,campo,mensaje){
    const validarCampo = regularExpresion.test(campo.value);
    if (validarCampo){
        /* es quien elimina todas las alertas */
        eliminarAlerta(campo.parentElement.parentElement);
        estadoValidacionCampos[campo.name] = true;
        campo.parentElement.classList.remove("error");
        return;
    }
    mostrarAlerta(campo.parentElement.parentElement,mensaje);
    estadoValidacionCampos[campo.name] = false;
    campo.parentElement.classList.add("error");
};

/*--- Mostrar el div con el mensaje de corregir --- */
function mostrarAlerta(referencia,mensaje){
    eliminarAlerta(referencia)
    const alertaDiv = document.createElement("div");
    alertaDiv.classList.add("alerta");
    alertaDiv.textContent = mensaje;
    referencia.appendChild(alertaDiv);
};

/*--- Para que solo halla una alerta --- */
function eliminarAlerta(referencia){
    const alerta = referencia.querySelector(".alerta")
    if (alerta){
        alerta.remove()
    }
};

/**
 * SI TODO ESTA CORRECTO
 * YA LO PUEDE ENVIAR
 * EL FORMULARIO
 */
const alertaExito = document.querySelector(".form-register .alerta-exito");
const alertaError = document.querySelector(".form-register .alerta-error");

export function enviarFormulario(form,alertaExito,alertaError,e){
    if (estadoValidacionCampos.userName && estadoValidacionCampos.userEmail && estadoValidacionCampos.userPassword) {
        estadoValidacionCampos.userName = false;
        estadoValidacionCampos.userEmail = false;
        estadoValidacionCampos.userPassword = false;
        
        alertaError.classList.remove("alertaError");
        alertaExito.classList.add("alertaExito");
        //form.reset();
        /*tiempo q estara*/
        setTimeout(() => {
        alertaExito.classList.remove("alertaExito")
        }, 3000);
        return;
    }
    e.preventDefault();
    alertaExito.classList.remove("alertaExito");
    alertaError.classList.add("alertaError");
    /*tiempo q estara*/
    setTimeout(() => {
    alertaError.classList.remove("alertaError");
    }, 3000);
    
};
