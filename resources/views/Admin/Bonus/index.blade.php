@extends('Admin.page')

@section('content-child')
    {{-- <x-common.panel_heading icon="fa fa-arrow-down" page="BONUS DATA" title="보너스관리" form="Admin.Bonus.search_form" /> --}}
    <div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
        <h4 class="panel-title m-5 flex-1">
            <strong>
                <i class="fa fa-arrow-down"></i> BONUS DATA :: 보너스관리
            </strong>
        </h4>
        @include('Admin.Bonus.search_form')
    </div>
    @include('Admin.Bonus.new_form_bonus')
    <x-common.panel_heading icon="fa fa-arrow-down" title="보너스처리-관리자" form="Admin.Bonus.admin_handle" />
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css',
        'resources/vite/css/page-bonus/index.css',
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-bonus/index.js',
    ])
@endsection
