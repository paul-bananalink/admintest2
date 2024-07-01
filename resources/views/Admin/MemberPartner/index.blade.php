@extends('Admin.MemberPartner.page')

@section('content-partner')
    @include('Admin.MemberPartner.breadcrumb', ['title' => '파트너'])
    @include('Admin.MemberPartner.treeview_new')
@endsection
