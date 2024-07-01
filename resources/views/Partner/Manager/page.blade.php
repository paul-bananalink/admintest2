@extends('Partner.page')

@section('content-child')
@yield('content-partner-manager')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css',
        'resources/vite/css/toast/style.css',
        'resources/vite/css/page-member-partner/index.css'
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js',
        'resources/vite/js/page-member-partner/index.js'
    ])
@endsection
