import { handleDataFromPusher } from "../base_pusher";
import {
    handleNotification,
    handleMoneyNotify,
} from './notifications';
import { handleWarningNotification } from './warning_notifications';
import { addRowToTable } from '../../page-money-info/money_info.js'

handleDataFromPusher('count-notification-channel', 'count-notification-event', handleNotification);
handleDataFromPusher('count-notification-channel', 'add-row-consultation-event', addRowToTable);
handleDataFromPusher('money-channel', 'total-money-event', handleMoneyNotify);
handleDataFromPusher('warning-max-bet-channel', 'warning-max-bet-event', handleWarningNotification);