let tcProyecto = document.getElementById('solicitud_tcProyecto');
let tcCCM = document.getElementById('solicitud_tcCCM');
let tcIngresos = document.getElementById('solicitud_tcIngresos');
let taProyecto = document.getElementById('solicitud_taProyecto');
let taCCM = document.getElementById('solicitud_taCCM');
let taIngresos = document.getElementById('solicitud_taIngresos');

let importe = document.getElementById('solicitud_importe');



importe.readOnly = true;

importe.value = importe.value || 0;
tcProyecto.value = tcProyecto.value || 0;
tcCCM.value = tcCCM.value || 0;
taProyecto.value = taProyecto.value || 0;
taCCM.value = taCCM.value || 0;
taIngresos.value = taIngresos.value || 0;
tcIngresos.value = tcIngresos.value || 0;
document.addEventListener(
    "change",
    () => {
        // Function to safely parse the input values to numbers or default to 0 if invalid
        const parseToNumber = (value) => {
            return isNaN(parseFloat(value)) || value === "" ? 0 : parseFloat(value);
        };

        let sum = parseToNumber(tcProyecto.value) +
            parseToNumber(tcCCM.value) +
            parseToNumber(taProyecto.value) +
            parseToNumber(taCCM.value) +
            parseToNumber(tcIngresos.value) +
            parseToNumber(taIngresos.value);

        importe.value = sum;

    });



