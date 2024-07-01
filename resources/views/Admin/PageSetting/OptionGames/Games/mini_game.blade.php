{{-- list game cate --}}
<div class="m-t-24 bg-black-2 p-12 radius-6">
    <div class="flex space-between text-light f-s-14">
        <div>
            <div @class([
                'btnstyle1-success active-success' => 'route' == 'route',
                'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
            ])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    엔트리
                </a>
            </div>
        </div>
        @include('Admin.PageSetting.OptionGames.Games.visibility_status')
    </div>
</div>

{{-- list game child --}}
<div class="m-t-24 bg-black-2 p-12 radius-6">
    <div class="flex">
        <div @class([
            'btnstyle1-success active-success' => request('button', 'route') == 'route',
            'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
        ])>
            <a href="{{ route('admin.page-setting.game-config.index', ['gcType' => \App\Models\MiniGameConfig::TYPE_MINI_GAME, 'button' => 'route']) }}"
                @class(['text-light flex justify-center items-center flex-1'])>
                파워볼
            </a>
        </div>
        <div @class([
            'btnstyle1-success active-success' => request('button') == '1',
            'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
        ])>
            <a href="{{ route('admin.page-setting.game-config.index', ['gcType' => \App\Models\MiniGameConfig::TYPE_MINI_GAME, 'button' => '1']) }}"
                @class(['text-light flex justify-center items-center flex-1'])>
                파워사다리
            </a>
        </div>
        <div @class([
            'btnstyle1-success active-success' => request('button') == '2',
            'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
        ])>
            <a href="{{ route('admin.page-setting.game-config.index', ['gcType' => \App\Models\MiniGameConfig::TYPE_MINI_GAME, 'button' => '2']) }}"
                @class(['text-light flex justify-center items-center flex-1'])>
                키노사다리
            </a>
        </div>
    </div>


</div>

{{-- config game child --}}
<div class="m-t-24 bg-black-2 radius-6">
    <div class="box">
        <div class="box-content pt-0 pb-0">
            <form action="{{ route('admin.page-setting.game-config.update', ['gcType' => $gcType]) }}" method="POST"
                id="mini_game_config">
                @csrf
                <table class="table table-bordered cst-table-darkbrown table-input-center mb-0" border="1">
                    <tr>
                        <td rowspan="5" class="h-110" style="width: 7.5%;">
                            <button type="submit" class="btnstyle1 btnstyle1-success height-full width-full p-2">
                                <span class="f-s-14"><strong>파워볼</strong></span><br>
                                <div class="f-s-14 m-t-4">
                                    <strong><i class="fa fa-gear"></i> 설정값 저장</strong>
                                </div>
                            </button>
                        </td>
                        <td class="align-top" style="width: 8%; padding-top: 10px !important">배팅차단</td>
                        <td class="align-top" style="width: 8%; padding-top: 10px !important">유저배팅중지내용</td>
                        <td class="align-top" style="width: 8%; padding-top: 10px !important">배팅마감초</td>
                        <td class="align-top" style="width: 10%; padding-top: 10px !important">중복배팅수</td>
                        <td class="align-top" style="padding-top: 10px !important">파워 홀짝/오버언더 배당</td>
                        <td class="align-top" style="padding-top: 10px !important">일반 홀짝/오버언더 배당</td>
                        <td class="align-top" style="width: 10%; padding-top: 10px !important">일반 소중대 배당</td>
                        <td class="align-top" style="padding-top: 10px !important">파워 숫자 배당</td>
                        <td class="align-top" style="padding-top: 10px !important">파워 홀+오버 짝+언더 배당</td>
                        <td class="align-top" style="padding-top: 10px !important">파워 홀+언더 짝+오버 배당</td>
                    </tr>

                    <tr class="bg-black-darker">
                        <td>
                            <x-common.toggle_switch_button isCheck="{{ $data->gcBlockBet ? 1 : 0 }}" id="gcBlockBet"
                                name="gcBlockBet"
                                urlAction="{{ route('admin.page-setting.game-config.toggleField', ['field' => 'gcBlockBet', 'gcType' => $gcType]) }}"
                                size="normal" />
                        </td>
                        <td>
                            <input type="text" class="form-control" name="gcNoticeBlockBet"
                                value="{{ $data->gcNoticeBlockBet ?? '' }}">
                        </td>
                        <td>
                            <input type="text" class="formatPercent form-control" name="gcTimeBet"
                                value="{{ $data->gcTimeBet ?? 0 }}">
                        </td>

                        <td>
                            <select class="form-control" name="gcDuplicateBetCount">
                                @foreach (config('sport_config.RANGE_10') as $time)
                                    <option value="{{ $time }}"
                                        @if (!empty($data->gcDuplicateBetCount) && $data->gcDuplicateBetCount == $time) selected @endif>{{ $time }}회</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="text" class="formatPercent form-control"
                                name="gcPower_OddEven_OverUnder_BettingOdds"
                                value="{{ $data->gcPower_OddEven_OverUnder_BettingOdds ?? 0 }}">
                        </td>

                        <td>
                            <input type="text" class="formatPercent form-control"
                                name="gcGeneral_OddEven_OverUnder_BettingOdds"
                                value="{{ $data->gcGeneral_OddEven_OverUnder_BettingOdds ?? 0 }}">
                        </td>

                        <td class="flex-input" style="border: 1px">
                            <input type="text" class="formatPercent form-control" name="gcGeneral_SmallBettingOdds"
                                value="{{ $data->gcGeneral_SmallBettingOdds ?? 0 }}">
                            <input type="text" class="formatPercent form-control" name="gcGeneral_MediumBettingOdds"
                                value="{{ $data->gcGeneral_MediumBettingOdds ?? 0 }}">
                            <input type="text" class="formatPercent form-control" name="gcGeneral_LargeBettingOdds"
                                value="{{ $data->gcGeneral_LargeBettingOdds ?? 0 }}">
                        </td>
                        <td>
                            <input type="text" class="formatPercent form-control" name="gcPowerNumberBettingOdds"
                                value="{{ $data->gcPowerNumberBettingOdds ?? 0 }}">
                        </td>
                        <td>
                            <input type="text" class="formatPercent form-control"
                                name="gcPowerOdd_OverEven_UnderBettingOdds"
                                value="{{ $data->gcPowerOdd_OverEven_UnderBettingOdds ?? 0 }}">
                        </td>
                        <td>
                            <input type="text" class="formatPercent form-control"
                                name="gcPowerOdd_UnderEven_OverBettingOdds"
                                value="{{ $data->gcPowerOdd_UnderEven_OverBettingOdds ?? 0 }}">
                        </td>
                    </tr>

                    <tr>
                        <td class="align-top" style="padding-top: 10px !important">일반 홀+오버 짝+언더 배당</td>
                        <td class="align-top" style="padding-top: 10px !important">일반 홀+언더 짝+오버 배당</td>
                        <td class="align-top" style="padding-top: 10px !important">파워 일반 조합 배당</td>

                        <td class="align-top" style="padding-top: 10px !important">일반 홀짝+소|종|대 배당</td>

                        <td class="align-top" style="padding-top: 10px !important">동일옵션 배팅여부</td>

                        <td class="align-top" style="padding-top: 10px !important">조합배팅여부</td>

                        <td class="align-top" style="padding-top: 10px !important">숫자배팅여부</td>
                        <td class="align-top" style="padding-top: 10px !important">노출여부</td>
                        <td class="align-top" style="padding-top: 10px !important"></td>
                        <td class="align-top" style="padding-top: 10px !important"></td>
                    </tr>

                    <tr class="bg-black-darker">
                        <td><input type="text" class="formatPercent form-control"
                                name="gcGeneralOdd_OverEven_UnderBettingOdds"
                                value="{{ $data->gcGeneralOdd_OverEven_UnderBettingOdds ?? 0 }}"></td>
                        <td><input type="text" class="formatPercent form-control"
                                name="gcGeneralOdd_UnderEven_OverBettingOdds"
                                value="{{ $data->gcGeneralOdd_UnderEven_OverBettingOdds ?? 0 }}"></td>
                        <td><input type="text" class="formatPercent form-control"
                                name="gcPowerGeneralCombinationBettingOdds"
                                value="{{ $data->gcPowerGeneralCombinationBettingOdds ?? 0 }}"></td>
                        <td class="flex-input" style="border: 1px">
                            <input type="text" class="formatPercent form-control"
                                name="gcGeneralOddEven_SmallBettingOdds"
                                value="{{ $data->gcGeneralOddEven_SmallBettingOdds ?? 0 }}">
                            <input type="text" class="formatPercent form-control"
                                name="gcGeneralOddEven_MediumBettingOdds"
                                value="{{ $data->gcGeneralOddEven_MediumBettingOdds ?? 0 }}">
                            <input type="text" class="formatPercent form-control"
                                name="gcGeneralOddEven_LargeBettingOdds"
                                value="{{ $data->gcGeneralOddEven_LargeBettingOdds ?? 0 }}">
                        </td>
                        <td>
                            <x-common.toggle_switch_button isCheck="{{ $data->gcSameOptionBettingStatus ? 1 : 0 }}"
                                id="gcSameOptionBettingStatus" name="gcSameOptionBettingStatus"
                                urlAction="{{ route('admin.page-setting.game-config.toggleField', ['field' => 'gcSameOptionBettingStatus', 'gcType' => $gcType]) }}"
                                size="normal" />
                        </td>
                        <td>
                            <x-common.toggle_switch_button isCheck="{{ $data->gcCombinationBettingStatus ? 1 : 0 }}"
                                id="gcCombinationBettingStatus" name="gcCombinationBettingStatus"
                                urlAction="{{ route('admin.page-setting.game-config.toggleField', ['field' => 'gcCombinationBettingStatus', 'gcType' => $gcType]) }}" />
                        </td>
                        <td>
                            <x-common.toggle_switch_button isCheck="{{ $data->gcNumberBettingStatus ? 1 : 0 }}"
                                id="gcNumberBettingStatus" name="gcNumberBettingStatus"
                                urlAction="{{ route('admin.page-setting.game-config.toggleField', ['field' => 'gcNumberBettingStatus', 'gcType' => $gcType]) }}" />
                        </td>
                        <td>
                            <x-common.toggle_switch_button isCheck="{{ $data->gcVisibilityStatus ? 1 : 0 }}"
                                id="gcVisibilityStatus" name="gcVisibilityStatus"
                                urlAction="{{ route('admin.page-setting.game-config.toggleField', ['field' => 'gcVisibilityStatus', 'gcType' => $gcType]) }}" />
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td class="align-top" style="padding-top: 10px !important">회원낙첨포인트(%)</td>
                        <td class="align-top" style="padding-top: 10px !important">회원롤팅포인트(%)</td>
                        <td class="align-top" colspan="2" style="padding-top: 10px !important">최소배팅금액</td>
                        <td class="align-top" colspan="2" style="padding-top: 10px !important">최대배팅금액</td>
                        <td class="align-top" colspan="2" style="padding-top: 10px !important">최대당첨금액</td>
                        <td class="align-top" colspan="2" style="padding-top: 10px !important">최대배당</td>
                    </tr>

                    @foreach (config('site_config.LEVELS') as $level)
                        <tr>
                            <td>{{ $level }} 레별</td>
                            @foreach (config('sport_config.FIELDS_GAME_CONFIG_LEVEL') as $field_name => $type)
                                @include('Admin.PageSetting.OptionGames.Games.item', [
                                    'level' => $level,
                                    'field_name' => $field_name,
                                    'type' => $type,
                                    'colspan' => in_array($field_name, [
                                        'gcMinBetAmount',
                                        'gcMaxBetAmount',
                                        'gcMaxBetPayout',
                                        'gcMaxPayout',
                                    ]),
                                ])
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </form>
        </div>
    </div>
</div>
