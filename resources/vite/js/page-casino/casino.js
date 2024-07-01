
$(document).ready(function () {
    $("#add-time li a").click(function () {
        var date_start = $(this).data('date-start');
        $("#js__two-calendar").data('daterangepicker').setStartDate(date_start);

        // Active button date
        $("#add-time li a").removeClass('btn-inverse');
        $(this).addClass('btn-inverse');
    });

    $("#js__two-calendar").daterangepicker({
        showDropdowns: true,
        locale: {
            format: "YYYY/MM/DD",
        },
        startDate: $('#js__two-calendar').data('start'),
        endDate: $('#js__two-calendar').data('end'),
        maxDate: moment().startOf('day'),
    });
});