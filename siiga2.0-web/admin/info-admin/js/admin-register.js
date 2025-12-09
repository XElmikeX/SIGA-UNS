/*CAMPOS DECLARADOS */
const formRegister = document.getElementById("form");
const userName = document.querySelector("form input[type='text']");
const userEmail = document.querySelector("form input[type='email']");
const userPassword = document.querySelector("form input[type='password']");

/*REGLAS DE LOS CAMPOS */
const reglaName = /^[a-zA-Z0-9\_\-]{3,16}$/;
const reglaEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9]+$/;
const reglaPassword = /^.{4,16}$/;

/*VERIFICACION DE TE TODO CUMPLA */
const envioDeFormulario ={
    transactionDescription: false,
    transactionAmount: false,
    transactionCategory: false,
};

document.addEventListener("DOMContentLoaded",()=>{
    formRegister.addEventListener("submit",e=>{
        enviarFormulario(e);
    });

    userName.addEventListener("input",()=>{
        validarCampo(reglaName,userName,"El nombre acepta de 3 a 16 digitos( + - . _ )");
    });
    userEmail.addEventListener("input",()=>{
        validarCampo(reglaEmail,userEmail,'Debe contener un arroba "@","."');
    });
    userPassword.addEventListener("input",()=>{
        validarCampo(reglaPassword,userPassword,"Debe tener de 4 a 16 cifras");
    });
});

function validarCampo(regla,campo,mensaje){
    const verificacion = regla.test(campo.value);
    if (verificacion){
        envioDeFormulario[campo.name] = true;
        eliminarAlerta(campo.parentElement.parentElement);
        campo.parentElement.classList.remove("border");
        return;

    }
    mostrarAlerta(campo.parentElement.parentElement,mensaje);
    envioDeFormulario[campo.name] = false;
    campo.parentElement.classList.add("border");
};

function mostrarAlerta(referencia,mensaje){
    eliminarAlerta(referencia);
    const crearDiv = document.createElement("div");
    crearDiv.classList.add("alertaError");
    crearDiv.textContent = mensaje;
    referencia.appendChild(crearDiv);
};

function eliminarAlerta(referencia){
    const alerta = referencia.querySelector(".alertaError");
    if (alerta){
        alerta.remove();
    }
};


/*ENVIO DEL FORMULARIO CORRECTAMENTE*/ 

const alertaExito = document.querySelector("form div .alerta-correct");
const alertaError = document.querySelector("form div .alerta-deneg");

function enviarFormulario(e){
    if(envioDeFormulario.transactionDescription && envioDeFormulario.transactionAmount && envioDeFormulario.transactionCategory){
        envioDeFormulario.transactionDescription = false;
        envioDeFormulario.transactionAmount = false;
        envioDeFormulario.transactionCategory = false;

        alertaExito.classList.add("envioExito");
        alertaError.classList.remove("envioError");

        setTimeout(()=>{
            alertaExito.classList.remove("envioExito");
        }, 3500);

        tabla();
        return;

    }
    e.preventDefault();
    alertaExito.classList.remove("envioExito");
    alertaError.classList.add("envioError");

    setTimeout(()=>{
        alertaError.classList.remove("envioError");
    }, 3500)
};

/*CREACION DE LA FILA (SIMULADOR BASE DE DATOS) */
function tabla(){
    let transactionFormData = new FormData(form);
    let transactionObj = convertFormDataToTransactionObj(transactionFormData);
    insertRowInTransactionTable(transactionObj);
}

function convertFormDataToTransactionObj(transactionFormData){
    let transactionDescription = transactionFormData.get("transactionDescription");
    let transactionAmount = transactionFormData.get("transactionAmount");
    let transactionCategory = transactionFormData.get("transactionCategory");
    return{
        "transactionDescription": transactionDescription,
        "transactionAmount": transactionAmount,
        "transactionCategory": transactionCategory
    }
}

function insertRowInTransactionTable(transactionObj){
    let transactionTableRef = document.getElementById("registro");

    let newTransactionRowRef = transactionTableRef.insertRow(-1);

    let newTypeCellRef = newTransactionRowRef.insertCell(0);
    newTypeCellRef.textContent = transactionObj["transactionDescription"];

    newTypeCellRef = newTransactionRowRef.insertCell(1);
    newTypeCellRef.textContent = transactionObj["transactionAmount"];

    newTypeCellRef = newTransactionRowRef.insertCell(2);
    newTypeCellRef.textContent = transactionObj["transactionCategory"];
}


