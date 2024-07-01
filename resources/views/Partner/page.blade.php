@extends('Partner.Common.page')

@section('header')
    @include('Partner.Common.header')

    {{-- custom css/jquery --}}
    @yield('custom-css')
@endsection

@section('content')
    <body class="skin-black">
        <div class="navbar-fixed-c">
            @include('Partner.Common.navbar')
        </div>
        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            <!-- BEGIN Content -->
            <div id="main-content">
                @include('Admin.loading')
                @yield('content-child')
                @include('Partner.Common.footer')
                @include('Partner.Common.toastify')
                @include('Partner.Notice.modal_show_detail')
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->

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
        @vite(['resources/vite/js/spobulls.js', 'resources/vite/js/loading.js', 'resources/vite/js/pusher/notifications/index.js', 'resources/vite/css/toast/style.css','resources/vite/js/page_setting/format_money.js'])
        <script>
            const BASE_URL = $('meta[name="base_url"]').attr('content')
            const SOUND_URL = "{!! asset('audio/notif-sound.mp3') !!}"
            const WARNING_SOUND_URL = "{!! asset('audio/warning-sound.wav') !!}"
        </script>
        @vite([
            'resources/vite/js/tinymceEditorAll.js', 
            'resources/vite/js/toggle_switch/toggle_switch.js', 
            'resources/vite/js/pusher/status_member/status_member.js',
            'resources/vite/js/custom.js',
            'resources/vite/js/tooltip-action-member/tooltip_member.js', 
            'resources/vite/js/page-status-member/status_member.js',
        ])

        {{-- custom js/jquery --}}
        @yield('custom-js')
    </body>
@endsection
