import { validateMaxInputLength } from './validate.js';

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('page_setting_withdraw_index');

    form.addEventListener('submit', function (event) {

        event.preventDefault();
        if (!validateMaxInputLength('wcDisableWithdrawContent')) {
            return;
        } else if(!validateMaxInputLength('wcNoBonusContent')){
            return;
        }
        submitForm();
    });

    function submitForm() {
        form.submit();
    }
});
