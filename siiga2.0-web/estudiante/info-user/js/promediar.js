document.addEventListener('DOMContentLoaded',()=>{
    const dato1 = document.querySelector(".dato1");
    const dato2 = document.querySelector(".dato2");
    const dato3 = document.querySelector(".dato3");
    const valorPromedio = document.querySelector(".promedio");
    const btnPromediar = document.getElementById("btn1");
    const btnLimpiar = document.getElementById("btn2");

    function promedioExito(){
        const value1 = parseFloat(dato1.value) || 0;
        const value2 = parseFloat(dato2.value) || 0;
        const value3 = parseFloat(dato3.value) || 0;

        const promedio = (value1 + value2 + value3)/3;

        valorPromedio.value = promedio.toFixed(2);
    };

    function limpiadoExito(){
        dato1.value = '';
        dato2.value = '';
        dato3.value = '';
        valorPromedio.value='';
        dato1.focus();
    };

    btnPromediar.addEventListener('click', promedioExito);
    btnLimpiar.addEventListener('click', limpiadoExito);

    document.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            promedioExito();
        }
    });

});
