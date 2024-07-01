import createToast from '../toast/script';

let csrfToken = $('meta[name="csrf-token"]').attr('content');

$(document).on('change', '.btn-toggle', (e) => {
    let el = $(e.currentTarget);
    $.post(el.attr('url_action'), {
        _token: csrfToken,
    }, function (data, textStatus, jqXHR) {
        if (! data) {
            el.prop('checked', !el.is(':checked'));
            createToast('error', '업데이트 실패했습니다!');
        }else{
            console.log(el);
            createToast('success', '성공적으로 업데이트되었습니다!');
        }
    },);
});
