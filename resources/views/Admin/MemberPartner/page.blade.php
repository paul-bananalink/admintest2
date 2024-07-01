@extends('Admin.page')


@section('content-child')
@yield('content-partner')
{{-- @include('Admin.Common.Modal.Partner.modal_create_partner') --}}
{{-- @include('Admin.Common.Modal.Partner.modal_update_partner') --}}
@endsection

@section('custom-css')
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css',
        'resources/vite/css/toast/style.css',
        'resources/vite/css/page-member-partner/index.css'
    ])
@endsection

@section('custom-js')
    <script src="{{ asset('lib/TreeSortable/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('lib/TreeSortable/js/treeSortable.js') }}"></script>
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js',
        'resources/vite/js/page-member-partner/index.js',
        'resources/vite/js/page-member-partner/tree_sortable.js'
    ])
@endsection
