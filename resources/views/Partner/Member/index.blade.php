@extends('Partner.page')

@section('content-child')
    @include('Partner.Member.form_status_members')
@endsection

@section('custom-css')
    @vite(['resources/vite/css/page-status-member/page-status-members.css'])
@endsection

@section('custom-js')
    @vite([])
@endsection
