@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="m-t-30">
                    <h3 class="cst_h3"><i class="fa fa-cog"></i> 배당 환수율 관리</h3>
                </div>

                <div class="box-content">
                    <div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                        <div class="col-md-12 p-0 text-center bg-black-2 m-b-10">
                            <div class="col-md-12 text-right">
                                <div class="btn-group m-t-10 m-b-10">
                                    <button type="button" class="btnstyle1-primary btnstyle1 height-33 filter-click">
                                        스포츠츠
                                    </button>

                                    <button type="submit" class="btnstyle1-success btnstyle1 height-33 filter-click"
                                        form="form-update-exchange-rate">
                                        <i class="fa fa-cog"></i>
                                        설정값 저장
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="notification">
                                <div class="alert alert-success mt-10">
                                    <button class="close" data-dismiss="alert">×</button>
                                    <strong>Success!</strong> {{ session('success') }}
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="notification">
                                <div class="alert alert-danger mt-10">
                                    <button class="close" data-dismiss="alert">×</button>
                                    <strong>Error!</strong> {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('admin.page-setting.exchange-rate.updateExchangeRate') }}"
                            id="form-update-exchange-rate" method="POST">
                            @csrf
                            <table class="table table-bordered cst-table-darkbrown editor-table">
                                <tr class="thead">
                                    <td class="text-center bg-black p-2">촉구</td>
                                    <td class="text-center bg-black p-2">농구</td>
                                    <td class="text-center bg-black p-2">야구</td>
                                    <td class="text-center bg-black p-2">배구</td>
                                    <td class="text-center bg-black p-2">아이스 허키</td>
                                    <td class="text-center bg-black p-2">탁구</td>
                                    <td class="text-center bg-black p-2">헨드볼</td>
                                    <td class="text-center bg-black p-2">테니스</td>
                                    <td class="text-center bg-black p-2">미식촉구</td>
                                    <td class="text-center bg-black p-2">E-스포츠</td>
                                    <td class="text-center bg-black p-2">권투</td>
                                </tr>
                                <tr class="p-2">
                                    <td class="text-center bg-black p-2">
                                        <input type="text" name="rSoccer" id="rm_f_point_lv1_1"
                                            value="{{ $exchangerate->rSoccer }}"
                                            class="f-s-12 search-input-box width-full text-center">
                                    </td>
                                    <td class="text-center bg-black p-2">
                                        <input type="text" name="rBasketball" id="rm_f_point_lv1_1"
                                            value="{{ $exchangerate->rBasketball }}"
                                            class="f-s-12 search-input-box width-full text-center">
                                    </td>
                                    <td class="text-center bg-black p-2">
                                        <input type="text" name="rBaseball"
                                            class="f-s-12 search-input-box width-full text-center"
                                            value="{{ $exchangerate->rBaseball }}">
                                    </td>
                                    <td class="text-center bg-black p-2"><input
                                            class="f-s-12 search-input-box width-full text-center" name="rVolleyball"
                                            value="{{ $exchangerate->rVolleyball }}"></td>
                                    <td class="text-center bg-black p-2"><input
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="rIce_hockey" value="{{ $exchangerate->rIce_hockey }}"></td>
                                    <td class="text-center bg-black p-2"><input
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="rTable_tennis" value="{{ $exchangerate->rTable_tennis }}"></td>
                                    <td class="text-center bg-black p-2"><input
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="rHandball" value="{{ $exchangerate->rHandball }}"></td>
                                    <td class="text-center bg-black p-2"><input
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="rTennis" value="{{ $exchangerate->rTennis }}"></td>
                                    <td class="text-center bg-black p-2"><input
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="rAmerican_football" value="{{ $exchangerate->rAmerican_football }}"></td>
                                    <td class="text-center bg-black p-2"><input
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="rEsports" value="{{ $exchangerate->rEsports }}"></td>
                                    <td class="text-center bg-black p-2"><input
                                            class="form-control f-s-12 search-input-box width-full text-center"
                                            name="rBoxing" value="{{ $exchangerate->rBoxing }}"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <style>
        .table .switch {
            margin-bottom: 0
        }

        .table input[type="number"] {
            border: none;
            padding: 5px;
        }

        .table .center-middel {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            text-align: center;
        }
    </style>
    @vite(['resources/vite/css/page-setting/page-setting.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/toggle_switch/toggle_switch.js', 'resources/vite/js/page_setting/format_money.js'])
@endsection
