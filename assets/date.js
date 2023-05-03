$(function() {
    document.getElementById('fecha_inicio').hidden = true;
    document.getElementById('fecha_fin').hidden =true;

    $('input[name="daterange"]').daterangepicker({
        autoUpdateInput: false,
        opens: 'left',
        autoApply: true,
    }, function(start, end, label,picker) {
        console.log("A new date sesslection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
        document.getElementById('solicitud_inicio').value = start.format('YYYY-MM-DD');
        document.getElementById('solicitud_fin').value= end.format('YYYY-MM-DD');

        let inicio = new Date(start);
        let fin = new Date(end);
        let diffTime = Math.abs(fin - inicio);
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        let nacional= document.querySelector('input[name="solicitud[nacional]"]:checked').value;
        let importe = document.getElementById("solicitud_importe").value;

        let internacional= document.getElementById('solicitud_nacional_1');
        let maxNac = diffDays * 1580;
        let maxInt = diffDays * 4700;

        document.getElementById("dias").innerHTML = "Licencia o comisión con duración de "+ diffDays + " días";

       document.addEventListener(
            "change",
            () => {

                if(document.getElementById('solicitud_nacional_0').checked) {
                    document.getElementById("maxNac").innerHTML = "$"+ maxNac.toFixed(2) +" es el monto máximo para licencia o comisión nacional";
                    document.getElementById("maxInt").innerHTML = '';
                    console.log("nacional");
                    console.log("importe "+importe);
                    console.log("dias nacional"+ diffDays);

                }
                else if(document.getElementById('solicitud_nacional_1').checked) {
                    document.getElementById("maxInt").innerHTML = "$"+ maxInt.toFixed(2) +" es el monto máximo para licencia o comisión internacional";
                    document.getElementById("maxNac").innerHTML = '';
                    console.log("internacional ");
                    console.log("dias internacionales"+ diffDays);
                }


            });

        document.addEventListener(
            "keyup",
            () => {
               if (importe === '500'){
                   alert(importe)
               }


    });



    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });



});
