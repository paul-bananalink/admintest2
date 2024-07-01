@extends('Partner.page')


@section('content-child')
@yield('content-casino')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/page-casino/casino.css'
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-casino/casino.js',
    ])
@endsection
