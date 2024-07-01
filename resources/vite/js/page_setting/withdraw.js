let date = $(".time-picker").val();

let start_time = date ? date.split(" - ")[0] : moment().startOf('day');
let end_time = date ? date.split(" - ")[1] : moment().endOf('day');

$(".time-picker").daterangepicker({
    timePicker: true,
    startDate: start_time,
    endDate: end_time,
    locale: {
        format: 'HH:mm'
    },
    parentEl: '#time-picker-form'
});
$('.daterangepicker').find('.calendar-table').hide();
