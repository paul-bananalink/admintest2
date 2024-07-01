export const countMoneyEvent = (data) => {
    $('.sum_money_register_recharge_approved_today').html(data.sum_money_register_recharge_approved_today);
    $('.sum_money_interest_recharge').html(data.sum_money_interest_recharge);
   
    $('.count_order_deposite_register_today').html(data.count_order_deposite_register_today);
    $('.sum_money_register_withdraw_approved_today').html(data.sum_money_register_withdraw_approved_today);
    $('.sum_money_interest_withdraw').html(data.sum_money_interest_withdraw);
    
    $('.count_money_register_withdraw_today').html(data.count_money_register_withdraw_today);
    $('.sum_money_interest_today').html(data.sum_money_interest_today);
    $('.sum_money_compare').html(data.sum_money_compare);

    $('.total_member_bet_today').html(data.total_member_bet_today);
    $('.total_bet_today').html(data.total_bet_today);
    $('.sum_bet_compare').html(data.sum_bet_compare);
}
