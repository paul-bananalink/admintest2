@extends('Admin.page')


@section('content-child')
@yield('content-note-custom')
@endsection

@section('custom-css')
    @vite(['resources/vite/css/page-note/index.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/page-note/index.js'])
@endsection
