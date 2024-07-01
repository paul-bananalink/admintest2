@extends('Admin.page')


@section('content-child')
@yield('content-game-provider')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/page-game-provider/index.css',
        'resources/lib/bootstrap/bootstrap-fileupload.css'
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-game-provider/index.js',
        'resources/lib/bootstrap/bootstrap-fileupload.min.js'
    ])
@endsection

