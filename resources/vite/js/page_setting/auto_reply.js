import { fetchData, initTinymce } from "../functions.js";

let selectedTemplate = null;
let isQuickForm = false;
$(function () {
    $('.sortable').sortable();
});

$('#add-template-quick').on('click', function (e) {
    e.preventDefault();
    fetchData(BASE_URL + '/admin/page-setting/auto-reply/get-form/quick', 'GET').then(data => {
        $('#quick-form').append(data)
        initTinymce()
    })
});

$('#add-template-normal').on('click', function (e) {
    e.preventDefault();
    fetchData(BASE_URL + '/admin/page-setting/auto-reply/get-form/normal', 'GET').then(data => {
        $('#normal-form').append(data)
        initTinymce()
    })
});

$(document).on('click', '.remove-template', function (e) {
    $(this).closest('.template-item').remove();
})

$(document).on('click', '.btn-open-modal', function (e) {
    e.preventDefault();
    $('#modal-auto-reply').modal('show');
    selectedTemplate = $(this).closest('.template-item')
    isQuickForm = selectedTemplate.find('.form-type').val() == 1

    let link = selectedTemplate.find('.form-link').val();
    let desc = selectedTemplate.find('.form-desc').text();
    $('#modal-auto-reply .edit-link').val(link);
    tinymce.activeEditor.setContent(desc);

    if (isQuickForm) {
        $('#modal-auto-reply .edit-level').show()
        let level = selectedTemplate.find('.form-level').val();
        $('#modal-auto-reply .edit-level').val(level);
    } else {
        $('#modal-auto-reply .edit-level').hide()
    }
})

$(document).on('click', '#btn-edit', function (e) {
    e.preventDefault();
    $('#modal-auto-reply').modal('hide');
    selectedTemplate.find('.form-link').val($('#modal-auto-reply .edit-link').val());
    selectedTemplate.find('.form-desc').text(tinymce.activeEditor.getContent());
    if (isQuickForm) {
        selectedTemplate.find('.form-level').val($('#modal-auto-reply .edit-level').val());
    }
})


function getRandomNumber() {
    return Math.floor(Math.random() * (10000 - 100 + 1)) + 100;
}
