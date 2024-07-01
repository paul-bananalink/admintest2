@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="m-t-30">
                    <h3 class="cst_h3"><i class="fa fa-cog"></i> 지급포인트설정</h3>
                    <div class="col-md-12 panel btn-group m-0 m-t-10 m-b-10 p-5 text-white bg-black-3">
                        <div class="col-md-12 p-0 text-center">
                            <div class="bg-black-2 col-md-12 text-right title-page">
                                <div class="pull-left text-left">
                                    <h2 class="cst_h3 text-white">::신규 도메인 추가 및 파트너가입코드 고정 (최대 8개까지 등록 가능)</h2>
                                </div>
                                <form action="{{ route('admin.page-setting.domain.createDomain') }}" method="POST"
                                    class="btn-group m-t-10 m-b-10" id="create-domain">
                                    @csrf
                                    <input name="dPartNer" placeholder="관리자 or 파트너아이디" type="text"
                                        class="form-control width-200 height-33 text-white filter-click">
                                    <input name="dDomain" placeholder="사이트도메인" type="text"
                                        class="form-control width-200 height-33 text-white filter-click">
                                    <input name="dName" placeholder="사이트명" type="text"
                                        class="form-control width-200 height-33 text-white filter-click">
                                    <input name="dTitle" placeholder="사이트 타이틀" type="text"
                                        class="form-control width-200 height-33 text-white filter-click">
                                    <button type="submit"
                                        class="btnstyle1-success btnstyle1 height-33 filter-click create-domain">사이트
                                        추가</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-content" style="padding-top: 74px !important;">
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
                    <div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                        <table class="table table-bordered cst-table-darkbrown editor-table">
                            <tr class="thead">
                                <td class="text-center bg-black" style="width: 10%;">등록일자</td>
                                <td class="text-center bg-black">도메인</td>
                                <td class="text-center bg-black">파트너아이디</td>
                                <td class="text-center bg-black">파트너명</td>
                                <td class="text-center bg-black">가입코드</td>
                                <td class="text-center bg-black">사이트명</td>
                                <td class="text-center bg-black">사이트 타이틀</td>
                                <td class="text-center bg-black">관리자 메모</td>
                                <td class="text-center bg-black" style="width: 7%;">대문여부</td>
                                <td class="text-center bg-black" style="width: 7%;">리뉴여부</td>
                                <td class="text-center bg-black" style="width: 10%;">
                                    #
                                    </th>
                                    </thead>
                                    @foreach ($data as $item)
                            <tr class="p-2">
                                <form action="{{ route('admin.page-setting.domain.updateDomain', ['id' => $item->dNo]) }}"
                                    method="POST" id="form-update-domain-{{ $item->dNo }}">
                                    @csrf
                                    <td class="text-white2 text-center bg-black-darker p-2">
                                        <div class="m-t-5">{{ $item->dRegDate }}</div>
                                    </td>
                                    <td class="text-center bg-black p-2">
                                        <input type="text" id="rm_f_point_lv1_1" value="{{ $item->dDomain }}"
                                            name ="dDomain" class="f-s-12 search-input-box width-full text-center">
                                    </td>
                                    <td class="text-center bg-black p-2">
                                        <input type="text" class="f-s-12 search-input-box width-full text-center"
                                            name="dPartNer" value="{{ $item->dPartNer }}" inputmode="decimal">
                                    </td>
                                    <td class="text-center bg-black p-2"><input type="text"
                                            class="f-s-12 search-input-box width-full text-center" inputmode="decimal"
                                            name="dPartNerName" value="{{ $item->dPartNerName }}"></td>
                                    <td class="text-center bg-black p-2"><input type="text"
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="dCode" value="{{ $item->dCode }}" inputmode="decimal"></td>
                                    <td class="text-center bg-black p-2"><input type="text"
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="dName" value="{{ $item->dName }}" inputmode="decimal"></td>
                                    <td class="text-center bg-black p-2"><input type="text"
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="dTitle" value="{{ $item->dTitle }}" inputmode="decimal"></td>
                                    <td class="text-center bg-black p-2"><input type="text"
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="dNote" value="{{ $item->dNote }}" inputmode="decimal"></td>
                                </form>
                                <td class="text-center bg-black p-2">
                                    <label class="switch">
                                        <x-common.toggle_switch_button isCheck="{{ $item->dIsMain }}" id="dIsMain"
                                            name="dIsMain"
                                            urlAction="{{ route('admin.page-setting.domain.toggleField', ['field' => 'dIsMain', 'id' => $item->dNo]) }}" />
                                    </label>
                                </td>
                                <td class="text-center bg-black p-2">
                                    <label class="switch">
                                        <x-common.toggle_switch_button isCheck="{{ $item->dIsRefresh }}" id="dIsRefresh"
                                            name="dIsRefresh"
                                            urlAction="{{ route('admin.page-setting.domain.toggleField', ['field' => 'dIsRefresh', 'id' => $item->dNo]) }}" />
                                    </label>
                                </td>
                                <td class="bg-black-darker">
                                    <div class="el-row">
                                        <button type="submit" class="btnstyle1 btnstyle1-primary btnstyle1-sm m-r-8"
                                            form="form-update-domain-{{ $item->dNo }}"><strong>저장</strong></button>
                                        <button type="button"
                                            data-route="{{ route('admin.page-setting.domain.deleteDomain', ['id' => $item->dNo]) }}"
                                            class="btnstyle1 btnstyle1-danger btnstyle1-sm delete-btn"><strong>취소</strong></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    @vite(['resources/vite/css/page-setting/page-setting.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/toggle_switch/toggle_switch.js', 'resources/vite/js/page_setting/domain.js'])
@endsection
