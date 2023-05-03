let alimentos = document.getElementById('solicitud_alimentos');
let gasolina = document.getElementById('solicitud_gasolina');
let importe = document.getElementById('solicitud_importe');
let hospedaje = document.getElementById('solicitud_hospedaje');
let transporte = document.getElementById('solicitud_transporte');
let peaje = document.getElementById('solicitud_peaje');


importe.readOnly = true;

let sum = importe.value = gasolina.value = alimentos.value = hospedaje.value = transporte.value =
    peaje.value= 0;

document.addEventListener(
    "change",
    () => {
        sum = parseFloat(alimentos.value) + parseFloat(gasolina.value) + parseFloat(transporte.value) + parseFloat(hospedaje.value) + parseFloat(peaje.value);
        importe.value = sum;

    });


