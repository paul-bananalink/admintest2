import { handleDataFromPusher } from '../base_pusher.js';
import { addRowToTable } from '../../page-money-info/money_info.js'

handleDataFromPusher('money-info-channel', 'money-info-event', addRowToTable, ["1"])
