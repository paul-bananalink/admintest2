import { fetchData } from "../functions";
import createToast from '../toast/script'

$('#saveBonusWarningMessage').on('click', function (e) {
    e.preventDefault()
    let data = {};
    $("input[name^='rcBonusWarningMessage']").each(function () {
        let key = $(this).attr('attr-key');
        data[key] = $(this).val()
    });

    fetchData(BASE_URL + '/admin/page-setting/recharge-config/store', 'post', {
        rcBonusWarningMessage: data,
        _token: $('meta[name="csrf-token"]').attr("content")
    }).then((res) => {
        if (res.status === true) {
            createToast('success', res.message)
        } else {
            createToast('error', res.message)
        }

    })
})
