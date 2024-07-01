import { handleDataFromPusher } from '../base_pusher.js';
import { addRowToTable } from '../../page-status-member/form_status_member.js'

handleDataFromPusher('status-member-channel', 'status-member-event', addRowToTable);
