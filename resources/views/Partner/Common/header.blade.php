<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; IE=9; IE=8;">
    <title>{{env('APP_NAME')}}</title>
    <meta name="description" content="">
    <meta name="base_url" content="{{ env('APP_URL') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!--base css styles-->
    <link rel="stylesheet" href="{{ asset('css/common/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common/font-awesome/css/font-awesome.min.css') }}">
    <!--page specific css styles-->

    <!--lib css styles-->
    <link rel="stylesheet" href="{{ asset('lib/DateRangePicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/SweetAlert/sweetalert2.min.css') }}">

    <!--flaty css styles-->
    <link rel="stylesheet" href="{{ asset('css/admin/flaty.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/flaty-responsive.css') }}">
    @vite([
        'resources/vite/css/icon_ion.css', 
        'resources/vite/css/spobulls.css', 
        'resources/vite/css/admin-partner.css', 
        'resources/vite/css/custom.css', 
        'resources/vite/css/toggle-switch/toggle_style.css', 
        'resources/vite/js/swal_message/swal_message.js',
        'resources/vite/js/swal_message/swal_message_maintenance.js',
    ])
   
    @if(request()->request->has('swal_message'))
        <meta name="swal-message" content="{{ request()->get('swal_message') }}">
    @endif
</head>
