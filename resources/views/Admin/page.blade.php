@extends('Admin.Common.page')

@section('header')
    @include('Admin.Common.header')

    {{-- custom css/jquery --}}
    @yield('custom-css')
@endsection

@section('content')

    <body class="skin-black">
        <div class="navbar-fixed-c">
            @include('Admin.Common.navbar')
        </div>
        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            <!-- BEGIN Content -->
            <div id="main-content">
                @include('Admin.loading')
                @yield('content-child')
                @include('Admin.Common.footer')
                @include('Admin.Common.toastify')
                @include('Admin.Common.Modal.modal_send_note')
                {{-- @include('Admin.Common.Modal.modal_link_recharge_withdraw') --}}
                {{-- @include('Admin.Common.Modal.modal_member_config') --}}
                {{-- @include('Admin.Common.Modal.modal_member_ban_provider') --}}
                {{-- @include('Admin.Common.Modal.modal_member_ban_game') --}}
                {{-- @include('Admin.Common.Modal.modal_create_member') --}}
                @include('Admin.Common.Modal.modal_export_excel')
                @include('Admin.Common.Modal.modal_member_config_game_provider')
                @include('Admin.Common.Modal.modal_transaction_detail')
                @include('Admin.Common.Modal.modal_member_config_event_restrictions')
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->

        </script>
        <!--basic scripts-->
        <script src="{{ asset('js/common/jquery-2.1.4.min.js') }}"></script>
        <script src="{{ asset('js/common/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('js/common/jquery.cookie.js') }}"></script>
        <script src="{{ asset('js/common/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/common/select2.min.js') }}"></script>
        <script src="{{ asset('js/common/tinymce/tinymce.min.js') }}"></script>
        <!--page specific plugin scripts-->

        <!--flaty scripts-->
        <script src="{{ asset('js/admin/flaty.js') }}"></script>
        <script src="{{ asset('js/admin/flaty-demo-codes.js') }}"></script>

        <!--lib scripts-->
        <script src="{{ asset('lib/DateRangePicker/moment.min.js') }}"></script>
        <script src="{{ asset('lib/DateRangePicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('lib/SweetAlert/sweetalert2.min.js') }}"></script>

        {{-- Notifications --}}
        <script>
            const BASE_URL = $('meta[name="base_url"]').attr('content')
            const SOUND_URL = "{!! asset('audio/notif-sound.mp3') !!}"
            const WARNING_SOUND_URL = "{!! asset('audio/warning-sound.wav') !!}"
        </script>
        @vite([
            'resources/vite/js/spobulls.js',
            'resources/vite/js/loading.js',
            'resources/vite/js/pusher/notifications/index.js',
            'resources/vite/css/toast/style.css',
            'resources/vite/js/page_setting/format_money.js',
            'resources/vite/js/tinymceEditorAll.js',
            'resources/vite/js/toggle_switch/toggle_switch.js',
            'resources/vite/js/pusher/status_member/status_member.js',
            'resources/vite/js/custom.js',
            'resources/vite/js/setuptime.js',
            'resources/vite/js/tooltip-action-member/tooltip_member.js',
            'resources/vite/js/page-status-member/status_member.js',
            'resources/vite/js/modal/modal_export_excel.js',
            'resources/vite/js/iconify.min.js',
            'resources/vite/js/swal_message/swal_message_maintenance.js',
        ])

        {{-- custom js/jquery --}}
        @yield('custom-js')
    </body>
@endsection
