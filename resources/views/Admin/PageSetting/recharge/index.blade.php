@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.recharge.form')
@endsection
@section('custom-js')
    @vite(['resources/vite/js/page_setting/format_money.js', 'resources/vite/js/page_setting/recharge_config.js'])
@endsection
