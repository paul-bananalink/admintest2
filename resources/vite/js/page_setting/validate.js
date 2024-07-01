import createToast from "../toast/script";

const errorMessages = {
    siName: "사이트 이름을",
    siSolutionName: "솔루션 이름을",
    siFeedTitle: "타이틀을",
    siLowOddsLimit: "저배당률 제한 기준을",
    siOTPAdminID: "OTP를",

    // page-setting/domain/index
    dPartNer:'관리자나 파트너아이디를',
    dDomain:'사이트도메인을',
    dName:'사이트명을',
    dName:'사이트 타이틀을',
};

function validateInput(inputName) {
    let inputElement = document.getElementsByName(inputName)[0];
    let errorMessage = errorMessages[inputName];
    if (inputElement.value.trim() === "") {
        createToast("warning", errorMessage + ' 입력하세요.');
        return false;
    }
    return true;
}

function validateMaxInputLength(inputName) {
    let inputElement = document.getElementsByName(inputName)[0];
    let inputValue = inputElement.value.trim();
    
    if (inputValue.length > 255) {
        createToast("warning", "최대 255자이하 입력하세요.");
        return false;
    }

    return true;
}


function validateNumberInput(inputId) {
    let inputElement = $("#" + inputId);
    let inputValue = inputElement.val().trim();

    if (inputValue === "") {
        createToast("warning", "값을 입력해주세요.");
        return false;
    }

    if (isNaN(inputValue) || parseInt(inputValue) <= 0) {
        createToast("warning", "양의 정수를 입력해주세요.");
        inputElement.val('');
        return false;
    }
    return true;
}

function validateTimeInput(inputId) {
    let inputElement = $("#" + inputId);
    let inputValue = inputElement.val().trim();

    if (inputValue === "") {
        createToast("warning", "시간을 입력하세요.");
        return false;
    }

    if (isNaN(inputValue) || parseInt(inputValue) <= 0) {
        createToast("warning", "시간은 양의 정수여야 합니다.");
        inputElement.val('');
        return false;
    }

    return true;
}

function validateSiPartnersForm() {
    let valid = true;
    $("#siPartnersSubmit input").each(function () {
        if ($(this).val().trim() === "") {
            valid = false;
            createToast(
                "warning",
                "모든 필드를 작성해주세요."
            );
            return false;
        }
    });
    return valid;
}


function validateSiSMSSubmitForm() {
    let valid = true;
    $("#siSMSSubmit input").each(function () {
        if ($(this).val().trim() === "") {
            valid = false;
            createToast("warning", "모든 필드를 입력해 주세요.");
            return false;
        }
    });

    let phone = $('#siSMSPhone').val().trim();
    if (!phone.match(/^[0-9 -]+$/)) {
        valid = false;
        createToast("warning", "핸드폰번호 형식이 잘못되었습니다.");
    }

    return valid;
}

export { validateInput, validateTimeInput, validateNumberInput,validateMaxInputLength, validateSiPartnersForm, validateSiSMSSubmitForm, createToast };
