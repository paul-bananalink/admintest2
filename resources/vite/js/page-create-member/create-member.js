import createToast from "../toast/script";

$(document).ready(function () {
  let csrfToken = $('meta[name="csrf-token"]').attr("content");
  // let is_check_unique_memeber = false;
  // let is_check_unique_nick_name = false;
  let isMemberIdChecked = false;

  $(document).on("click", "#btn-check-member-id", (e) => {
    let el = $(e.currentTarget);
    let key = $("#mPartnerCode").val();

    if (key) {
      $.post(
        el.attr("target-url"),
        {
          _token: csrfToken,
          mPartnerCode: key,
        },
        function (data) {
          if (data.is_check) {
            createToast("success", "아이디가 있습니다.");
            isMemberIdChecked = true;
          } else {
            createToast("warning", "아이디가 없습니다.");
            isMemberIdChecked = false;
          }
        }
      ).fail(function () {
        createToast("error", "서버 오류가 발생했습니다. 다시 시도해주세요.");
        isMemberIdChecked = false;
      });
    } else {
      createToast("warning", "추천인ID를 입력해주세요.");
    }
  });
  $(document).on("click", "#btn-create-member", function (e) {
    let memberId = $("#mPartnerCode").val();

    if (memberId && !isMemberIdChecked) {
      e.preventDefault();
      createToast("warning", "아이디를 체크해주세요.");
    } else {
      $("#create-member-form").submit();
    }
  });
});

// $("#btn-check-unique-member-id").on("click", (e) => {
//   let el = $(e.currentTarget);
//   let key = $("#mID").val();
//   let regex = /^[a-zA-Z0-9]*$/;

//   if (key) {
//     if (!regex.test(key)) {
//       createToast("error", "영숫자만 입력해주세요.");
//       $("#mID").val("");
//       return;
//     }

//     $.post(
//       el.attr("target-url"),
//       {
//         _token: csrfToken,
//         mID: key,
//       },
//       function (data, textStatus, jqXHR) {
//         if (data.is_check) {
//           createToast("success", "확인되었습니다.");
//           is_check_unique_memeber = true;
//         } else {
//           createToast("warning", "사용자 이름이 이미 존재합니다.");
//           $("#mID").val("");
//         }
//       }
//     );
//   } else {
//     createToast("warning", "회원ID를 입력해주세요.");
//   }
// });
// $("#mID").on("input", function () {
//   var sanitized = $(this).val().replace(/[^\w]/gi, "");
//   $(this).val(sanitized);
// });

// $("#btn-check-member-nick").on("click", (e) => {
//   let el = $(e.currentTarget);
//   let key = $("#mNick").val();
//   let regex = /^[a-zA-Z0-9]*$/;
//   if (key) {
//     if (!regex.test(key)) {
//       createToast("error", "닉네임은 특수문자 제외합니다.");
//       $("#mNick").val("");
//       return;
//     }
//     $.post(
//       el.attr("target-url"),
//       {
//         _token: csrfToken,
//         mNick: $("#mNick").val(),
//       },
//       function (data, textStatus, jqXHR) {
//         if (data.is_check) {
//           createToast("success", "확인되었습니다.");
//           is_check_unique_nick_name = true;
//         } else {
//           $("#mNick").val("");
//           createToast("warning", "사용할 수 없는 닉네임입니다.");
//         }
//       }
//     );
//   } else {
//     createToast("warning", "닉네임을 입력해주세요.");
//   }
// });

// $("#mNick").on("input", function () {
//   var sanitized = $(this).val().replace(/[^\w]/gi, "");
//   $(this).val(sanitized);
// });

// $('#btn-create-member').on('click', (e) => {
//     if (!is_check_unique_member) {
//         createToast('warning', '회원ID를 검색해주세요.');
//     } if (!is_check_unique_nick_name) {
//         createToast('warning', '닉네임을 검색해주세요.');
//     } if (is_check_unique_member && is_check_unique_nick_name) {
//         var phoneNumber = $('#phone-input').val().replace(/\s+/g, '');
//         $('#phone-input').val(phoneNumber);

//         $('#form-create-member').submit();
//     }
// });
