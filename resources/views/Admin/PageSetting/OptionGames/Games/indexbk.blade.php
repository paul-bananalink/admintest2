@extends('Admin.PageSetting.index')

@section('content-child-child')
@include('Admin.PageSetting.OptionGames.setting_label', ['action' => ''])

<div class="box-content-detail bg-black-darker">
    @include('Admin.PageSetting.OptionGames.action_button')
</div>
<div class="box">
    <div class="box-content">
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
        <form action="{{route('admin.page-setting.game-config.update', ['gcType' => $gcType])}}" method="POST" id="game_config">
            @csrf
            <table class="table table-bordered cst-table-darkbrown table-game-config" border="1">
                <tr>
                    <td rowspan="2" class="h-110" style="width: 7.5%;">
                        <button type="submit" class="btnstyle1 btnstyle1-success height-full width-full p-2">
                            <span class="f-s-14"><strong>미니게임</strong></span><br> 
                            <div class="f-s-14 m-t-4">
                                <strong><i class="fa fa-gear"></i> 설정값 저장</strong>
                            </div>
                        </button>
                    </td>

                    <td>
                        <div class="form-group">
                            <label class="h-label-38px">배팅차단</label>
                            <x-common.toggle_switch_button
                                isCheck="{{ $data->gcBlockBet ? 1 : 0 }}"
                                id="gcBlockBet"
                                name="gcBlockBet"
                                urlAction="{{route('admin.page-setting.game-config.toggleField', 
                                ['field' => 'gcBlockBet', 'gcType' => $gcType])}}"
                            />
                        </div>
                    </td>

                    <td>
                        <div class="form-group">
                            <label class="h-label-38px">유저배팅중지내용</label>
                            <input type="text" class="form-control" name="gcNoticeBlockBet" value="{{ $data->gcNoticeBlockBet }}">
                        </div>
                    </td>

                    <td>
                        <div class="form-group">
                            <label class="h-label-38px">중복배팅수</label>
                            <select class="form-control" name="gcDuplicateBetCount">
                                @foreach (config('sport_config.RANGE_10') as $time)
                                    <option value="{{$time}}" @if($data->gcDuplicateBetCount == $time) selected @endif>{{$time}}회</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td colspan="10"></td>
                </tr>

                <tr>
                    <td>회원낙첨포인트 (%)</td>
                    <td>회원롤링포인트 (%)</td>

                    <td>최소단폴 배팅금액</td>
                    <td>최소두폴 배팅금액</td>
                    <td>최소세폴 배팅금액</td>
                    <td>최대단폴 배팅금액</td>
                    <td>최대두폴 배팅금액</td>

                    <td>최대세폴 배팅금액</td>
                    <td>단폴 최대 당첨금액</td>
                    <td>두폴 최대 당첨금액</td>
                    <td>세폴 최대 당첨금액</td>
                    <td>레벨별 유저 배당(%)</td>
                    <td>최대배당</td>
                </tr>

                @foreach (config("site_config.LEVELS") as $level)
                    <tr>
                        <td class="center-middel">{{$level}}레벨</td>
                        @foreach (config("sport_config.FIELDS_GAME_CONFIG_LEVEL") as $field_name => $type)
                            @include('Admin.PageSetting.OptionGames.Games.item', [
                                'level' => $level, 
                                'field_name' => $field_name,
                                'type' => $type
                            ])
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </form>
    </div>
</div>
@endsection

@section('custom-css')
    <style>
        .table-realtime-config td{
            vertical-align: top !important;
        }
        
        .table-realtime-config .flex-center{
            justify-content: left !important;
        }

        .table-realtime-config .form-group{
            margin-bottom: 0;
        }
        .table input[type="number"]{
            border: none;
            padding: 5px;
            width: 100%;
        }
        .flex-input{
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .table .switch{
            margin-bottom: 0
        }
        .table .center-middel{
            text-align: center;
            vertical-align:middle !important;
        }

        .h-label-38px{
            height: 38px;
            overflow: hidden;
        }

    </style>
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js', 
        'resources/vite/js/page_setting/format_money.js'
    ])
@endsection