@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.AutoReply.form')
    @include('Admin.PageSetting.AutoReply.modal')
@endsection
@section('custom-css')
    @vite(['resources/lib/jQueryUI/jquery-ui.min.css']);
@endsection
@section('custom-js')
    @vite(['resources/lib/jQueryUI/jquery-ui.min.js', 'resources/vite/js/page_setting/auto_reply.js'])
@endsection
