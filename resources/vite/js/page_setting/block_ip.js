$('.btn-send-value-to-model').on('click', (e) => {
    $('#receive-data-from-btn').attr('value', e.currentTarget.getAttribute('target-value'));
    $('#ip-confirm').text(e.currentTarget.getAttribute('target-value-ip'));
});
