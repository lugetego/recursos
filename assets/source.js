document.addEventListener("DOMContentLoaded", function () {
    let fuente = document.getElementById("solicitud_fuente");
    let responsable = document.getElementById("solicitud_responsable");
    let labelResponsable = document.querySelector("label[for='solicitud_responsable']");

    // Función para ocultar o mostrar según el valor de fuente
    function toggleResponsableVisibility() {
        if (fuente.value.trim() === "CCM" || fuente.value.trim() === "Ingresos extraordinarios") {
            responsable.style.display = "none";
            labelResponsable.style.display = "none";
            responsable.removeAttribute("required");
        } else {
            responsable.style.display = "block";
            labelResponsable.style.display = "block";
            responsable.setAttribute("required", "required");
        }
    }

    // Verificar si responsable tiene un valor en una edición
    if (responsable.value.trim() !== "") {
        // Mantiene el valor pero oculta si fuente es "CCM" o "Ingresos extraordinarios"
        toggleResponsableVisibility();
    } else {
        // Si no tiene valor, lo oculta por defecto
        responsable.style.display = "none";
        labelResponsable.style.display = "none";
        responsable.removeAttribute("required");
    }

    // Agregar evento de cambio en fuente
    fuente.addEventListener("change", toggleResponsableVisibility);
});
