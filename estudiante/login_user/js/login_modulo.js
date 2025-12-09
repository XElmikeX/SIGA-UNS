const formLogin = document.querySelector(".login .form-login");
const inputEmail = document.querySelector(".form-login input[type='email']");
const inputPass = document.querySelector(".form-login input[type='password']");
const alertaExitoLogin = document.querySelector(".form-login .alerta-exito");
const alertaErrorLogin = document.querySelector(".form-login .alerta-error");

import { validarCampo,emailRegex,passwordRegex,estadoValidacionCampos,enviarFormulario } from "./register.js";

document.addEventListener("DOMContentLoaded", ()=>{
    formLogin.addEventListener("submit",e=>{
        //hace que no cargue el envio(no demora en cargar)
        estadoValidacionCampos.userName=true;
        //e.preventDefault();
        enviarFormulario(formLogin,alertaExitoLogin,alertaErrorLogin,e);
    });

    inputEmail.addEventListener("input",()=>{
        validarCampo(emailRegex,inputEmail,"El gmail puede contener un arroba,punto,contener,letras y guión bajo");
    })
    inputPass.addEventListener("input",()=>{
        validarCampo(passwordRegex,inputPass,"La contraseña debe tener de 4 a 16 digitos");
    })
});