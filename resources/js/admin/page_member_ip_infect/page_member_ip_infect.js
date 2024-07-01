$('.btn-send-value-to-model').on('click', (e) => {
    $('#receive-data-from-btn').attr('value', e.currentTarget.getAttribute('target-value'));
    $('#member_comfirm').text(e.currentTarget.getAttribute('target-value-member'));
});
