let fuente = document.getElementById('solicitud_fuente');
let responsable = document.getElementById('solicitud_responsable');
let labelResponsable = document.querySelector("label[for='solicitud_responsable']");

// Mantener el valor si ya existe
if (responsable.value.trim() !== "") {
    responsable.style.display = "block";
    labelResponsable.style.display = "block";
} else {
    responsable.style.display = "none";
    labelResponsable.style.display = "none";
}

fuente.addEventListener("change", () => {
    if (fuente.value.trim() === 'CCM' || fuente.value.trim() === 'Ingresos extraordinarios') {
        responsable.style.display = "none";
        labelResponsable.style.display = "none";
        responsable.removeAttribute("required");
        responsable.setAttribute("data-keep", "true"); // Marcamos el campo
    } else {
        responsable.style.display = "block";
        labelResponsable.style.display = "block";
        responsable.setAttribute("required", "required");
        responsable.removeAttribute("data-keep"); // Eliminamos el marcador
    }
});

// Evitar que Symfony lo tome como NULL al enviar el formulario
document.querySelector("form").addEventListener("submit", () => {
    if (responsable.hasAttribute("data-keep")) {
        responsable.value = " "; // Espacio en blanco en lugar de NULL
    }
});
