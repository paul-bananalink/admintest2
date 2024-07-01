@extends('Admin.page')


@section('content-child')
    @yield('content-settlement')
@endsection

@section('custom-css')
    <style>
        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            border-color: #000;
            padding: 10px 15px;
            background: #fff;
        }
    </style>
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-settlement/index.js',
    ])
@endsection
