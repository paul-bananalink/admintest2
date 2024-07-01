@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.form_page_setting_block_ip')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css',
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page_setting/block_ip.js',
    ])
@endsection
