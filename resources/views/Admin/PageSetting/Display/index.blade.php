@extends('Admin.PageSetting.Display.page')

@section('content-child-child')
    @include('Admin.PageSetting.Display.content')
@endsection

@section('custom-css')
    @vite(['resources/lib/bootstrap/bootstrap-fileupload.css'])
@endsection

@section('custom-js')
    @vite(['resources/lib/bootstrap/bootstrap-fileupload.min.js', 'resources/vite/js/page_setting/manager_banner.js'])
@endsection
