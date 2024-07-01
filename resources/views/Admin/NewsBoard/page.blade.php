@extends('Admin.page')


@section('content-child')
@yield('content-newsboard')
@endsection

@section('custom-css')
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js',
        'resources/vite/js/page-event/index.js'
    ])
@endsection