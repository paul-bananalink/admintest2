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
                    <form action="{{ route('admin.page-setting.sport-config.update') }}" method="POST" id="sport_config">
                        @csrf
                        <table class="table table-bordered cst-table-darkbrown table-sport-config table-input-center mb-0"
                            border="1">
                            <tr>
                                <td rowspan="7" colspan="3" class="h-110" style="width: 7.5%;">
                                    <button type="submit" class="btnstyle1 btnstyle1-success height-full width-full p-2">
                                        <span class="f-s-14"><strong>스포츠</strong></span><br>
                                        <div class="f-s-14 m-t-4">
                                            <strong><i class="fa fa-gear"></i> 설정값 저장</strong>
                                        </div>
                                    </button>
                                </td>
                                <td class="align-top" style="width: 6%">배팅차단</td>
                                <td class="align-top">유저배팅중지내용</td>

                                <td class="align-top">배팅마감초</td>
                                <td class="align-top">중복배팅수</td>
                                <td class="align-top">최대배팅폴더수</td>

                                <td class="align-top" colspan="2">다폴더보너스사용여부</td>

                                <td class="align-top">3폴더보너스배당</td>
                                <td class="align-top">6폴더보너스배당</td>
                                <td class="align-top">9폴더보너스배당</td>

                                <td class="align-top">배팅취소사용여부</td>

                                <td class="align-top">일배팅취소가능횟수</td>
                                <td class="align-top">배팅 후 몇분뒤 취소가능 (시스템 적으로도 초로 설정되어있는지 확인요망)</td>
                                <td class="align-top">시작전몇분전배팅취소가능</td>

                                <td class="align-top">배팅자동취소여부</td>
                            </tr>

                            <tr class="bg-black-darker">
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scBlockBet ? 1 : 0 }}" id="scBlockBet"
                                        name="scBlockBet"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scBlockBet']) }}"
                                        size="normal" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="scNoticeBlockBet"
                                        value="{{ $data->scNoticeBlockBet }}">
                                </td>

                                <td>
                                    <input type="text" class="formatPercent form-control" name="scTimeBet"
                                        value="{{ $data->scTimeBet }}">
                                </td>
                                <td>
                                    <select class="form-control" name="scDuplicateBetCount">
                                        @foreach (config('sport_config.RANGE_10') as $time)
                                            <option value="{{ $time }}"
                                                @if ($data->scDuplicateBetCount == $time) selected @endif>{{ $time }}회
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="scMaxBetFolderCount">
                                        @foreach (config('sport_config.RANGE_10') as $time)
                                            <option value="{{ $time }}"
                                                @if ($data->scMaxBetFolderCount == $time) selected @endif>{{ $time }}폴더
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td colspan="2">
                                    <div class="flex-input">
                                        <div class="flex-1">
                                            <x-common.toggle_switch_button
                                                isCheck="{{ $data->scIsUseBonusAllFolder ? 1 : 0 }}"
                                                id="scIsUseBonusAllFolder" name="scIsUseBonusAllFolder"
                                                urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scIsUseBonusAllFolder']) }}"
                                                size="normal" />
                                        </div>
                                        <input type="text" class="formatMoney form-control w-50"
                                            name="scValueUseBonusAllFolder"
                                            value="{{ formatNumber($data->scValueUseBonusAllFolder) }}">
                                    </div>
                                </td>

                                <td>
                                    <input type="text" class="formatPercent form-control" name="sc3FolderBonusOdds"
                                        value="{{ $data->sc3FolderBonusOdds }}">
                                </td>
                                <td>
                                    <input type="text" class="formatPercent form-control" name="sc6FolderBonusOdds"
                                        value="{{ $data->sc6FolderBonusOdds }}">
                                </td>
                                <td>
                                    <input type="text" class="formatPercent form-control" name="sc9FolderBonusOdds"
                                        value="{{ $data->sc9FolderBonusOdds }}">
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scCancelBet ? 1 : 0 }}"
                                        id="scCancelBet" name="scCancelBet"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scCancelBet']) }}"
                                        size="normal" />
                                </td>

                                <td>
                                    <input type="text" class="formatPercent form-control" name="scMaxCancelSingleBet"
                                        value="{{ $data->scMaxCancelSingleBet }}">
                                </td>
                                <td>
                                    <input type="text" class="formatPercent form-control" name="scSecondCancelAfterBet"
                                        value="{{ $data->scSecondCancelAfterBet }}">
                                </td>
                                <td>
                                    <input type="text" class="formatPercent form-control" name="scMinusCancelAfterBet"
                                        value="{{ $data->scMinusCancelAfterBet }}">
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scAutoCancelBet ? 1 : 0 }}"
                                        id="scAutoCancelBet" name="scAutoCancelBet"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scAutoCancelBet']) }}"
                                        size="normal" />
                                </td>
                            </tr>

                            <tr>
                                <td class="align-top">축배팅가능여부</td>

                                <td class="align-top">축구 승무패 + 언더오버</td>
                                <td class="align-top">축구 승패 + 언더오버</td>
                                <td class="align-top">축구 핸디캡 + 언더오버</td>
                                <td class="align-top">축구 무승부 + 언더오버</td>

                                <td class="align-top">농구 승패 + 언더오버</td>
                                <td class="align-top">농구 핸디캡 + 언더오버</td>

                                <td class="align-top">야구 승패 + 언더오버</td>
                                <td class="align-top">야구 핸디캡 + 언더오버</td>

                                <td class="align-top">배구 승패 + 언더오버</td>
                                <td class="align-top">배구 핸디캡 + 언더오버</td>

                                <td class="align-top">하키 승무패 + 언더오버</td>
                                <td class="align-top">하키 승패 + 언더오버</td>
                                <td class="align-top">하키 핸디캡 + 언더오버</td>
                                <td class="align-top">하키 무승부 + 언더오버</td>
                            </tr>

                            <tr class="bg-black-darker">
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scExitBet ? 1 : 0 }}"
                                        id="scExitBet" name="scExitBet"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scExitBet']) }}"
                                        size="normal" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scFootballWinDrawLossOU ? 1 : 0 }}"
                                        id="scFootballWinDrawLossOU" name="scFootballWinDrawLossOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scFootballWinDrawLossOU']) }}" />
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scFootballWinLossOU ? 1 : 0 }}"
                                        id="scFootballWinLossOU" name="scFootballWinLossOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scFootballWinLossOU']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scFootballHandicapOU ? 1 : 0 }}"
                                        id="scFootballHandicapOU" name="scFootballHandicapOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scFootballHandicapOU']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scFootballDrawOU ? 1 : 0 }}"
                                        id="scFootballDrawOU" name="scFootballDrawOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scFootballDrawOU']) }}" />
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scBasketballWinLossOU ? 1 : 0 }}"
                                        id="scBasketballWinLossOU" name="scBasketballWinLossOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scBasketballWinLossOU']) }}" />
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scBasketballHandicapOU ? 1 : 0 }}"
                                        id="scBasketballHandicapOU" name="scBasketballHandicapOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scBasketballHandicapOU']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scBaseballWinLossOU ? 1 : 0 }}"
                                        id="scBaseballWinLossOU" name="scBaseballWinLossOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scBaseballWinLossOU']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scBaseballHandicapOU ? 1 : 0 }}"
                                        id="scBaseballHandicapOU" name="scBaseballHandicapOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scBaseballHandicapOU']) }}" />
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scVolleyballWinLossOU ? 1 : 0 }}"
                                        id="scVolleyballWinLossOU" name="scVolleyballWinLossOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scVolleyballWinLossOU']) }}" />
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scVolleyballHandicapOU ? 1 : 0 }}"
                                        id="scVolleyballHandicapOU" name="scVolleyballHandicapOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scVolleyballHandicapOU']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scHockeyWinDrawLossOU ? 1 : 0 }}"
                                        id="scHockeyWinDrawLossOU" name="scHockeyWinDrawLossOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scHockeyWinDrawLossOU']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scHockeyWinLossOU ? 1 : 0 }}"
                                        id="scHockeyWinLossOU" name="scHockeyWinLossOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scHockeyWinLossOU']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scHockeyHandicapOU ? 1 : 0 }}"
                                        id="scHockeyHandicapOU" name="scHockeyHandicapOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scHockeyHandicapOU']) }}" />
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scHockeyDrawOU ? 1 : 0 }}"
                                        id="scHockeyDrawOU" name="scHockeyDrawOU"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scHockeyDrawOU']) }}" />
                                </td>
                            </tr>

                            <tr>
                                <td class="align-top">메인배당노출여부</td>
                                <td class="align-top">농구 크로스 노출여부</td>

                                <td class="align-top">야구 크로스 노출여부
                                </td>
                                <td class="align-top">배당 옵션 갯수필터
                                </td>
                                <td class="align-top">축구피드</td>

                                <td class="align-top">농구피드</td>

                                <td class="align-top">야구피드</td>
                                <td class="align-top">배구피드</td>
                                <td class="align-top">아이스하키피드</td>

                                <td class="align-top">핸드볼피드</td>

                                <td class="align-top">테니스피드</td>
                                <td class="align-top">미식축구피드</td>
                                <td class="align-top">이스포츠피드</td>
                                <td class="align-top">탁구피드</td>

                                <td class="align-top">복싱피드</td>
                            </tr>

                            <tr class="bg-black-darker">
                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scVisibilityOfMainOdds ? 1 : 0 }}"
                                        id="scVisibilityOfMainOdds" name="scVisibilityOfMainOdds"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scVisibilityOfMainOdds']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBasketballCrossExposure ? 1 : 0 }}"
                                        id="scBasketballCrossExposure" name="scBasketballCrossExposure"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scBasketballCrossExposure']) }}" />
                                </td>

                                <td>
                                    <x-common.toggle_switch_button isCheck="{{ $data->scBaseballCrossExposure ? 1 : 0 }}"
                                        id="scBaseballCrossExposure" name="scBaseballCrossExposure"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scBaseballCrossExposure']) }}" />
                                </td>
                                <td>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scFilterCountOptionDistribution ? 1 : 0 }}"
                                        id="scFilterCountOptionDistribution" name="scFilterCountOptionDistribution"
                                        urlAction="{{ route('admin.page-setting.sport-config.toggleField', ['field' => 'scFilterCountOptionDistribution']) }}" />
                                </td>
                                <td>
                                    <select class="form-control" name="scSoccerFeed" id="selectscSoccerFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scSoccerFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control" name="scBasketballFeed" id="selectscBasketballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scBasketballFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control" name="scBaseballFeed" id="selectscBaseballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scBaseballFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="scVolleyballFeed" id="selectscVolleyballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scVolleyballFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="scIceHockeyFeed" id="selectscIceHockeyFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scIceHockeyFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control" name="scHandballFeed" id="selectscHandballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scHandballFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control" name="scTenisFeed" id="selectscTenisFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scTenisFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="scAmericanFootballFeed"
                                        id="selectscAmericanFootballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scAmericanFootballFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="scEsportsFeed" id="selectscEsportsFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scEsportsFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="scPingPongFeed" id="selectscPingPongFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scPingPongFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control" name="scBoxingFeed" id="selectscBoxingFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{ $k }}"
                                                @if ($data->scBoxingFeed == $k) selected @endif>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-top">회원낙첨포인트(%)</td>
                                <td class="align-top">회원롤링포인트(%)</td>

                                <td class="align-top">축배팅최대 배팅금액</td>
                                <td class="align-top">축배팅최대 당첨금액</td>
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
                                    <td colspan="3" class="center-middel">{{ $level }}레벨</td>
                                    @foreach (config('sport_config.FIELDS_SPORT_CONFIG_LEVEL') as $field_name => $type)
                                        @include('Admin.PageSetting.OptionGames.Sports.item', [
                                            'level' => $level,
                                            'field_name' => $field_name,
                                            'type' => $type,
                                        ])
                                    @endforeach
                                </tr>
                            @endforeach

                        </table>
                        {{-- <table class="table table-bordered cst-table-darkbrown table-sport-config" border="1">
                        <tr>
                            <td rowspan="4" class="text-center">
                                <button type="submit" class="btn btn-info btn-lg">
                                    설<br>
                                    정<br>
                                    값<br>
                                    저<br>
                                    장<br>
                                </button>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">배팅차단</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBlockBet ? 1 : 0 }}"
                                        id="scBlockBet"
                                        name="scBlockBet"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scBlockBet'])}}"
                                    />
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">유저배팅중지내용</label>
                                    <input type="text" class="form-control" name="scNoticeBlockBet" value="{{ $data->scNoticeBlockBet }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">배팅마감초</label>
                                    <input type="number" class="form-control" name="scTimeBet" min="0" value="{{ $data->scTimeBet }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">중복배팅수</label>
                                    <select class="form-control" name="scDuplicateBetCount">
                                        @foreach (config('sport_config.RANGE_10') as $time)
                                            <option value="{{$time}}" @if ($data->scDuplicateBetCount == $time) selected @endif>{{$time}}회</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">최대배팅폴더수</label>
                                    <select class="form-control" name="scMaxBetFolderCount">
                                        @foreach (config('sport_config.RANGE_10') as $time)
                                            <option value="{{$time}}" @if ($data->scMaxBetFolderCount == $time) selected @endif>{{$time}}폴더</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
        
                            <td colspan="2" class="">
                                <div class="form-group">
                                    <label class="h-label-38px">다폴더보서스사용여부</label>
                                    <div class="flex-input">
                                        <x-common.toggle_switch_button
                                            isCheck="{{ $data->scIsUseBonusAllFolder ? 1 : 0 }}"
                                            id="scIsUseBonusAllFolder"
                                            name="scIsUseBonusAllFolder"
                                            urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scIsUseBonusAllFolder'])}}"
                                        />
                                        <input type="number" name="scValueUseBonusAllFolder" value="{{ $data->scValueUseBonusAllFolder }}">
                                    </div>
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">3폴더보너스배당</label>
                                    <input type="number" class="form-control" name="sc3FolderBonusOdds" min="0" value="{{ $data->sc3FolderBonusOdds }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">6폴더보너스배당</label>
                                    <input type="number" class="form-control" name="sc6FolderBonusOdds" min="0" value="{{ $data->sc6FolderBonusOdds }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">9폴더보너스배당</label>
                                    <input type="number" class="form-control" name="sc9FolderBonusOdds" min="0" value="{{ $data->sc9FolderBonusOdds }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">배팅취소사용여부</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scCancelBet ? 1 : 0 }}"
                                        id="scCancelBet"
                                        name="scCancelBet"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scCancelBet'])}}"
                                    />
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">일배팅취소가능횟수</label>
                                    <input type="number" class="form-control" name="scMaxCancelSingleBet" min="0" value="{{ $data->scMaxCancelSingleBet }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">배팅후몇초뒤취소가능</label>
                                    <input type="number" class="form-control" name="scSecondCancelAfterBet" min="0" value="{{ $data->scSecondCancelAfterBet }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">시작전몇분전배팅취소가능</label>
                                    <input type="number" class="form-control" name="scMinusCancelAfterBet" min="0" value="{{ $data->scMinusCancelAfterBet }}">
                                </div>
                            </td>
        
                            <td class="">
                                <div class="form-group">
                                    <label class="h-label-38px">배팅자동취소여부</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scAutoCancelBet ? 1 : 0 }}"
                                        id="scAutoCancelBet"
                                        name="scAutoCancelBet"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scAutoCancelBet'])}}"
                                    />
                                </div>
                            </td>
                        </tr>
        
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">출배팅가능여부</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scExitBet ? 1 : 0 }}"
                                        id="scExitBet"
                                        name="scExitBet"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scExitBet'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">축구승무패언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scFootballWinDrawLossOU ? 1 : 0 }}"
                                        id="scFootballWinDrawLossOU"
                                        name="scFootballWinDrawLossOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scFootballWinDrawLossOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">축구승패언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scFootballWinLossOU ? 1 : 0 }}"
                                        id="scFootballWinLossOU"
                                        name="scFootballWinLossOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scFootballWinLossOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">축구 핸디캡 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scFootballHandicapOU ? 1 : 0 }}"
                                        id="scFootballHandicapOU"
                                        name="scFootballHandicapOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scFootballHandicapOU'])}}"
                                    />
                                </div>
                            </td>
        
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">축구 무승부 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scFootballDrawOU ? 1 : 0 }}"
                                        id="scFootballDrawOU"
                                        name="scFootballDrawOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scFootballDrawOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">농구 승패 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBasketballWinLossOU ? 1 : 0 }}"
                                        id="scBasketballWinLossOU"
                                        name="scBasketballWinLossOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scBasketballWinLossOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">농구 핸디캡 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBasketballHandicapOU ? 1 : 0 }}"
                                        id="scBasketballHandicapOU"
                                        name="scBasketballHandicapOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scBasketballHandicapOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">야구 승패 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBaseballWinLossOU ? 1 : 0 }}"
                                        id="scBaseballWinLossOU"
                                        name="scBaseballWinLossOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scBaseballWinLossOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">야구 핸디캡 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBaseballHandicapOU ? 1 : 0 }}"
                                        id="scBaseballHandicapOU"
                                        name="scBaseballHandicapOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scBaseballHandicapOU'])}}"
                                    />
                                </div>
                            </td>
        
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">배구 승패 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scVolleyballWinLossOU ? 1 : 0 }}"
                                        id="scVolleyballWinLossOU"
                                        name="scVolleyballWinLossOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scVolleyballWinLossOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">배구 핸디캡 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scVolleyballHandicapOU ? 1 : 0 }}"
                                        id="scVolleyballHandicapOU"
                                        name="scVolleyballHandicapOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', ['field' => 'scVolleyballHandicapOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">하키 승무패 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scHockeyWinDrawLossOU ? 1 : 0 }}"
                                        id="scHockeyWinDrawLossOU"
                                        name="scHockeyWinDrawLossOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scHockeyWinDrawLossOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">하키 승패 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scHockeyWinLossOU ? 1 : 0 }}"
                                        id="scHockeyWinLossOU"
                                        name="scHockeyWinLossOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scHockeyWinLossOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">하키 핸디캡 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scHockeyHandicapOU ? 1 : 0 }}"
                                        id="scHockeyHandicapOU"
                                        name="scHockeyHandicapOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scHockeyHandicapOU'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">하키 무승부 언더오버</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scHockeyDrawOU ? 1 : 0 }}"
                                        id="scHockeyDrawOU"
                                        name="scHockeyDrawOU"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scHockeyDrawOU'])}}"
                                    />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">메인배당노출여부</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scVisibilityOfMainOdds ? 1 : 0 }}"
                                        id="scVisibilityOfMainOdds"
                                        name="scVisibilityOfMainOdds"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scVisibilityOfMainOdds'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">농구 크로스 노출여부</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBasketballCrossExposure ? 1 : 0 }}"
                                        id="scBasketballCrossExposure"
                                        name="scBasketballCrossExposure"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scBasketballCrossExposure'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">야구 크로스 노출여부</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scBaseballCrossExposure ? 1 : 0 }}"
                                        id="scBaseballCrossExposure"
                                        name="scBaseballCrossExposure"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scBaseballCrossExposure'])}}"
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">배당 옵션 갯수필터</label>
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data->scFilterCountOptionDistribution ? 1 : 0 }}"
                                        id="scFilterCountOptionDistribution"
                                        name="scFilterCountOptionDistribution"
                                        urlAction="{{route('admin.page-setting.sport-config.toggleField', 
                                        ['field' => 'scFilterCountOptionDistribution'])}}"
                                    />
                                </div>
                            </td>
        
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">축구피드</label>
                                    <select class="form-control" name="scSoccerFeed" id="selectscSoccerFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scSoccerFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">농구피드</label>
                                    <select class="form-control" name="scBasketballFeed" id="selectscBasketballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scBasketballFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">야구피드</label>
                                    <select class="form-control" name="scBaseballFeed" id="selectscBaseballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scBaseballFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">배구피드</label>
                                    <select class="form-control" name="scVolleyballFeed" id="selectscVolleyballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scVolleyballFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">아이스하키피드</label>
                                    <select class="form-control" name="scIceHockeyFeed" id="selectscIceHockeyFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scIceHockeyFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
        
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">핸드볼피드</label>
                                    <select class="form-control" name="scHandballFeed" id="selectscHandballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scHandballFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">테니스피드</label>
                                    <select class="form-control" name="scTenisFeed" id="selectscTenisFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scTenisFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">미식축구피드</label>
                                    <select class="form-control" name="scAmericanFootballFeed" id="selectscAmericanFootballFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scAmericanFootballFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">이스포츠피드</label>
                                    <select class="form-control" name="scEsportsFeed" id="selectscEsportsFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scEsportsFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">탁구피드</label>
                                    <select class="form-control" name="scPingPongFeed" id="selectscPingPongFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scPingPongFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="h-label-38px">복싱피드</label>
                                    <select class="form-control" name="scBoxingFeed" id="selectscBoxingFeed">
                                        @foreach (config('sport_config.SERVICE_PROVIDER') as $k => $service)
                                            <option value="{{$k}}" @if ($data->scBoxingFeed == $k) selected @endif>{{$service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>회원낙첨포인트 (%)</td>
                            <td>회원롤링포인트 (%)</td>
                            <td>축배팅최대 배팅금액</td>
                            <td>축배팅최대 당첨금액</td>
        
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
        
                        @foreach (config('site_config.LEVELS') as $level)
                            <tr>
                                <td class="center-middel">{{$level}}레벨</td>
                                @foreach (config('sport_config.FIELDS_SPORT_CONFIG_LEVEL') as $field_name => $type)
                                    @include('Admin.PageSetting.OptionGames.Sports.item', [
                                        'level' => $level, 
                                        'field_name' => $field_name,
                                        'type' => $type
                                    ])
                                @endforeach
                            </tr>
                        @endforeach
                    </table> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <style>
        .table-sport-config .form-group {
            margin-bottom: 0;
        }

        .table input[type="number"] {
            border: none;
            padding: 5px;
            width: 100%;
        }

        .flex-input {
            display: flex;
            gap: 5px;
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
