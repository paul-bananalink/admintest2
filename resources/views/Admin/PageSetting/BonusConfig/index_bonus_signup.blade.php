@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 가입머니 설졍</h3>
                    <button type="submit" form="bonus_config_index_bonus_signup"
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
                    <form action="{{ route('admin.page-setting.bonus-config.updateBonusSignup') }}" method="POST"
                        id="bonus_config_index_bonus_signup">
                        @csrf
                        <div class="col-md-12 p-0 text-light">
                            <div class="col-md-12 p-3 bg-black-2">
                                <div class="col-md-12 p-10">
                                    <div class="flex items-center gap-10 p-10">
                                        1. 신규가입 시
                                        <input type="number" name="signup_bonus[new_membership_signup_money]" placeholder=""
                                            class="form-control search-input-box height-36 text-white2 p-5"
                                            value="{{ $data['new_membership_signup_money'] ?? '0' }}"
                                            style="width: 100px">
                                        원을 자동으로 가입머니로 지급합니다.
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        2. 지인추천회원들에게 가입머니를 지급하는가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_recommended_by_acquaintances_membership_bonuses'] ?? false }}"
                                            id="signup_bonus-is_recommended_by_acquaintances_membership_bonuses"
                                            name="signup_bonus-is_recommended_by_acquaintances_membership_bonuses"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'signup_bonus[is_recommended_by_acquaintances_membership_bonuses]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_SIGNUP_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        3. 가입머니로는 스포츠
                                        <input type="number" name="signup_bonus[minimum_sports_folder]" placeholder=""
                                            class="form-control search-input-box height-36 text-white2 p-5"
                                            value="{{ $data['minimum_sports_folder'] ?? '' }}"
                                            style="width: 100px">
                                        폴더이상 3폴더의 합이
                                        <input type="number" name="signup_bonus[minimum_payout]" placeholder=""
                                            class="form-control search-input-box height-36 text-white2 p-5"
                                            value="{{ $data['minimum_payout'] ?? '' }}" style="width: 100px">
                                        배당이상의 배팅만 성립됩니다.
                                    </div>

                                    <!-- TODO: page-setting.bonus-config.bonus-signup -->
                                    <div class="flex items-center gap-10 p-10">
                                        4. 가입머니를 받고 추가입금을 할경우 위의 규정을 적용받지 않는다.
                                    </div>

                                    <div class="flex items-center gap-10 p-10">
                                        5. 스포츠 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_sports_betting'] ?? false }}"
                                            id="signup_bonus-is_sports_betting" name="signup_bonus-is_sports_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'signup_bonus[is_sports_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_SIGNUP_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        6. 실시간 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_realtime_betting'] ?? false }}"
                                            id="signup_bonus-is_realtime_betting" name="signup_bonus-is_realtime_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'signup_bonus[is_realtime_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_SIGNUP_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>

                                    <!-- TODO: page-setting.bonus-config.bonus-signup2 -->
                                    <div class="flex items-center gap-10 p-10">
                                        7. 미니게임 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_minigame_betting'] ?? false }}"
                                            id="signup_bonus-is_minigame_betting" name="signup_bonus-is_minigame_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'signup_bonus[is_minigame_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_SIGNUP_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>

                                    <div class="flex items-center gap-10 p-10">
                                        8. 가상스포츠 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_virtual_sports_betting'] ?? false }}"
                                            id="signup_bonus-is_virtual_sports_betting"
                                            name="signup_bonus-is_virtual_sports_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'signup_bonus[is_virtual_sports_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_SIGNUP_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        9. 파싱카지노 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_parsing_casino_betting'] ?? false }}"
                                            id="signup_bonus-is_parsing_casino_betting"
                                            name="signup_bonus-is_parsing_casino_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'signup_bonus[is_parsing_casino_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_SIGNUP_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>

                                    <!-- TODO: page-setting.bonus-config.bonus-signup3 -->
                                    <div class="flex items-center gap-10 p-10">
                                        10. 카지노 배팅이 가능한가?
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $data['is_casino_betting'] ?? false }}"
                                            id="signup_bonus-is_casino_betting" name="signup_bonus-is_casino_betting"
                                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                'field' => 'signup_bonus[is_casino_betting]',
                                                'bonusType' => \App\Models\BonusConfig::TYPE_SIGNUP_BONUS,
                                            ]) }}"
                                            width="100px" size="big" />
                                    </div>
                                    <div class="flex items-center gap-10 p-10">
                                        11. 가입머니규정에 대한 쪽지내용
                                    </div>
                                </div>
                                <div class="col-md-3 p-3">
                                    <textarea name="signup_bonus[membership_fee_regulation]" cols="30" rows="8" class="form-control"
                                        placeholder="">{{ $data['membership_fee_regulation'] ?? '' }}</textarea>
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
