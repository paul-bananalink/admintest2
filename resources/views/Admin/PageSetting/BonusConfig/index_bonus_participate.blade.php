@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 입플보너스 설정</h3>
                    <button type="submit" form="bonus_config_index_bonus_participate"
                        class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설정값 저장</button>
                </div>
                <div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
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
                    <form action="{{ route('admin.page-setting.bonus-config.updateBonusParticipate') }}" method="POST"
                        id="bonus_config_index_bonus_participate">
                        @csrf
                        <div class="col-md-12 p-0 text-light">
                            <div class="col-md-12 p-3 bg-black-2">
                                <div class="col-md-12 p-10">
                                    <div class="flex items-center gap-10 p-10">
                                        1. 입플 보너스를 사용하는가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ data_get($data, 'is_use_ipl_bonus') }}"
                                            id="participate_bonus-is_use_ipl_bonus" name="participate_bonus-is_use_ipl_bonus"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'participate_bonus[is_use_ipl_bonus]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_PARTICIPATE_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        2.
                                        @foreach (config('constant_view.BONUS_PARTICIPATE.ipl_bonus_plus_percent') as $key => $value)
                                            {{ $value }}+
                                            <input type="number" placeholder=""
                                                name="participate_bonus[ipl_bonus_plus_percent][{{ $value }}]"
                                                class="form-control search-input-box height-36 text-white2 p-5"
                                                value="{{ data_get($data, "ipl_bonus_plus_percent.$value") }}"
                                                style="width: 100px" step="0.01">
                                            @if ($value != 200)
                                                ,
                                            @endif
                                        @endforeach
                                        , 그외 금액
                                        <input type="number" placeholder="" name="participate_bonus[ipl_bonus_other_percent]"
                                            class="form-control search-input-box height-36 text-white2 p-5"
                                            value="{{ data_get($data, "ipl_bonus_other_percent") }}"
                                            style="width: 100px" step="0.01">
                                        % 지급
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        3. 입플 신청시 스포츠 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_ipl_sports_betting'] ?? false }}"
                                            id="participate_bonus-is_ipl_sports_betting"
                                            name="participate_bonus-is_ipl_sports_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'participate_bonus[is_ipl_sports_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_PARTICIPATE_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        4. 입플 신청시 실시간 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_ipl_realtime_betting'] ?? false }}"
                                            id="participate_bonus-is_ipl_realtime_betting"
                                            name="participate_bonus-is_ipl_realtime_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'participate_bonus[is_ipl_realtime_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_PARTICIPATE_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>

                                    <!-- TODO:page-setting.bonus-config.bonus-participate -->
                                    <div class="flex items-center gap-10 p-10">
                                        5. 입플 신청시 미니게임 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_ipl_minigame_betting'] ?? false }}"
                                            id="participate_bonus-is_ipl_minigame_betting"
                                            name="participate_bonus-is_ipl_minigame_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'participate_bonus[is_ipl_minigame_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_PARTICIPATE_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        6. 입플 신청시 가상스포츠 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_ipl_virtual_sports_betting'] ?? false }}"
                                            id="participate_bonus-is_ipl_virtual_sports_betting"
                                            name="participate_bonus-is_ipl_virtual_sports_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'participate_bonus[is_ipl_virtual_sports_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_PARTICIPATE_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        7. 입플 신청시 파싱카지노 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_ipl_parsing_casino_betting'] ?? false }}"
                                            id="participate_bonus-is_ipl_parsing_casino_betting"
                                            name="participate_bonus-is_ipl_parsing_casino_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'participate_bonus[is_ipl_parsing_casino_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_PARTICIPATE_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>

                                    <!-- TODO:page-setting.bonus-config.bonus-participate2 -->
                                    <div class="flex items-center gap-10 p-10">
                                        8. 입플 신청시 카지노 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_ipl_casino_betting'] ?? false }}"
                                            id="participate_bonus-is_ipl_casino_betting"
                                            name="participate_bonus-is_ipl_casino_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'participate_bonus[is_ipl_casino_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_PARTICIPATE_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        9. 입플 신청시
                                        <input type="number" placeholder="" name="participate_bonus[minimum_ipl_bet_odds]"
                                            class="form-control search-input-box height-36 text-white2 p-5"
                                            value="{{ $data['minimum_ipl_bet_odds'] ?? '' }}"
                                            style="width: 100px" step="0.01">
                                        배당 이상
                                        <input type="number" placeholder=""
                                            name="participate_bonus[minimum_ipl_bet_players]"
                                            class="form-control search-input-box height-36 text-white2 p-5"
                                            value="{{ $data['minimum_ipl_bet_players'] ?? '' }}"
                                            style="width: 100px" step="0.01">
                                        플더이상 배팅가능
                                    </div>

                                    <!-- TODO:page-setting.bonus-config.bonus-participate3 -->
                                    <div class="flex items-center gap-10 p-10">
                                        10. 입플 보너스는 가입후
                                        <input type="number" placeholder=""
                                            name="participate_bonus[ipl_bonus_for_next_recharges_after_sign_up]"
                                            class="form-control search-input-box height-36 text-white2 p-5"
                                            value="{{ $data['ipl_bonus_for_next_recharges_after_sign_up'] ?? '' }}"
                                            style="width: 100px" step="0.01">
                                        번재 입금에 적용되는가?
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        11. 최대지급금액
                                        <input type="text" placeholder=""
                                            name="participate_bonus[maximum_ipl_payment_amount]"
                                            class="form-control search-input-box height-36 text-white2 p-5 formatMoney"
                                            value="{{ $data['maximum_ipl_payment_amount'] ?? '' }}"
                                            style="width: 100px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/toggle_switch/toggle_switch.js', 'resources/vite/js/page_setting/format_money.js'])
@endsection
