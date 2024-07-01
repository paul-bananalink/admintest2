import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  // server: {
  //   host: 'localhost',
  //   port: 8000
  // },
  plugins: [
    laravel({
      input: [
        //css
        "resources/vite/css/page-status-member/page-status-member-create.css",
        "resources/vite/css/page-status-member/page-status-members.css",
        "resources/vite/css/toggle-switch/toggle_style.css",
        "resources/vite/css/page-setting-category/setting_category.css",
        "resources/vite/css/page-casino/casino.css",
        "resources/vite/css/toast/style.css",
        "resources/vite/css/page-game-provider/index.css",
        "resources/lib/bootstrap/bootstrap-fileupload.css",
        "resources/vite/css/page-popup/index.css",
        "resources/vite/css/page-dashboard-index/dashboard.css",
        "resources/vite/css/custom.css",
        "resources/vite/css/page-member-partner/index.css",
        "resources/vite/css/page-consultation/index.css",
        "resources/vite/css/page-money-info/money_info.css",
        "resources/lib/jQueryUI/jquery-ui.min.css",
        "resources/vite/css/page-banner-setting/index.css",
        "resources/vite/css/page-bonus/index.css",
        "resources/vite/css/page-sport/index.css",
        "resources/vite/css/spobulls.css",
        "resources/vite/css/icon_ion.css",
        "resources/vite/css/login.css",
        "resources/vite/css/page-note/index.css",
        "resources/vite/css/page-setting/page-setting.css",
        "resources/vite/css/admin-partner.css",

        //js
        "resources/vite/js/pusher/member_access/member_login_access.js",
        "resources/vite/js/pusher/notifications/notifications.js",
        "resources/vite/js/page-create-member/create-member.js",
        "resources/vite/js/pusher/money_info/money_info.js",
        "resources/vite/js/pusher/status_member/status_member.js",
        "resources/vite/js/page-manager-account-setting/allow_ip.js",
        "resources/vite/js/page-manager-account-setting/manager-account-page.js",
        "resources/vite/js/page_setting/block_ip.js",
        "resources/vite/js/page-casino/casino.js",
        "resources/vite/js/pusher/notifications/index.js",
        "resources/vite/js/pusher/admin/index.js",
        "resources/vite/js/toggle_switch/toggle_switch.js",
        "resources/vite/js/page-game-provider/index.js",
        "resources/lib/bootstrap/bootstrap-fileupload.min.js",
        "resources/vite/js/page_setting/setting_category.js",
        "resources/vite/js/tooltip-action-member/tooltip_member.js",
        "resources/vite/js/dashboard/chart_day.js",
        "resources/vite/js/dashboard/chart_month.js",
        "resources/vite/js/page-popup/index.js",
        "resources/vite/js/page_member_access/member_access.js",
        "resources/vite/js/page-consultation/index.js",
        "resources/vite/js/page-status-member/status_member.js",
        "resources/vite/js/tinymceEditorAll.js",
        "resources/vite/js/custom.js",
        "resources/vite/js/setuptime.js",
        "resources/vite/js/loading.js",
        "resources/vite/js/page-member-partner/index.js",
        "resources/vite/js/page-money-info/money_info.js",
        "resources/vite/js/page_setting/withdraw.js",
        "resources/vite/js/page-status-member/form_status_member.js",
        "resources/vite/js/captcha/captcha.js",
        "resources/vite/js/page_setting/format_money.js",
        "resources/vite/js/page_setting/manager_banner.js",
        "resources/lib/jQueryUI/jquery-ui.min.js",
        "resources/vite/js/page-banner-setting/index.js",
        "resources/vite/js/page-event/index.js",
        "resources/vite/js/page-bonus/index.js",
        "resources/vite/js/page-sport/index.js",
        "resources/vite/js/modal/modal_export_excel.js",
        "resources/vite/js/spobulls.js",
        "resources/vite/js/login.js",
        "resources/vite/js/iconify.min.js",
        "resources/vite/js/page-note/index.js",
        "resources/vite/js/page_setting/index.js",
        "resources/vite/js/page_setting/recharge_config.js",
        "resources/vite/js/page_setting/withdraw_config.js",
        "resources/vite/js/page_setting/template.js",
        "resources/vite/js/page_setting/domain.js",
        "resources/vite/js/page_setting/auto_reply.js",
        "resources/vite/js/image_upload.js",
        "resources/vite/js/page-settlement/index.js",
        "resources/vite/js/page-notice/validate_notice.js",
        "resources/vite/js/swal_message/swal_message.js",
        "resources/vite/js/swal_message/swal_message_maintenance.js",
        "resources/vite/js/page-member-partner/tree_sortable.js",
      ],
      refresh: true,
    }),
  ],
});