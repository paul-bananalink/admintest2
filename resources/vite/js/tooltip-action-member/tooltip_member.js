import createToast from '../toast/script';
import {
    parseNumberToDecimal,
    formDataToObject,
    fetchData
} from '../functions.js';

$('.btn-send-value-to-model').on('click', (e) => {
    $('#receive-data-from-btn').attr('value', e.currentTarget.getAttribute('target-value'));
    $('#member_comfirm').text(e.currentTarget.getAttribute('target-value-member'));
});

let selectedMember = null
$('[data-toggle="tooltip"]').tooltip();
const TOOLTIP_FIELDS = [
    {
        label: '정보수정', //Edit user
        type: 'member-detail'
    },
    {
        label: '쪽지보내기', //Recharge
        link: "#modal-send-note",
        modal: true,
        type: 'sent-note'
    },
    {
        label: '입금내역', //Histories recharge
        dom: "recharge-histories"
    },
    {
        label: '출금내역', //Histories withdraw
        dom: "withdraw-histories"
    },
    {
        label: '배팅내역', //Betting details
        dom: "betting-details"
    },
    {
        label: '보너스내역', //bonus details
        dom: "bonus-details"
    },
    {
        label: '캐쉬내역', //cash details
        dom: "cash-details"
    }
]

const updateTooltipContent = (element, data) => {
    let tooltips = '<ul>';
    TOOLTIP_FIELDS.forEach(function (field) {
        if (field.type == 'member-detail') {
            tooltips += `<li><a style="cursor: pointer;" class="text-light ${field.class ?? ''}" data-toggle="collapse" data-target="${$(element).data('target')}">${field.label}</a></li>`
        } else {
            if (field.dom) {
                field.link = $(element).data(field.dom)
                field.lock = $(element).data("lock-" + field.dom);
            }
    
            let data_url = ''
            if (field.link == '#modalMemberConfig') {
                data_url = BASE_URL + '/admin/status-members/info/' + $(element).data('mno');
            }
            tooltips += `<li><a data-url="${data_url}" class="text-light ${field.class ?? ''}" target="_blank" ${field.modal ? 'data-type="' + field.type + '" data-toggle="modal"' : ''} href="${field.link}">${field.label}</a></li>`
        }
    })
    $(element).attr("data-original-title", tooltips);
}

let formSubmitted = false; // Check if the form has been submitted, avoid span
let selectedTooltipContent;
$(document).on("click", '[data-toggle="tooltip"]', function (e) {
    e.stopPropagation();
    updateTooltipContent(e.currentTarget);
    $(this).tooltip("toggle");
    $('#mID_modal').text($(e.currentTarget).data('mid'));
    $('[name="mID_modal"]').text($(e.currentTarget).data('mid'));
    $('#mMoney').text(parseNumberToDecimal($(e.currentTarget).data('mmoney')));
    $('#mMoney1').text(parseNumberToDecimal($(e.currentTarget).data('mmoney')));
    $('#mSportsMoney1').text(parseNumberToDecimal($(e.currentTarget).data('msportsmoney')));
    $('#formRechargeOrWithdraw').attr('action', $(e.currentTarget).data('direct-recharge-or-withdraw'));

    selectedMember = $(this).closest('tr').attr('id')
    selectedTooltipContent = e.currentTarget;

    let action = BASE_URL + '/admin/status-members/info/' + $(e.currentTarget).data('mno');
    fetchData(action, 'GET').then(data => {
        $('.mID').val(data.mID);
        $('.mMemberID').val(data.mMemberID);
        $('.mPW').val(data.mPW);
        $('.mBankName').val(data.mBankName);
        $('.mBankNumber').val(data.mBankNumber);
        $('.mBankOwner').val(data.mBankOwner);
        $('.mBankExchangePW').val(data.mBankExchangePW);
        $('.mPhone').val(data.mPhone);
        $('.mNick').val(data.mNick);
        $('.mStatus').val(data.mStatus);
        $('.mNote').val(data.mNote);
        $('.mNo').val(data.mNo);
        formSubmitted = false;
    }).catch(error => {
        createToast('error', '에러가 발생했습니다 .. 다시 시도 해주세요'); // error in Korean
    });
});

$(document).on('submit', '#formRechargeOrWithdraw', function (e) {
    e.preventDefault();

    if (formSubmitted) {
        return;
    }

    formSubmitted = true;

    let action = $(this).attr('action');
    let rawMoneyValue = $('.formatMoney').val().replace(/\,/g, '');
    let data = formDataToObject('formRechargeOrWithdraw');
    data.miBankMoney = rawMoneyValue;
    let amount = parseInt($(this).find('.formatMoney').val().replace(/,/g, ''));

    if ($('#type').val() === 'AD') {
        callBackDataMoney(action, data, amount);
    }
    if ($('#type').val() === 'AW') {
        if ($('[name="miWallet"]').val() === 'sports') {

            let currentMoney = parseFloat($('#mSportsMoney1').text().replace(/,/g, ''));
            let withdrawMoney = parseFloat(data.miBankMoney);
            if (currentMoney < withdrawMoney) {
                createToast('error', '출금금액이 회원의 현재 출금금액보다 적습니다.');
                formSubmitted = false;
                return;
            }

            callBackDataMoney(action, data, amount);
        }
        if ($('[name="miWallet"]').val() === 'casino_slot') {

            let currentMoney = parseFloat($('#mMoney1').text().replace(/,/g, ''));
            let withdrawMoney = parseFloat(data.miBankMoney);

            if (currentMoney < withdrawMoney) {
                createToast('error', '출금금액이 회원의 현재 출금금액보다 적습니다.');
                formSubmitted = false;
                return;
            }

            callBackDataMoney(action, data, amount);
        }
    }
});
function callBackDataMoney(action, data, amount) {
    fetchData(action, 'POST', data)
        .then(data => {
            if (data.status) {
                let id = data.money_info.mID
                let revenue = parseInt($('.mRevenue[attr-mid="' + data.money_info.mID + '"]').text().replace(/,/g, ''))
                revenue += amount
                createToast('success', '성공적으로 처리되었습니다');
                $('#' + selectedMember + ' td:eq(2)').text(parseNumberToDecimal(data.money_info.mMoney));
                $('#mMoney').text(parseNumberToDecimal(data.money_info.mMoney));
                $('#mSportsMoney1').html(parseNumberToDecimal(data.money_info.mSportsMoney));
                $("[data-mid=" + id + "]").data('mmoney', data.money_info.mMoney);
                $("[data-mid=" + id + "]").data('msportsmoney', data.money_info.mSportsMoney);

                $('.mSportsMoney[attr-mid="' + data.money_info.mID + '"]').text(parseNumberToDecimal(data.money_info.mSportsMoney))
                $('.mMoney[attr-mid="' + data.money_info.mID + '"]').text(parseNumberToDecimal(data.money_info.mMoney))
                $('.mRevenue[attr-mid="' + data.money_info.mID + '"]').text(parseNumberToDecimal(revenue))
                $('.formatMoney').val('');
                $('[name="password"]').val('');
                closeModal();
            } else {
                createToast('error', '비밀번호가 잘못됩니다'); // error in Korean
                formSubmitted = false;
            }
        })
        .catch(error => {
            createToast('error', '에러가 발생했습니다 .. 다시 시도 해주세요'); // error in Korean
        });
}

function closeModal() {
    $('#modal-link').modal('hide');
}

$(document).on('click', '[data-type="recharge"]', function () {
    $('#type').val('AD')
    $('#modal_lable_recharge_withdraw').text("관리자충전")
    $('#transactionType').text("충전금액")
})

$(document).on('click', '[data-type="withdraw"]', function () {
    $('#type').val('AW')
    $('#modal_lable_recharge_withdraw').text("관리자환전")
    $('#transactionType').text("환전금액")
})

$('[data-toggle="tooltip"]').on('show.bs.tooltip', function () {
    $('[data-toggle="tooltip"]').not(this).tooltip('hide');
});

$(document).on("click", function (e) {
    if (!$(e.target).closest('[data-toggle="tooltip"]').length) {
        $('[data-toggle="tooltip"]').tooltip("hide");
    }
});
