@extends('Partner.page')
@section('content-child')
    <x-common.panel_heading border="true" icon="fa fa-arrow-down" page="DASHBOARD" title="종합현황"/>
    <div class="mt-20 mb-20">
        <a href="{{route(Route::currentRouteName(), ['type' => App\Services\DashboardService::TYPE_DAY])}}" class="dashboard-filter text-center {{App\Services\DashboardService::TYPE_DAY == request()->type ? "active" : ''}}">
            <i class="fa fa-calendar left-calendar" aria-hidden="true"></i>일별
        </a>
        <a href="{{route(Route::currentRouteName(), ['type' => App\Services\DashboardService::TYPE_MONTH])}}" class="dashboard-filter text-center {{App\Services\DashboardService::TYPE_MONTH == request()->type ? "active" : ''}}">
            <i class="fa fa-calendar left-calendar" aria-hidden="true"></i>월별
        </a>
    </div>
    @includeWhen(request('type', \App\Services\DashboardService::TYPE_DAY) == \App\Services\DashboardService::TYPE_DAY, 'Admin.Dashboard.contents_type_day')
    @includeWhen(request('type', \App\Services\DashboardService::TYPE_DAY) == \App\Services\DashboardService::TYPE_MONTH, 'Admin.Dashboard.contents_type_month')
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/page-dashboard-index/dashboard.css'
    ])
    <style>
        #main-content{
            background: none!important;
        }
    </style>
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/pusher/admin/index.js',
    ])
    @yield('js_type')
@endsection
