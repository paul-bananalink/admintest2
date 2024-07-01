@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.withdraw.form')
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page_setting/withdraw.js',
        'resources/vite/js/page_setting/format_money.js'
    ])
@endsection
