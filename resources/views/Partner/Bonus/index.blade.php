@extends('Partner.page')

@section('content-child')
    <div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
        <h4 class="panel-title m-5 flex-1">
            <strong>
                <i class="fa fa-arrow-down"></i> BONUS DATA :: 보너스관리
            </strong>
        </h4>
        @include('Partner.Bonus.search_form')
    </div>
    @include('Partner.Bonus.new_form_bonus')
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
