@extends('Admin.page')

@section('content-child')
    @include('Admin.MemberBlock.form_member_block')
@endsection

@section('custom-css')
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/pusher/member_access/member_login_access.js',
        'resources/vite/js/page_member_access/member_access.js',
    ])
@endsection
