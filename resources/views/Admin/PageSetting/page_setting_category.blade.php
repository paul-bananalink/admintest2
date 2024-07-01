@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.form_page_setting_category')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css',
        'resources/vite/css/page-setting-category/setting_category.css',
        'resources/vite/css/page-casino/casino.css'
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js',
        'resources/vite/js/page_setting/setting_category.js',
    ])
@endsection
