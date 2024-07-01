import createToast from "../toast/script";

$(document).ready(function () {
  let date = $("#js__single-search-sport").val();

  $("#js__single-search-sport").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: false,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: date !== "" ? date : false,
    autoUpdateInput: date !== "" ? true : false,
    locale: {
      format: "YYYY-MM-DD",
    },
  });
  $("#js__single-search-sport").on(
    "apply.daterangepicker",
    function (ev, picker) {
      $(this).val(picker.startDate.format("YYYY-MM-DD"));
    }
  );

  $("#js__single-search-sport").on(
    "cancel.daterangepicker",
    function (ev, picker) {
      $(this).val("");
    }
  );

  $(".update-row").on("click", function (e) {
    e.preventDefault();
    let idx = $(this).data("idx");
    let action = $(this).data("action");
    let team_name_kor = $("input[name='team_name_kor_" + idx + "']").val();
    let team_logo = $("input[name='team_logo_" + idx + "']").val();

    $.ajax({
      url: action,
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        data: {
          idx: idx,
          team_name_kor: team_name_kor,
          team_logo: team_logo,
        },
      },
      success: function (result) {
        if (result.status) {
          createToast("success", result.message);
        } else {
          createToast("warning", result.message);
        }
      },
    });
  });
});
