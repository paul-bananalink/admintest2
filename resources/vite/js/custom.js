import {
  initTinymce,
  openWindow,
  fetchData,
  actionInputFormatMoney,
} from "./functions";

import createToast from "./toast/script";

$(document).ready(function () {
  $(".openModalSendNoteToUser").click(function () {
    var userId = $(this).data("user-id");
    $("#userId").val(userId);
    $("#sendNoteToUser").modal("show");
  });

  // tinymce editor

  tinymce.init({
    license_key: "gpl",
    selector: "#js__editor-no-toolbar",
    plugins: "table lists",
    branding: false,
    skin: "oxide-dark",
    content_css: "dark",
    promotion: false,
    toolbar: false,
    menubar: false,
  });

  initTinymce();

  $("body").on("click", "#open-window", function (e) {
    e.preventDefault();
    var route = $(this).data("route");
    openWindow(route);
  });

  $("body").on("click", ".confirm-box", function (e) {
    e.preventDefault();
    var route = $(this).data("route");
    var method = $(this).data("method");
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    Swal.fire({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: route,
          type: method,
          data: {
            _token: csrfToken,
            data: $(this).data("data"),
          },
          success: function (response) {
            if (response.success) {
              Swal.fire("Success!", response.message, "success").then(() => {
                location.reload();
              });
            } else {
              Swal.fire("Error!", response.message, "error");
            }
          },
          error: function (xhr, textStatus, errorThrown) {
            Swal.fire("Error!", "An error occurred: " + errorThrown, "error");
          },
        });
      }
    });
  });

  $("#js__single-date").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: true,
    minYear: moment().format("YYYY"),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: $("#js__single-date").val()
      ? $("#js__single-date").val()
      : moment().format("YYYY/MM/DD HH:mm"),
    locale: {
      format: "YYYY/MM/DD HH:mm",
    },
  });

  let date = $("#dateRangePicker").val();

  let start_date = date ? date.split(" - ")[0] : false;
  let end_date = date ? date.split(" - ")[1] : false;

  $("#dateRangePicker").daterangepicker({
    showDropdowns: true,
    timePicker: false,
    maxYear: parseInt(moment().format("YYYY"), 10),

    startDate: start_date,
    endDate: end_date,
    autoUpdateInput: start_date && end_date ? true : false,

    locale: {
      format: "YYYY/MM/DD",
    },
    maxDate: moment().startOf("day"),
  });
  $("#dateRangePicker").on("apply.daterangepicker", function (ev, picker) {
    $(this).val(
      picker.startDate.format("YYYY/MM/DD") +
        " - " +
        picker.endDate.format("YYYY/MM/DD")
    );
  });

  $("#dateRangePicker").on("cancel.daterangepicker", function (ev, picker) {
    $(this).val("");
  });

  // Calendar 2
  var start_date_cl2 = $("#js__single-start-date").val();
  var end_date_cl2 = $("#js__single-end-date").val();
  $("#js__single-end-date").prop("disabled", end_date_cl2 ? false : true);

  $("#js__single-start-date")
    .daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      timePicker: true,
      timePicker24Hour:true,
      autoUpdateInput: false,
      locale: {
        format: "YYYY-MM-DD HH:mm",
      },
    })
    .val(start_date_cl2)
    .on("apply.daterangepicker", function (ev, picker) {
      $(this).val(picker.startDate.format("YYYY-MM-DD HH:mm"));

      $("#js__single-end-date").prop("disabled", false);

      $("#js__single-end-date").val(start_date_cl2);

      start_date_cl2 = picker.startDate.format("YYYY-MM-DD HH:mm");

      initDatePicker("#js__single-end-date", start_date_cl2, start_date_cl2);
    });

  if (end_date_cl2) {
    initDatePicker("#js__single-end-date", end_date_cl2, start_date_cl2).val(
      end_date_cl2
    );
  }

  $("#js__single-start-date-only").on(
    "cancel.daterangepicker",
    function (ev, picker) {
      $(this).val("");
      $("#js__single-end-date-only").val("");
      $("#js__single-end-date-only").prop("disabled", true);
    }
  );

  // Calendar 3
  var start_date_cl3 = $("#js__single-start-date-only").val();
  var end_date_cl3 = $("#js__single-end-date-only").val();
  $("#js__single-end-date-only").prop("disabled", end_date_cl3 ? false : true);

  $("#js__single-start-date-only")
    .daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      autoUpdateInput: false,
      locale: {
        format: "YYYY-MM-DD",
      },
    })
    .val(start_date_cl3)
    .on("apply.daterangepicker", function (ev, picker) {
      $(this).val(picker.startDate.format("YYYY-MM-DD"));

      $("#js__single-end-date-only").prop("disabled", false);

      $("#js__single-end-date-only").val(start_date_cl3);

      start_date_cl3 = picker.startDate.format("YYYY-MM-DD");

      initDatePicker("#js__single-end-date-only", start_date_cl3, start_date_cl3, false);
    });

  if (end_date_cl3) {
    initDatePicker("#js__single-end-date-only", end_date_cl3, start_date_cl3, false).val(
      end_date_cl3
    );
  }

  $("#js__single-start-date-only").on(
    "cancel.daterangepicker",
    function (ev, picker) {
      $(this).val("");
      $("#js__single-end-date-only").val("");
      $("#js__single-end-date-only").prop("disabled", true);
    }
  );

  // Calendar single
  $(".js__calendar-single").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    locale: {
      format: "YYYY-MM-DD",
    },
  });

  // calendar minus
  $(".js__calendar-minus")
    .daterangepicker({
      singleDatePicker: true,
      timePicker: true,
      timePicker24Hour: true,
      locale: {
        format: "HH:mm",
      },
    })
    .on("show.daterangepicker", function (ev, picker) {
      picker.container.find(".calendar-table").hide();
    });
});

$(document).on("show.bs.collapse", ".member-detail", (e) => {
  if ($(e.target).hasClass("member-detail")) {
    let $loadingBar = $(
      '<div class="loading-bar"><div class="bar"></div></div>'
    );
    $(e.target).html($loadingBar);

    let url = $(e.target).data("url");
    fetchData(url, "get").then((data) => {
      $(".member-detail").not(e.target).collapse("hide");
      $(e.target).collapse("show");
      $(e.target).html(data.data);
      actionInputFormatMoney(".formatMoney");
    });
  }
});

$(document).on("shown.bs.collapse", ".member-history", (e) => {
  $("html, body").animate(
    {
      scrollTop: $(e.target).offset().top - $(".navbar-fixed-c").height() - 100,
    },
    500
  );
});

$(document).on("hidden.bs.collapse", ".member-detail", (e) => {
  if ($(e.target).hasClass("member-detail")) {
    $(e.target).empty();
  }
});

$("body").on("click", ".confirm-action", (e) => {
  e.preventDefault();
  let route = $(e.target).attr("href");

  Swal.fire({
    title: "Are you sure?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = route;
    }
  });
});

function initDatePicker(selector, startDate, minDate, useTime = true) {
  return $(selector).daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    startDate: startDate,
    minDate: minDate,
    timePicker: useTime,
    timePicker24Hour:true,
    locale: {
      format: useTime ? "YYYY-MM-DD HH:mm" : "YYYY-MM-DD",
    },
  });
}

// Modal transaction detail
$("body").on("click", ".modal-transaction-detail", (e) => {
  e.preventDefault();
  let tbody = $("#tbody_transaction_detail");
  let modalID = "#" + $(e.target).data("modal");
  let action = $(e.target).data("action");

  tbody.html("");
  $.ajax({
    url: action,
    type: "get",
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (response) {
      tbody.html(response);
      $(modalID).modal("show");
    },
    error: function (xhr, textStatus, errorThrown) {},
  });
});

$("body").on("click", ".export_excel", (e) => {
  e.preventDefault();

  $("#modal_export_member_excel form").submit();

  setTimeout(() => {
    const loader = document.getElementById("loader");
    loader.style.display = "none";

    $("#modal_export_member_excel").modal("hide");
  }, 2000);
});
