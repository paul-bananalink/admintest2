export const addRowToTable = (data, strict = []) => {
    const params = new URL(window.location.href).searchParams
    let type_order = params.get('type_order')

    if (type_order == null || strict.includes(type_order)) {
        let table = $('#' + data.type + 'Table' + ' tbody');
        $(table).prepend(data.tr);
    }
}

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});

$('input[name="checkbox[miNo][]"]').change(function () {
    let data = []
    $('.checkbox-withdraw').each(function () {
        if ($(this).prop('checked')) {
            data.push($(this).val())
        }
    })
    $('#multi-withdraw-approved').data('data', data.toString());
    console.log($('#multi-withdraw-approved'))
})
