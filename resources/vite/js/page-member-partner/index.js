import createToast from "../toast/script";

let url_valid = $("#create-partner").attr("action-valid-field");

function clearIsCheckedModal() {
  //Form Create Partner
  removeCheckedValue(".checkMemberId");
  removeCheckedValue(".checkMMemberIdByType");
  removeCheckedValue(".checkUniqueNickName");
  //Form Update Partner
  removeCheckedValue(".checkUniqueNickName");
  removeCheckedValue(".checkUniqueNickName");
  removeCheckedValue(".checkUniqueNickName");
}

function addCheckedValue(target) {
  $(target).attr("is-checked", 1);
  $(target).addClass("is-checked");
}

function removeCheckedValue(target) {
  $(target).removeAttr("is-checked", 1);
  $(target).removeClass("is-checked");
}

function isCheckIconSearchRequiredFormCreate() {
  if ($(".checkMMemberIdByType").length) {
    if ($(".checkMMemberIdByType").attr("is-checked") === undefined) {
      return "아이디를 확인해주세요";
    }
  }

  if ($(".checkMemberId").attr("is-checked") === undefined) {
    return "아이디를 확인해주세요";
  }

  if ($(".checkUniqueNickName").attr("is-checked") === undefined) {
    return "닉네임을 확인해주세요";
  }

  return "success";
}

function isCheckIconSearchRequiredFormUpdate() {
  if ($(".checkMMemberIdByTypeUpdate").length) {
    if ($(".checkMMemberIdByTypeUpdate").attr("is-checked") === undefined) {
      return "아이디를 확인해주세요";
    }
  }

  if ($(".checkUniqueNickNameUpdate").attr("is-checked") === undefined) {
    return "닉네임을 확인해주세요";
  }

  return "success";
}

function ajaxRequiredField(action, data, key = "field") {
  return new Promise((resolve, reject) => {
    let post_data = {
      _token: $('meta[name="csrf-token"]').attr("content"),
      data: data,
    };

    if (key === "form") {
      post_data = data;
    }

    $.ajax({
      sync: true,
      url: action,
      method: "POST",
      data: post_data,
      success: function (data) {
        if (data.success) {
          if (key === "field") {
            createToast("success", data.message);
          }
          resolve(true);
        } else {
          createToast("warning", data.message);
          resolve(false);
        }
      },
      error: function (error) {
        createToast("warning", "Error server.");
        reject(error);
      },
    });
  });
}

function fetchData(action) {
  return new Promise((resolve, reject) => {
    $.ajax({
      sync: true,
      url: action,
      method: "GET",
      success: function (data) {
        resolve(data);
      },
      error: function (error) {
        createToast("warning", "Error server.");
        reject(error);
      },
    });
  });
}

$("body").on("change", '#create-partner select[name="pType"]', function () {
  let type = $(this).val();

  removeCheckedValue(".checkMMemberIdByType");

  if (type === "distributor" || type === "agency") {
    let input_mID = `<div class="flex">
                        <input type="text" name="mMemberID" placeholder="추천인을" class="form-control">
                        <button type="button" class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkMMemberIdByType">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>`;
    $("#create-partner .show-input-mID").html(input_mID);
  } else {
    $("#create-partner .show-input-mID").html("");
  }
});

$("body").on("change", '#update-partner select[name="pType"]', function () {
  let type = $(this).val();

  removeCheckedValue(".checkMMemberIdByTypeUpdate");

  if (type === "distributor" || type === "agency") {
    let input_mID = `<div class="flex">
                        <input type="text" name="mMemberID" placeholder="추천인을" class="form-control">
                        <button type="button" class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkMMemberIdByTypeUpdate">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>`;
    $("#update-partner .show-input-mID").html(input_mID);
  } else {
    $("#update-partner .show-input-mID").html("");
  }
});

// BEGIN CREATE PARTNER //

// Check mMember ID by Type
$("body").on("click", ".checkMMemberIdByType", function () {
  let target_class = $(this);
  let mMemberID = $('#modalCreatePartner input[name="mMemberID"]').val();
  let pType = $('#modalCreatePartner select[name="pType"]').val();

  addCheckedValue(target_class);

  ajaxRequiredField(url_valid, {
    mMemberID: mMemberID,
    pType: pType,
  }).then((success) => {
    if (!success) {
      removeCheckedValue(target_class);
    }
  });
});

// Check Member ID
$("body").on("click", ".checkMemberId", function () {
  let target_class = $(this);
  let target_input = $('#modalCreatePartner input[name="mID"]');

  addCheckedValue(target_class);

  ajaxRequiredField(url_valid, { mID: target_input.val() }).then((success) => {
    if (!success) {
      removeCheckedValue(target_class);
    }
  });
});

// Check unique mNick
$("body").on("click", ".checkUniqueNickName", function () {
  let target_class = $(this);
  let target_input = $('#modalCreatePartner input[name="mNick"]');

  addCheckedValue(target_class);

  ajaxRequiredField(url_valid, { mNick: target_input.val() }).then(
    (success) => {
      if (!success) {
        removeCheckedValue(target_class);
      }
    }
  );
});

// Form Create Partner
$("body").on("click", "#create-partner button[type='submit']", function (e) {
  e.preventDefault();
  let check_message = isCheckIconSearchRequiredFormCreate();
  if (check_message == "success") {
    let data =
      $("#create-partner").serialize() +
      "&form=true&_token=" +
      $('meta[name="csrf-token"]').attr("content");

    ajaxRequiredField(url_valid, data, "form").then((success) => {
      if (success) {
        $("#create-partner").submit();
      }
    });
  } else {
    createToast("warning", check_message);
  }
});

// KEYUP FIELD FORM CREATE PARTNER
$("body").on("keyup", "#modalCreatePartner input[name='mID']", function () {
  removeCheckedValue(".checkMemberId");
});

$("body").on("keyup", "#modalCreatePartner input[name='mNick']", function () {
  removeCheckedValue(".checkUniqueNickName");
});

$("body").on(
  "keyup",
  "#modalCreatePartner input[name='mMemberID']",
  function () {
    removeCheckedValue(".checkMMemberIdByType");
  }
);

$("body").on("keyup", "#modalUpdatePartner input[name='mID']", function () {
  removeCheckedValue(".checkMemberIdUpdate");
});

$("body").on("keyup", "#modalUpdatePartner input[name='mNick']", function () {
  removeCheckedValue(".checkUniqueNickNameUpdate");
});

$("body").on(
  "keyup",
  "#modalUpdatePartner input[name='mMemberID']",
  function () {
    removeCheckedValue(".checkMMemberIdByTypeUpdate");
  }
);
// KEYUP FIELD FORM CREATE PARTNER

// END CREATE PARTNER //

// BEGIN UPDATE PARTNER //

$("body").on("click", ".checkMemberIdUpdate", function () {
  let mID = $('#update-partner input[name="mID"]').val();
  let pNo = $("#update-partner").attr("data-pno");

  ajaxRequiredField(url_valid, {
    mID: mID,
    pNo: pNo,
  });
});
$("body").on("click", ".checkMMemberIdByTypeUpdate", function () {
  let mMemberID = $('#update-partner input[name="mMemberID"]').val();
  let pType = $('#update-partner select[name="pType"]').val();
  let pNo = $("#update-partner").attr("data-pno");

  addCheckedValue($(this));

  ajaxRequiredField(url_valid, {
    mMemberID: mMemberID,
    pType: pType,
    pNo: pNo,
  }).then((success) => {
    if (!success) {
      removeCheckedValue($(this));
    }
  });
});
$("body").on("click", ".checkUniqueNickNameUpdate", function () {
  let mNick = $('#update-partner input[name="mNick"]').val();
  let pNo = $("#update-partner").attr("data-pno");

  addCheckedValue($(this));

  ajaxRequiredField(url_valid, {
    mNick: mNick,
    pNo: pNo,
  }).then((success) => {
    if (!success) {
      removeCheckedValue($(this));
    }
  });
});

$("body").on("click", ".get-item-partner", (e) => {
  e.preventDefault();
  let content = $("#modalUpdatePartner");
  let action = $(e.target).data("action");
  let modalID = $(e.target).data("modal");

  content.html("");

  $.ajax({
    url: action,
    type: "get",
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (response) {
      content.html(response);
      $(modalID).modal("show");
    },
    error: function (xhr, textStatus, errorThrown) {},
  });
});

// Close Modal clear form
$("#modalUpdatePartner").on("hidden.bs.modal", function () {
  $("#modalUpdatePartner").find("form")[0].reset();
  $("#update-partner").attr("action", "");
  $("#update-partner").attr("data-pno", "");
  clearIsCheckedModal();
});

$("#modalCreatePartner").on("hidden.bs.modal", function () {
  $("#modalCreatePartner").find("form")[0].reset();
  $("#modalCreatePartner .show-input-mID").html("");
  clearIsCheckedModal();
});

$("body").on("click", "#update-partner button[type='submit']", function (e) {
  e.preventDefault();
  let check_message_update = isCheckIconSearchRequiredFormUpdate();

  if (check_message_update == "success") {
    let pNo = $("#update-partner").attr("data-pno");
    let data =
      $("#update-partner").serialize() +
      "&pNo=" +
      pNo +
      "&form_update=true&_token=" +
      $('meta[name="csrf-token"]').attr("content");
    let action = $("#update-partner").attr("action");
    let load_link = $(this).attr("data-load");

    ajaxRequiredField(action, data, "form").then((success) => {
      if (success) {
        $("#modalUpdatePartner").modal("hide");
        createToast("success", "업데이트 성공.");
        setTimeout(function () {
          window.location.href = load_link;
        }, 1000);
      }
    });
  } else {
    createToast("warning", check_message_update);
  }
});

// END UPDATE PARTNER //

let datetreeview = $("#js__two-calendar-treeview").val();

let start_date = datetreeview ? datetreeview.split(" - ")[0] : false;
let end_date = datetreeview ? datetreeview.split(" - ")[1] : false;

$("#js__two-calendar-treeview").daterangepicker({
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
$("#js__two-calendar-treeview").on(
  "apply.daterangepicker",
  function (ev, picker) {
    $(this).val(
      picker.startDate.format("YYYY/MM/DD") +
        " - " +
        picker.endDate.format("YYYY/MM/DD")
    );
  }
);

$("#js__two-calendar-treeview").on(
  "cancel.daterangepicker",
  function (ev, picker) {
    $(this).val("");
  }
);
