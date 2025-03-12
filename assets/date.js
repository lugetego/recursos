/*
$(function() {
   /!* document.getElementById('fecha_inicio').style.display = "none";
    document.getElementById('fecha_fin').style.display = "none";

*!/

    let finicio = document.getElementById('solicitud_inicio').value;
    let ffin = document.getElementById('solicitud_fin').value;

   /!* if (finicio && ffin) {

        document.getElementById('fecha_inicio').hidden = false;
        document.getElementById('fecha_fin').hidden =false;
        let daterangeContainer = document.getElementById('daterange-container');

        daterangeContainer.style.display = "none";

    }*!/

   /!* $('input[name="daterange"]').daterangepicker({
        autoUpdateInput: false,
        opens: 'left',
        autoApply: true,
    }, function(start, end, label,picker) {
        console.log("A new date sesslection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
        document.getElementById('solicitud_inicio').value = start.format('YYYY-MM-DD');
        document.getElementById('solicitud_fin').value= end.format('YYYY-MM-DD');
*!/
        let inicio = new Date(finicio);
        let fin = new Date(ffin);


        let diffTime = Math.abs(fin - inicio);
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        let importe = document.getElementById("solicitud_importe").value;

        document.getElementById("dias").innerHTML = "Solicitud de recursos con duración de "+ diffDays + " días";
/!*

    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
*!/

    // Add custom form submission validation for daterange
    $('form').on('submit', function(e) {

     /!*   let finInput = document.getElementById('solicitud_fin');

        if (finInput.style.display === "none") {
            finInput.removeAttribute("required"); // Evitar que cause error
        }

        let daterangeValue = $('input[name="daterange"]').val();*!/

        alert("si");
        // Check if the daterange input is empty
        if (!daterangeValue ) {
            e.preventDefault();  // Prevent form submission
            // Display error message below the daterange input field
            document.getElementById('daterange-error-msg').innerHTML = 'Por favor, seleccione un rango de fechas.';
            document.getElementById('daterange-error-msg').style.color = 'red';  // Optional: change text color to red
        } else {
            // Clear the error message when the daterange is filled
            document.getElementById('daterange-error-msg').innerHTML = '';
        }
    });

});
*/


document.querySelectorAll('#solicitud_inicio, #solicitud_fin').forEach(input => {
    input.addEventListener('change', function() {
        let finicio = document.getElementById('solicitud_inicio').value;
        let ffin = document.getElementById('solicitud_fin').value;
        let errorMsg = document.getElementById("daterange-error-msg");

        if (finicio && ffin) {
            let startDate = new Date(finicio);
            let endDate = new Date(ffin);

            // Validar que fecha_inicio no sea mayor que fecha_fin
            if (startDate > endDate) {
                errorMsg.innerText = "La fecha de inicio no puede ser mayor que la fecha de fin.";
                errorMsg.style.color = "red";
                document.getElementById("solicitud_fin").value = ""; // Limpiar fecha fin incorrecta
                return;
            } else {
                errorMsg.innerText = ""; // Limpiar mensaje si la validación es correcta
            }

            let diffTime = endDate - startDate;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // Si las fechas son iguales, contar al menos 1 día
            diffDays = diffDays === 0 ? 1 : diffDays;

            console.log("Días de diferencia:", diffDays);
            document.getElementById("dias").innerText = "Duración: " + diffDays + " días";
        }
    });
});

