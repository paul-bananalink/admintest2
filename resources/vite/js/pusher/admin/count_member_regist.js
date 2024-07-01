import { parseNumberToDecimal } from '../../functions.js';

export const countMemberRegist = (data) => {
    $('.count_member_register_today').html(data.count_member_register_today);
    $('.count_member_suspended_today').html(data.count_member_suspended_today);
    changeHtml_Member_Register(data.count_member_register);
    changeHtml_Member_Suspended(data.count_member_suspended);
}

const changeHtml_Member_Register = (count) => {
    if (count >= 0) {
        $('.count_member_register').html(`
            <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비 
            <span class="blue">+${parseNumberToDecimal(Math.abs(count))}</span>
            <span class="blue">명 상승</span>
        `);
    } else {
        $('.count_member_register').html(`
            <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비 
            <span class="red">-${parseNumberToDecimal(Math.abs(count))}</span>
            <span class="red">명 하락</span>
        `);
    }
}

const changeHtml_Member_Suspended = (count) => {
    if (count >= 0) {
        $('.count_member_suspended').html(`
            <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비 
            <span class="blue">+${parseNumberToDecimal(count)}</span>
            <span class="blue">명 상승</span>
        `);
    } else {
        $('.count_member_suspended').html(`
            <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비 
            <span class="red">-${parseNumberToDecimal(Math.abs(count))}</span>
            <span class="red">명 하락</span>
        `);
    }
}
