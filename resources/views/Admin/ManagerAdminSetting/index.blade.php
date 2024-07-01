@extends('Admin.page')

@section('content-child')
    @include('Admin.Common.breadcrumb', ['title' => '계정 설정'])
    @include('Admin.ManagerAdminSetting.form_regist_admin')
    @includeWhen(request()->has('open_allow_ip'), 'Admin.ManagerAdminSetting.form_member_allow_ip', ['m_id' => request('open_allow_ip')])
@endsection

@section('custom-css')

@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/page-manager-account-setting/allow_ip.js',
        'resources/vite/js/page-manager-account-setting/manager-account-page.js',
    ])
@endsection
