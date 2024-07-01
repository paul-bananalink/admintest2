@extends('Admin.page')

@section('content-child')
    @include('Admin.Notice.Partner.form', ['notice' => $notice ?? null])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/image_upload.js', 'resources/vite/js/page-notice/validate_notice.js'])
@endsection
