@extends('Admin.page')


@section('content-child')
@yield('content-sport')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toast/style.css',
        'resources/vite/css/page-sport/index.css'
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-sport/index.js',
        'resources/vite/js/image_upload.js',
    ])
@endsection
