$('.btn-open-pass').on('click', (e) => {
    actionBtnUpdate($(e.currentTarget));
});

const elInput = (el) => {
    el.removeAttr('disabled');
    el.removeAttr('value');
    el.focus();
}

const actionBtnUpdate = (el) => {
    let id_member = el.attr('target-value');
    let input = $(`#input-member-pw-id-${id_member}`);

    if (el.attr('enable-field') == '1') {
        let pw = input.val();
        addDataToForm(id_member, pw);
        $('#form-update-password').submit();
    }
    el.addClass('btn-success').removeClass('btn-primary').html('<i class="fa fa-upload"></i>');
    el.attr('enable-field', '1');
    elInput(input);
}

const addDataToForm = (id, pw) => {
    $('#hd-mNo').attr('value', id);
    $('#hd-mPW').attr('value', pw);
}
