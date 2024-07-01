@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.Template.form')
    @include('Admin.PageSetting.Template.modal')
@endsection

@section('custom-css')
    @vite(['resources/lib/jQueryUI/jquery-ui.min.css'])
@endsection
@section('custom-js')
    @vite(['resources/lib/jQueryUI/jquery-ui.min.js', 'resources/vite/js/page_setting/template.js'])
@endsection
