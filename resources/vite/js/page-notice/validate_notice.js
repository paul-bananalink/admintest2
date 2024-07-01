import createToast from "../toast/script.js";

$(document).ready(function () {
    function handleSubmit(event) {
        event.preventDefault();

        let form = $(event.target);
        let formId = form.attr('id');
        let title = form.find('input[name="title"]').val();
        let content = form.find('textarea[name="content"]').val().trim();
        let logo = form.find('input[name="logo"]').val();
        let category = form.find('input[name="category"]:checked').val();

        if (title === "") {
            createToast("warning", "제목을 입력해 주세요.");
            return;
        } else if (content === "") {
            createToast("warning", "내용을 입력해 주세요.");
            return;
        } else if (logo === "") {
            createToast("warning", "로고를 업로드하세요.");
            return;
        }

        if (formId === 'form-notice-event') {
            if (!category) {
                createToast("warning", "카테고리를 선택하세요.");
                return;
            }
        } else if (formId === 'form-notice-rule') {
            if (!category) {
                createToast("warning", "카테고리를 선택하세요.");
                return;
            }
        }

        form.off('submit', handleSubmit);
        form.submit();
    }

    $('#form-notice-rule').on('submit', handleSubmit);
    $('#form-notice-event').on('submit', handleSubmit);
    $('#form-notice-partner').on('submit', handleSubmit);
    $('#form-notice-vote').on('submit', handleSubmit);
});
