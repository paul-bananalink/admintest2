@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.OptionGames.setting_label', ['action' => ''])

    <div class="box-content-detail bg-black-3">
        <div class="bg-black-2 p-12 radius-6">
            @include('Admin.PageSetting.OptionGames.action_button')
        </div>

        <div class="m-t-24 bg-black-2 radius-6">
            <div class="box">
                <div class="box-content pt-0 pb-0">
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
                    <form action="{{ route('admin.page-setting.realtime-config.update') }}" method="POST"
                        id="realtime_config">
                        @csrf
                        <table
                            class="table table-bordered cst-table-darkbrown table-realtime-config table-input-center mb-0"
                            border="1">

                            <tr>
                                <td rowspan="3" class="text-center h-110" style="width: 7.5%;">
                                    <button type="submit" class="btnstyle1 btnstyle1-success height-full width-full p-2">
                                        <span class="f-s-14"><strong>실시간</strong></span><br>
                                        <div class="f-s-14 m-t-4">
                                            <strong><i class="fa fa-gear"></i> 설정값 저장</strong>
                                        </div>
                                    </button>
                                </td>

                                <td class="align-top">배팅차단</td>

                                <td class="align-top">유저배팅중지내용</td>

                                <td class="align-top">중복배팅수</td>

                                <td class="align-top">최대배팅폴더수</td>

                                <td colspan="4" class="align-top">실시간 스포츠 :: 배팅 매칭 대기 카운트 초 설정</td>

                                <td class="align-top">메인배당노출여부</td>

                                <td class="align-top">실시간 피드</td>

                                <td class="align-top">농구 크로스 노출여부</td>
                                <td class="align-top"></td>
                                <td class="align-top"></td>
                            </tr>

                            <tr class="bg-black-darker">
                                <td class="">
                                    <x-common.toggle_switch_button isCheck="{{ $data->rtcBlockBet ? 1 : 0 }}"
                                        id="rtcBlockBet" name="rtcBlockBet"
                                        urlAction="{{ route('admin.page-setting.realtime-config.toggleField', ['field' => 'rtcBlockBet']) }}"
                                        size="normal" />
                                </td>

                                <td class="">
                                    <input type="text" class="form-control" name="rtcNoticeBlockBet"
                                        value="{{ $data->rtcNoticeBlockBet }}">
                                </td>

                                <td class="">
                                    <select class="form-control" name="rtcDuplicateBetCount">
                                        @foreach (config('sport_config.RANGE_10') as $time)
                                            <option value="{{ $time }}"
                                                @if ($data->rtcDuplicateBetCount == $time) selected @endif>{{ $time }}회
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="">
                                    <select class="form-control" name="rtcMaxBetFolderCount">
                                        @foreach (config('sport_config.RANGE_10') as $time)
                                            <option value="{{ $time }}"
                                                @if ($data->rtcMaxBetFolderCount == $time) selected @endif>{{ $time }}폴더
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td colspan="4" class="">
                                    <div class="flex-input">
                                        <select class="form-control" name="rtcRealtimeSoccer" id="selectrtcRealtimeSoccer">
                                            @foreach (config('sport_config.RANGE_TIME_SECOND') as $time)
                                                <option value="{{ $time }}"
                                                    @if ($data->rtcRealtimeSoccer == $time) selected @endif>
                                                    축구:{{ $time }}초</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="rtcRealtimeBasketball"
                                            id="selectrtcRealtimeBasketball">
                                            @foreach (config('sport_config.RANGE_TIME_SECOND') as $time)
                                                <option value="{{ $time }}"
                                                    @if ($data->rtcRealtimeBasketball == $time) selected @endif>
                                                    농구:{{ $time }}초</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="rtcRealtimeBaseball"
                                            id="selectrtcRealtimeBaseball">
                                            @foreach (config('sport_config.RANGE_TIME_SECOND') as $time)
                                                <option value="{{ $time }}"
                                                    @if ($data->rtcRealtimeBaseball == $time) selected @endif>
                                                    야구:{{ $time }}초</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="rtcRealtimeVolleyball"
                                            id="selectrtcRealtimeVolleyball">
                                            @foreach (config('sport_config.RANGE_TIME_SECOND') as $time)
                                                <option value="{{ $time }}"
                                                    @if ($data->rtcRealtimeVolleyball == $time) selected @endif>
                                                    배구:{{ $time }}초</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="rtcRealtimeHockey" id="selectrtcRealtimeHockey">
                                            @foreach (config('sport_config.RANGE_TIME_SECOND') as $time)
                                                <option value="{{ $time }}"
                                                    @if ($data->rtcRealtimeHockey == $time) selected @endif>
                                                    하키:{{ $time }}초</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="rtcRealtimeEsports"
                                            id="selectrtcRealtimeEsports">
                                            @foreach (config('sport_config.RANGE_TIME_SECOND') as $time)
                                                <option value="{{ $time }}"
                                                    @if ($data->rtcRealtimeEsports == $time) selected @endif>
                                                    E스:{{ $time }}초</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>

                                <td class="">
                                    <x-common.toggle_switch_button isCheck="{{ $data->rtcVisibilityOfMainOdds ? 1 : 0 }}"
                                        id="rtcVisibilityOfMainOdds" name="rtcVisibilityOfMainOdds"
                                        urlAction="{{ route('admin.page-setting.realtime-config.toggleField', ['field' => 'rtcVisibilityOfMainOdds']) }}" />
                                </td>

                                <td class="">
                                    <select class="form-control" name="rtcFeed" id="selectrtcFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->rtcFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="">
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->rtcBasketballCrossExposure ? 1 : 0 }}"
                                        id="rtcBasketballCrossExposure" name="rtcBasketballCrossExposure"
                                        urlAction="{{ route('admin.page-setting.realtime-config.toggleField', ['field' => 'rtcBasketballCrossExposure']) }}" />
                                </td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td class="align-top">회원낙첨포인트 (%)</td>
                                <td class="align-top">회원롤링포인트 (%)</td>

                                <td class="align-top">최소단폴 배팅금액</td>
                                <td class="align-top">최소두폴 배팅금액</td>
                                <td class="align-top">최소세폴 배팅금액</td>
                                <td class="align-top">최대단폴 배팅금액</td>
                                <td class="align-top">최대두폴 배팅금액</td>

                                <td class="align-top">최대세폴 배팅금액</td>
                                <td class="align-top">단폴 최대 당첨금액</td>
                                <td class="align-top">두폴 최대 당첨금액</td>
                                <td class="align-top">세폴 최대 당첨금액</td>
                                <td class="align-top">레벨별 유저 배당(%)</td>
                                <td class="align-top">최대배당</td>
                            </tr>

                            @foreach (config('site_config.LEVELS') as $level)
                                <tr>
                                    <td class="center-middel">{{ $level }}레벨</td>
                                    @foreach (config('sport_config.FIELDS_REALTIME_CONFIG_LEVEL') as $field_name => $type)
                                        @include('Admin.PageSetting.OptionGames.Sports.RealTimes.item', [
                                            'level' => $level,
                                            'field_name' => $field_name,
                                            'type' => $type,
                                        ])
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <style>
        .table-realtime-config .form-group {
            margin-bottom: 0;
        }

        .table input[type="number"] {
            border: none;
            padding: 5px;
            width: 100%;
        }

        .flex-input {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .table .switch {
            margin-bottom: 0
        }

        .table .center-middel {
            text-align: center;
            vertical-align: middle !important;
        }

        .h-label-38px {
            height: 38px;
            overflow: hidden;
        }

        .flex-center {
            height: 31px;
        }
    </style>
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/toggle_switch/toggle_switch.js', 'resources/vite/js/page_setting/format_money.js'])
@endsection
