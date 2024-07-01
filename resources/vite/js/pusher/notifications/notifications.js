export const handleNotification = (data) => {
    let id = data.data["key"];
    let selector = $("#" + id + " p");
    let current = parseInt(selector.html());
    let number = parseInt(data.data["value"]);
    let total = current + number;
    selector.html(total);
    selector.attr('class', 'badge badge-menu-ct badge-square f-s-11  mb-0 ml-6');
    // Sound notification
    const audio = new Audio(SOUND_URL);
    audio.play();

    // Count notification
    selector.addClass('flicker-box');
    setTimeout(() => {
        selector.removeClass('flicker-box')
    }, 2000);
}

export const handleMoneyNotify = (data) => {
    $('.rg_u').html(data.data.count_member_register_today);
    $('.rg_u_approved').html("(" + data.data.count_member_register_approved_today + ")");
    $('.deposit_today').html(data.data.getSumMoneyDepositeRegisterToday);
    $('.deposit_application_number').html("(" + data.data.getCountOrderDepositRegisterToday + ")");
    $('.withdraw_today').html(data.data.getMoneyOrderWithdrawRegisterToday);
    $('.order_withdraw_today').html("(" + data.data.getCountOrderWithdrawRegisterToday + ")");
    $('.profits_today').html(data.data.profitAmountToday);
    $('.sum_money_all_member').html(data.data.getSumMoneyAllMember);
}
