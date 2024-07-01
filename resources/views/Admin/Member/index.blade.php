@extends('Admin.page')

@section('content-child')
    <x-common.panel_heading title="회원"/>
    @include('Admin.Member.form_status_members')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css',
        'resources/vite/css/page-status-member/page-status-members.css',
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-status-member/form_status_member.js',
    ])
@endsection

