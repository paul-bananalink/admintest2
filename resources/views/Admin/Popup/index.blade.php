@extends('Admin.page')


@section('content-child')
@include('Admin.Common.toastify')
<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <x-common.panel_heading page="POPUP LIST" title="팝업 관리" form="Admin.Popup.search"/>
            <div class="box-content">
                @if (session('success'))
                    <div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        <button class="close" data-dismiss="alert">×</button>
                        {{ session('error') }}
                    </div>
                @endif
                    
                <div class="row">
                    @foreach ($data as $i => $item)
                        @include('Admin.Popup.popup')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Main Content -->
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css',
        'resources/vite/css/toast/style.css',
        'resources/vite/css/page-popup/index.css',
        'resources/lib/bootstrap/bootstrap-fileupload.css',
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js',
        'resources/vite/js/page-popup/index.js',
        'resources/lib/bootstrap/bootstrap-fileupload.min.js',
    ])
@endsection