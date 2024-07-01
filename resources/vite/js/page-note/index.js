import createToast from "../toast/script.js";

$(document).ready(function () {
    $("body").on("change", "select[name='type']", function () {
        let el_btn = $(this);
        let type = el_btn.val();
        let action_selected = el_btn.find('option:selected').data('action');

        if (type == 4 || type == 5 || type == 6) {
            $.ajax({
                url: action_selected,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (html) {
                    $("#group-return").html(html);
                }
            });
        }
        else {
            $("#group-return").html("");
        }
    });

    $('#add-note').on('submit', function (form) {
        form.preventDefault();

        let title = $('input[name="title"]').val();
        let type = $('select[name="type"]').val();
        let content = tinymce.activeEditor.getContent();

        if (type === "") {
            createToast("warning", "발송구분을 선택하세요.");
            return;
        } else if (type === "4") {
            let memberList = $('textarea[name="member_list"]').val().trim();
            if (memberList === "") {
                createToast("warning", "회원 아이디를 입력하세요.");
                return;
            }
        } else if (type === "5") {
            let level = $('select[name="level"]').val();

            if (level === "") {
                createToast("warning", "레벨을 선택하세요.");
                return;
            }
        } else if (type === "6") {
            let selectedPartners = $('input[name="partner[]"]:checked').length;

            if (selectedPartners === 0) {
                createToast("warning", "파트너를 하나 이상 선택하세요.");
                return;
            }
        }
        if (title.trim() === "") {
            createToast("warning", "제목을 입력하세요.");
            return;
        } else if (content.trim() === "") {

            createToast("warning", "내용을 입력하세요.");
            return;
        } else {
            form = $(form.currentTarget);
            $('textarea[name="content"]').val(tinymce.activeEditor.getContent());

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function (result) {
                    Swal.fire({
                        icon: result?.type,
                        title: result?.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: error?.responseJSON?.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    });

    $("body").on("click", "#js__btn-send", function () {
        let el_btn = $(this);
        $.ajax({
            url: el_btn.attr('action-route'),
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (result) {
                el_btn.addClass('disabled');
                Swal.fire({
                    icon: "success",
                    title: "Send Success!",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });

    tinymce.init({
        license_key: "gpl",
        selector: "#js__editor-note",
        skin: "oxide-dark",
        content_css: "dark",
        promotion: false,
        branding: false,
        menubar: false,
        plugins: "table lists image link code charmap media textcolor",
        toolbar:
            "blocks | bold italic underline strikethrough | alignleft aligncenter alignright justify | charmap code | bullist numlist | indent outdent | forecolor backcolor | link image media | removeformat",


        urlconverter_callback: function (url) {
            if (url.startsWith('/')) {
                return window.location.origin + url;
            } else {
                return url;
            }
        },

        file_picker_callback: function (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            let type = 'image' === meta.filetype ? 'Images' : 'Files',
                url = '/laravel-filemanager?editor=tinymce7&type=' + type;

            tinymce.activeEditor.windowManager.openUrl({
                url: url,
                title: 'File Manager',
                width: x * 0.8,
                height: y * 0.8,
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    });

    $("body").on("click", ".recall", function (e) {
        e.preventDefault();
        let uuid = $("input[name='uuid']").val();
        if (uuid.trim() === "") {
            createToast("warning", "전송코드를 입력하세요.");
            return;
        } else {
            $.ajax({
                url: $('form#recall').attr('action'),
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    uuid: uuid
                },
                success: function (response) {
                    if (response.status) {
                        createToast("success", response.message);
                        $("input[name='uuid']").val("");
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        createToast("warning", response.message);
                    }
                },
            });
        }
    });

    $(".js__apply-templ").on("click", function (e) {
        e.preventDefault();
        var data_action = $(this).data("action");
        $.ajax({
            url: data_action,
            type: "GET",
            success: function (response) {
                if (response.success) {
                    tinymce.get("js__editor-note").setContent(response.data.content);
                }
            },
        });
    });
});
