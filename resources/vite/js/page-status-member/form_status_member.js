$('#select_days_member_logged').on('change', function (e) {
    let url = `${$(location).attr('origin')}${$(location).attr('pathname')}?member_logged_by_days=1&select_days_member_logged=${$(e.currentTarget).val()}`;
    $('.btn-member-logged').attr('href', url);
     window.location.href =  $('.btn-member-logged').attr('href');
});

export const addRowToTable = (data) => {
    let table = $('#' + data.type + 'Table' + ' tbody');
    $(table).prepend(data.tr);
}
