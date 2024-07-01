@extends('Admin.page')

@section('content-child')
    <x-common.panel_heading icon="fa fa-arrow-down" page="OPTION SET" title="옵션-기본환경설정관리" action="Admin.PageSetting.action_box"/>
    @yield('content-child-child')
@endsection
