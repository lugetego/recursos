let fuente = document.getElementById('solicitud_fuente');
let responsable = document.getElementById('solicitud_responsable');
let labelResponsable = document.querySelector("label[for='solicitud_responsable']");

// Verificar si responsable ya tiene un valor
if (responsable.value.trim() === "") {
    responsable.style.display = "none";
    labelResponsable.style.display = "none";
    responsable.removeAttribute("required");
}
fuente.addEventListener("change", () => {
    if (fuente.value.trim() === 'CCM' || fuente.value.trim() === 'Ingresos extraordinarios') {
        responsable.style.display = "none";
        labelResponsable.style.display = "none";
        responsable.removeAttribute("required"); // Quitar required cuando está oculto
        responsable.value="nada";
    } else {
        responsable.style.display = "block";
        labelResponsable.style.display = "block";
        responsable.setAttribute("required", "required"); // Agregar required cuando se muestra
    }
});
