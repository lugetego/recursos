let participacion = document.getElementById('solicitud_motivo_1');
let asistencia = document.getElementById("solicitud_motivo_0");

let actividad = document.getElementById('solicitud_tipoActividad');
let titulo = document.getElementById('solicitud_tituloActividad');

/*// Disable both elements initially
actividad.disabled = true;
titulo.disabled = true;*/

// Función para verificar y deshabilitar si no tienen valor
function checkAndDisable(element) {
    element.disabled = !element.value.trim();
}

// Ejecutar la verificación al cargar la página
checkAndDisable(actividad);
checkAndDisable(titulo);

document.getElementById("solicitud_motivo_1").addEventListener(
    "change",
    () => {
        if (participacion.checked) { // assuming it's a checkbox
            // Enable the elements when participacion is checked
            actividad.disabled = false;
            titulo.disabled = false;
            document.getElementById("participacion").innerText = "Cuando el motivo seleccionado es 'Participación' " +
                "debe seleccionar un 'Tipo de actividad' y proporcionar el 'Título de la actividad'";

        } else {
            // Disable the elements if participacion is not checked
            actividad.disabled = true;
            titulo.disabled = true;
        }
    },
    false
);
