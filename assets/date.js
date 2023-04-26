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
    });
    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
