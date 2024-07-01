import createToast from "../toast/script";
import {
  formDataToObject,
  fetchData,
  parseNumberToDecimal,
  setNumberPhone,
} from "../functions.js";

let csrfToken = $('meta[name="csrf-token"]').attr("content");

// ------------------------- Check and create member-------------------
let is_check_mMemberID = false;
let is_check_mID = false;
let is_check_mNick = false;

//Check if input data is re-entered
[".create-mMemberID", ".create-mID", ".create-mNick"].forEach((selector) => {
  $(selector).each(function () {
    $(this).data("original-value", $(this).val());
  });
  $(selector).on("input", function () {
    if (selector === ".create-mID") {
      $("#btn-check-unique-member-id").prop("disabled", !$(this).val());
    }
    switch (selector) {
      case ".create-mMemberID":
        is_check_mMemberID = false;
        break;
      case ".create-mID":
        is_check_mID = false;
        break;
      case ".create-mNick":
        is_check_mNick = false;
        break;
    }
  });
});

$(document).on("click", ".checkMMemberId", (e) => {
  let el = $(e.currentTarget);
  let key = $(".create-mMemberID").val();
  if (key) {
    $.post(
      el.attr("target-url"),
      {
        _token: csrfToken,
        mMemberID: $(".create-mMemberID").val(),
      },
      function (data, textStatus, jqXHR) {
        if (data.is_check) {
          is_check_mMemberID = true;
          createToast("success", "확인되었습니다.");
        } else {
          $(".create-mMemberID").val("");
          createToast("warning", "사용자가 존재하지 않습니다.");
        }
      }
    );
  } else {
    createToast("warning", "추천인ID를 입력해주세요.");
  }
});

$(document).on("click", ".check-mID", (e) => {
  let el = $(e.currentTarget);
  let key = $(".create-mID").val();
  let regex = /^[a-zA-Z0-9]*$/;
  if (key) {
    if (!regex.test(key)) {
      createToast("error", "영숫자만 입력해주세요.");
      return;
    }
    $.post(
      el.attr("target-url"),
      {
        _token: csrfToken,
        mID: $(".create-mID").val(),
      },
      function (data, textStatus, jqXHR) {
        if (data.is_check) {
          is_check_mID = true;
          createToast("success", "확인되었습니다.");
        } else {
          createToast("warning", "사용자 이름이 이미 존재합니다.");
        }
      }
    );
  } else {
    createToast("warning", "회원ID를 입력해주세요.");
  }
});

$(document).on("click", ".checkNickName", (e) => {
  let el = $(e.currentTarget);
  let key = $(".create-mNick").val();
  let regex = /^[a-zA-Z0-9가-힣]*$/;
  if (key) {
    if (!regex.test(key)) {
      createToast("error", "닉네임은 특수문자 제외합니다.");
      $(".create-mNick").val("");
      return;
    }
    $.post(
      el.attr("target-url"),
      {
        _token: csrfToken,
        mNick: $(".create-mNick").val(),
      },
      function (data, textStatus, jqXHR) {
        if (data.is_check) {
          is_check_mNick = true;
          createToast("success", "확인되었습니다.");
        } else {
          $(".create-mNick").val("");
          createToast("warning", "사용할 수 없는 닉네임입니다.");
        }
      }
    );
  } else {
    createToast("warning", "닉네임을 입력해주세요.");
  }
});

//Click item member id global
$(document).on("click", ".item-transfer", function (event) {
  event.preventDefault();
  $("#formSendNote .mNo_receive").val($(this).data("mno"));
});

$(document).on("submit", "#formSendNote", function (e) {
  e.preventDefault();
  let data = $("#formSendNote").serialize();

  $.ajax({
    url: BASE_URL + "/admin/note/send-note-to-user",
    method: "POST",
    data: data,
    success: function (data) {
      if (data.status) {
        $(this).submit();

        createToast("success", "보내지었습니다");

        $("#formSendNote")[0].reset();
        $("#modal-send-note").modal("hide");
      }
    },
    error: function (error) {
      let errors = error.responseJSON.errors;
      if (errors) {
        if (errors.title) {
          createToast("warning", errors.title[0]);
        } else if (errors.content) {
          createToast("warning", errors.content[0]);
        }
      }
    },
  });
});

$(document).on("click", ".refresh-member-row", function (e) {
  let mNo = $(this).data("id");
  $(this).addClass("refreshing");
  refreshMemberRow(mNo)
    .then(() => {
      createToast("success", "업데이트 성공.");
    })
    .finally(() => $(this).removeClass("refreshing"));
});

$(document).on("submit", "#member-config-form", async function (e) {
  e.preventDefault();
  let mNo = $(this).data("id");
  let url = $(this).attr("action");
  let data = formDataToObject($(this).serializeArray());

  await fetchData(url, "post", data).then((response) => {
    if (response.status?.status) {
      createToast("success", "업데이트 성공.");
      $("#partnerName" + mNo).val(response.status.partner?.pName);
    }
    if (response.errors) {
      for (const error of Object.entries(response.errors)) {
        createToast("error", `${error[1]}`);
      }
    }
  });

  refreshMemberRow(mNo);
});

$(document).on("submit", "#create-member-form", async function (e) {
  e.preventDefault();
  let url = $(this).attr("action");
  let data = formDataToObject($(this).serializeArray());
  let memberRow = null;

  await fetchData(url, "post", data)
    .then((response) => {
      if (response.status) {
        this.reset();
        createToast("success", "등록되었습니다.");
        console.log(response);
        memberRow = response.data;
      }
      if (response.errors) {
        for (const error of Object.entries(response.errors)) {
          createToast("error", `${error[1]}`);
        }
      }
    })
    .catch((error) => {
      alert(error.message);
    });

  addMemberRow(memberRow);
});

$(document).on("click", ".btn-withdraw-money", async function (e) {
  let mNo = $(this).data("id");
  await getMemberInfo(mNo).then((member) => {
    let url =
      BASE_URL + "/admin/money-info/direct-recharge-or-withdraw/" + member.mID;
    let wallets = [
      {
        miType: "AW",
        miBankMoney: member.mMoney ? parseInt(member.mMoney) : 0,
        miWallet: "casino_slot",
      },
      // ,
      // {
      //     miType: 'AW',
      //     miBankMoney: member.mSportsMoney ? parseInt(member.mSportsMoney) : 0,
      //     miWallet: 'sports'
      // }
    ];
    wallets.forEach((wallet) => {
      wallet._token = csrfToken;
      fetchData(url, "post", wallet).then((response) => {});
    });
    createToast("success", "업데이트 성공.");
  });

  refreshMemberRow(mNo);
});

$(document).on("click", ".money-submit", async function (e) {
  let mNo = $(this).data("id");

  await getMemberInfo(mNo).then(async (member) => {
    let url =
      BASE_URL + "/admin/money-info/direct-recharge-or-withdraw/" + member.mID;
    let descriptionWallet = $("#descriptionWallet" + mNo);
    let walletType = $("#walletType" + mNo);
    let moneyNumber = $("#moneyNumber" + mNo);

    let data = {
      miDescription: descriptionWallet.val(),
      miWallet: walletType.val(),
      miType: "AD",
      miBankMoney: moneyNumber.val(),
      _token: csrfToken,
    };

    await fetchData(url, "POST", data).then((response) => {
      createToast("success", "업데이트 성공.");
      $("#descriptionWallet" + mNo).val("");
      $("#walletType" + mNo).prop("selectedIndex", 0);
      $("#moneyNumber" + mNo).val("");
    });
  });

  refreshMemberRow(mNo);
});

const getMemberInfo = (mNo) => {
  let action = BASE_URL + "/admin/status-members/info/" + mNo;
  return fetchData(action, "get").then((data) => data);
};

const refreshMemberRow = (mNo) => {
  let action = BASE_URL + "/admin/status-members/member-row/" + mNo;
  return fetchData(action, "get").then((data) =>
    $(".member-row-info-" + mNo).replaceWith(data.data)
  );
};

const addMemberRow = (row) => {
  $("#RegMemberTable").prepend(row);
};

$(document).on(
  "change",
  'input[id^="mStatusEnable"], input[id^="mStatusBlock"]',
  (e) => {
    let el = $(e.currentTarget);
    let id = el.data("id");
    let isCheck = $(e.target).is(":checked") ? 1 : 0;

    $("#mStatusEnable" + id).prop("disabled", true);
    $("#mStatusBlock" + id).prop("disabled", true);

    $.post(el.attr("url_action") + "/" + isCheck, {
      _token: csrfToken,
    })
      .success((data) => {
        createToast("success", "성공적으로 업데이트되었습니다!");

        $("#mStatusEnable" + id).prop("checked", data.data.is_active);
        $("#mStatusBlock" + id).prop("checked", !data.data.is_active);

        if (data.data.is_active) $(".member-row-" + id).removeClass("alpha-40");
        else $(".member-row-" + id).addClass("alpha-40");
        $("#mStatusEnable" + id).prop("disabled", false);
        $("#mStatusBlock" + id).prop("disabled", false);

        refreshMemberRow(id);
      })
      .error((error) => {
        createToast("error", "업데이트 실패했습니다!");
      });
  }
);

$(document).on(
  "change",
  'input[id^="mcForceLogout"], input[id^="mcIsAlbagi"]',
  (e) => {
    let el = $(e.currentTarget);
    let mNo = el.data("id");

    $.post(
      el.attr("url_action"),
      {
        _token: csrfToken,
      },
      function (data, textStatus, jqXHR) {
        if (!data) {
          el.prop("checked", !el.is(":checked"));
          createToast("error", "업데이트 실패했습니다!");
        } else {
          createToast("success", "성공적으로 업데이트되었습니다!");
          refreshMemberRow(mNo);
        }
      }
    );
  }
);

// Member Config modal game provider
$("body").on("click", ".member-config-modal-game", (e) => {
  e.preventDefault();
  let tbody = $("#tbody_open_game");
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

$(document).on("change", ".isPartnerToggle", (e) => {
  let el = $(e.currentTarget);

  $.post(
    el.attr("url_action"),
    {
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    function (data, textStatus, jqXHR) {
      if (data.success === true) {
        createToast("success", data.message);
      } else if (data.success === false) {
        el.prop("checked", !el.is(":checked"));
        createToast("error", data.message);
      }

      if (data.is_partner === false) {
        $("input[name='mPartnerName'], input[name='mPartnerCode']").val("");
        $("input[name='mPartnerName'], input[name='mPartnerCode']").prop("disabled", true);
      } else {
        $("input[name='mPartnerName'], input[name='mPartnerCode']").prop("disabled", false);
      }
    }
  );
});

// Member Config modal event restrictions
$("body").on("click", ".member-config-event-restrictions", (e) => {
  e.preventDefault();
  let tbody = $("#tbody_event_restrictions");
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
