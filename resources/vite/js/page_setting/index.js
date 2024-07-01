import createToast from "../toast/script";
import { validateInput, validateNumberInput, validateTimeInput, validateSiPartnersForm, validateSiSMSSubmitForm } from './validate.js';

$(document).ready(function () {
  $(".btn-submit").on("click", function (e) {
    e.preventDefault();
    let el = $(e.currentTarget);
    let item = el.data("item");
    let action = el.data("action");
    let formId = item + "Submit";

    if (item === "") {
      alert("Not Available");
      return;
    }

    switch (item) {
        case "siName":
        case "siSolutionName":
        case "siFeedTitle":
        case "siLowOddsLimit":
        case "siOTPAdminID":
            if (!validateInput(item)) {
                return;
            }
            break;

        case "siPartners":
            if (!validateSiPartnersForm(item)) {
                return;
            }
            break;

        case "siFeedCommentCharLimit":
            if (!validateNumberInput(item)) {
                return;
            }
            break;

        case "siMaxHoursHistories":
        case "siReinquiryTimeInterval":
        case "siClientMessageRetentionTime":
            if (!validateTimeInput(item)) {
                return;
            }
            break;

        case "siSMS":
            if (!validateSiSMSSubmitForm(item)) {
                return;
            }
            break;

        default:
            // No specific validation required
            break;
    }

    // If validation passes, proceed to submit the form
    submitForm(el, action, formId);
});

  function submitForm(el, action, formId) {
    let data = $("#" + formId).serialize();

    $.post(action, data, function (data, textStatus, jqXHR) {
      if (data) {
        createToast("success", "업데이트 성공.");
      } else {
        createToast("warning", "업데이트 실패.");
      }
    });
  }
});
