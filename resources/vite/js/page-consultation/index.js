$(document).ready(function () {
  let date = $("#js__two-calendar-cons").val();

  let start_date = date ? date.split(" - ")[0] : false;
  let end_date = date ? date.split(" - ")[0] : false;

  $("#js__two-calendar-cons").daterangepicker({
    showDropdowns: true,
    timePicker: false,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),

    startDate: start_date,
    endDate: end_date,
    autoUpdateInput: start_date && end_date ? true : false,

    locale: {
      format: "YYYY/MM/DD",
    },
    maxDate: moment().startOf("day"),
  });
  $("#js__two-calendar-cons").on(
    "apply.daterangepicker",
    function (ev, picker) {
      $(this).val(
        picker.startDate.format("YYYY/MM/DD") +
          " - " +
          picker.endDate.format("YYYY/MM/DD")
      );
    }
  );

  $("#js__two-calendar-cons").on(
    "cancel.daterangepicker",
    function (ev, picker) {
      $(this).val("");
    }
  );

  $("body").on("click", ".reply-cons", function (e) {
    e.preventDefault();
    let el = $(this);
    let item_id = el.data("item-id");
    let is_open_reply = el.data("open-reply");
    let action = $("table#consultationTable").data("action-reply");
    let csrfToken = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
      url: action,
      data: {
        _token: csrfToken,
        id: item_id,
        is_open_reply: is_open_reply,
      },
      type: "POST",
      success: function (response) {
        $(".content-reply-all").show();
        $(".show-hide-content-" + item_id).hide();
        $(".default-reply").html("");
        $(".reply-content-" + item_id).html(response);
      },
    });
  });
});
