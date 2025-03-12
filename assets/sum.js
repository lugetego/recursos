let tcProyecto = document.getElementById('solicitud_tcProyecto');
let tcCCM = document.getElementById('solicitud_tcCCM');
let taProyecto = document.getElementById('solicitud_taProyecto');
let taCCM = document.getElementById('solicitud_taCCM');
let importe = document.getElementById('solicitud_importe');



importe.readOnly = true;

importe.value = importe.value || 0;
tcProyecto.value = tcProyecto.value || 0;
tcCCM.value = tcCCM.value || 0;
taProyecto.value = taProyecto.value || 0;
taCCM.value = taCCM.value || 0;
document.addEventListener(
    "change",
    () => {
        sum = parseFloat(tcProyecto.value) + parseFloat(tcCCM.value) + parseFloat(taProyecto.value) + parseFloat(taCCM.value);
        importe.value = sum;

    });


