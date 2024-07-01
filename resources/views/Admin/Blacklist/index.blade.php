@extends('Admin.page')

@section('content-child')
    @include('Admin.Blacklist.form_blacklist')
@endsection

@section('custom-css')

@endsection

@section('custom-js')
    <script src="{{asset('js/admin/page_member_ip_infect/page_member_ip_infect.js')}}"></script>
    @vite([
    ])
@endsection
