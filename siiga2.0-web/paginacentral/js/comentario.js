const formComent = document.getElementById("form");
const userEmail = document.querySelector(".gmail");
const userComent = document.querySelector(".coment");

const reglaEmail = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9]+\.[a-zA-Z0-9-.]+$/;
const reglaComent = /^.{3,150}$/;

const valuacionDeCampos = {
    gmail: false,
    comentario: false,
};

document.addEventListener("DOMContentLoaded",()=>{
    formComent.addEventListener("submit",e=>{
        //e.preventDefault();
        enviarFormulario(e);
    });

    userEmail.addEventListener("input",()=>{
        verificarCampo(reglaEmail,userEmail);
    });
    userComent.addEventListener("input",()=>{
        verificarCampo(reglaComent,userComent);
    });
});

function verificarCampo(regla,campo){
    const verificar = regla.test(campo.value);
    if (verificar){
        campo.classList.remove("border");
        valuacionDeCampos[campo.name]=true;
        return;
    }
    campo.classList.add("border");
    valuacionDeCampos[campo.name]=false;
    
};

const alertaExito = document.querySelector(".alerta-exito");
const alertaError = document.querySelector(".alerta-error");

function enviarFormulario(e){

    /*ES UNA VALIDACION POR SEGUNDA VEZ*/
    verificarCampo(reglaEmail, userEmail);
    verificarCampo(reglaComent, userComent);

    if(valuacionDeCampos.gmail && valuacionDeCampos.comentario) {

        const formData = new FormData(formComent);

        const url = 'php/comentarios.php';

        fetch(url,{
            method: 'POST',
            body: formData
        })

        .then(response=>{
            return response.json();
        })

        .then(data=>{
            if(data.success){
                valuacionDeCampos.gmail = false;
                valuacionDeCampos.comentario = false;
                
                alertaError.classList.remove("alertaError");
                alertaExito.classList.add("alertaExito");
                alertaExito.textContent = data.message;

                setTimeout(()=>{
                    alertaExito.classList.remove("alertaExito");
                }, 3500);
            }else{
                e.preventDefault();
                alertaExito.classList.remove("alertaExito");
                alertaError.classList.add("alertaError");
                alertaError.textContent = data.message;

                setTimeout(()=>{
                    alertaError.classList.remove("alertaError");
                }, 3500);
            }
        })

        .then(error=>{
            e.preventDefault();
            alertaExito.classList.remove("alertaExito");
            alertaError.classList.add("alertaError");
            alertaError.textContent = "Error:" + error.message;

            setTimeout(()=>{
                alertaError.classList.remove("alertaError");
            }, 3500);
        })  
    }else{
        e.preventDefault();
        alertaExito.classList.remove("alertaExito");
        alertaError.classList.add("alertaError");
        alertaError.textContent = "Rellene correctamente";

        setTimeout(()=>{
            alertaError.classList.remove("alertaError");
        }, 3500);
    }
    
};

const borrar = document.querySelector("button[type='reset']");
borrar.addEventListener("click",()=>{
    userEmail.classList.remove("border");
    userComent.classList.remove("border");
});