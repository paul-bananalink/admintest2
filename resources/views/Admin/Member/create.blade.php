@extends('Admin.page')

@section('content-child')
    @include('Admin.Common.breadcrumb', ['title' => '회원'])
    @include('Admin.Member.form_create_member')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/page-status-member/page-status-member-create.css'
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-create-member/create-member.js',
    ])
@endsection
