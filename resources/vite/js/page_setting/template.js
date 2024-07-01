import { initTinymce } from "../functions";

let selectedTemplate = null;

$(function () {
    $('#sortable').sortable();
});

$('#add-template').on('click', function (e) {
    e.preventDefault();
    let random = getRandomNumber()
    let defaultTemplate = `<div class="mr-4 p-10 panel-auto-reply mb-12 export-column-6 template-item ui-sortable-handle">
                                <button class="btnstyle1 btnstyle1-inverse4 h-33 cancel-btn float-right remove-template"><i class="fa fa-close"></i>
                                </button>
                                <div class="col-md-8 p-0 mb-4">
                                    <input value="" type="text" name="data[`+ random + `][title]" class="form-control width-full template-title">
                                </div>
                                <div class="col-md-12 p-0 mb-4 text-edit-h-280">
                                    <textarea style="overflow-y: auto" class="js__editor width-full p-10 template-desc " name="data[`+ random + `][content]" id="" cols="20" rows="10"></textarea>
                                </div>
                            </div>`

    $('#sortable').append(defaultTemplate)
    initTinymce()
});

$(document).on('click', '.remove-template', function (e) {
    $(this).closest('.template-item').remove();
})

$(document).on('click', '.btn-open-modal', function (e) {
    e.preventDefault();
    $('#modal-template').modal('show');
    selectedTemplate = $(this).closest('.template-item')
    let title = $(this).closest('.template-item').find('.template-title').val();
    let desc = $(this).closest('.template-item').find('.template-desc').text();

    $('#modal-template .edit-title').val(title);
    tinymce.activeEditor.setContent(desc);


    $(document).on('click', '#btn-edit', function (e) {
        e.preventDefault();
        $('#modal-template').modal('hide');
        selectedTemplate.find('.template-title').val($('#modal-template .edit-title').val());
        selectedTemplate.find('.template-desc').text(tinymce.activeEditor.getContent());
    })
})


function getRandomNumber() {
    return Math.floor(Math.random() * (10000 - 100 + 1)) + 100;
}
