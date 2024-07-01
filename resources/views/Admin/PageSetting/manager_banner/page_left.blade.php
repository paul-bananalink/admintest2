@extends('Admin.PageSetting.manager_banner.page_manager_banner')

@section('content-child-child-child')
    <div class="box-content">
        <div class="btn-toolbar pull-right">
            <div class="btn-group">
                <button type="button" id="add-banner-btn" class="btn btn-circle show-tooltip btn-xlarge" data-action="{{ route('admin.page-setting.manager-banner.ajaxGetBannerItem') }}">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div><br>
    <div class="box-content">
        @if ($errors->hasBag('update-banner-bag'))
            @foreach ($errors->getBag('update-banner-bag')->all() as $error)
                <div class="alert alert-warning" role="alert">{{ $error }}</div>
            @endforeach
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.page-setting.manager-banner.update', ['bPosition' => 'left']) }}" method="POST" id="page_left">
            @csrf
            <div id="sortable">
                @foreach ($data as $i => $item)
                    <x-common.banner_item :item="$item" :index="$i" />
                @endforeach
            </div>
        </form>
        <div class="text-center m-t">
            <button type="submit" form="page_left" class="btn btn-primary btn-lg">저장</button>
        </div>
    </div>
@endsection

@section('custom-css')
    @vite([
        'resources/lib/bootstrap/bootstrap-fileupload.css',
        'resources/lib/jQueryUI/jquery-ui.min.css',
        'resources/vite/css/page-banner-setting/index.css'
    ]);
@endsection

@section('custom-js')
    @vite([
        'resources/lib/bootstrap/bootstrap-fileupload.min.js',
        'resources/lib/jQueryUI/jquery-ui.min.js',
        'resources/vite/js/page-banner-setting/index.js'
    ]);
@endsection
