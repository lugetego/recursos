let fuente = document.getElementById('solicitud_fuente');
let proyecto= document.getElementById("proyecto");

document.getElementById("solicitud_fuente").addEventListener(
    "change",
    () => {
        if ( fuente.value === 'CCM' || fuente.value === 'Ingresos extraordinarios'  ) {
            proyecto.hidden = true;
        }
        else {
            proyecto.hidden = false;
        }
    },
    false
);



