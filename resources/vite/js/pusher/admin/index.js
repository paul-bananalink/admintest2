import { handleDataFromPusher } from "../base_pusher";
import { countMemberLogined } from "./count_member_logined";
import { countMemberRegist } from "./count_member_regist";
import { countMoneyEvent } from "./count_money";
import { adminLogoutEvent } from "./admin_logout";

handleDataFromPusher('mananger-member-login-channel', 'mananger-member-login-event', countMemberLogined);
handleDataFromPusher('mananger-member-regist-channel', 'mananger-member-regist-event', countMemberRegist);
handleDataFromPusher('mananger-money-channel', 'mananger-money-event', countMoneyEvent);
handleDataFromPusher('admin-logout-channel', 'admin-logout-event-' + $('#id_admin').val(), adminLogoutEvent);
