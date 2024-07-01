@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 출석현황 월정산 설정</h3>
                    <button type="submit" form="bonus_config_index_bonus_referral"
                        class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설정값 저장</button>
                </div>
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusReferral') }}" method="POST"
                    id="bonus_config_index_bonus_referral">
                    @csrf
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
                        <div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                            <div class="col-md-12 p-0 text-light">
                                <div class="col-md-12 p-3 bg-black-2">
                                    <div class="col-md-12 p-10">
                                        <h3 class="cst_h3">지인추천1</h3>
                                        <div class="m-b-10">
                                            <div class="flex items-center gap-10 p-10">
                                                1. 추천한 지인이 입금횟수
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_recharge_count_1]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_recharge_count_1'] ?? '' }}"
                                                    style="width: 100px">
                                                회이상, 입금액
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_recharge_amount_1]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_recharge_amount_1'] ?? '' }}"
                                                    style="width: 100px">
                                                원 도달시
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[payment_to_reference_amount_1]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['payment_to_reference_amount_1'] ?? '' }}"
                                                    style="width: 100px">
                                                원을 추천인에게 지급합니다.
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                2. 추천한 지인이 입금횟수
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_recharge_count_2]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_recharge_count_2'] ?? '' }}"
                                                    style="width: 100px">
                                                회이상, 입금액
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_recharge_amount_2]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_recharge_amount_2'] ?? '' }}"
                                                    style="width: 100px">
                                                원 도달시
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[payment_to_reference_amount_2]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['payment_to_reference_amount_2'] ?? '' }}"
                                                    style="width: 100px">
                                                원을 추천인에게 지급합니다.
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                ※ 추천인은 입금총액
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_reference_recharge_amount]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_reference_recharge_amount'] ?? '' }}"
                                                    style="width: 100px">
                                                원 이상, 입금횟수
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_reference_recharge_count]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_reference_recharge_count'] ?? '' }}"
                                                    style="width: 100px">
                                                회 이상인 활성화 회원이어야만 보너스 보상이 지급됩니다.
                                            </div>
                                        </div>
                                        <div class="col-md-12 p-0 m-b-10">
                                            <div class="col-md-3 p-3">
                                                <x-common.setting_item title="쪽지" sub-title="">
                                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                                        <input
                                                            class="form-control width-full search-input-box height-33 text-white2 p-5 m-b-10"
                                                            type="input" placeholder="제목" name="referral_bonus[note_title_1]"
                                                            value="{{ $data['note_title_1'] ?? '' }}">
                                                        <textarea name="referral_bonus[note_detail_1]" cols="30" rows="8" class="form-control" placeholder="내용">{{ $data['note_detail_1'] ?? '' }}</textarea>
                                                    </div>
                                                </x-common.setting_item>
                                            </div>
                                        </div>
                                        <h3 class="cst_h3"><i class="fa fa-gear"></i> 지인추천1 규정</h3>
                                        <div>
                                            <div class="col-md-12 p-3">
                                                <textarea id="referral_rule_1" name="referral_bonus[referral_rule_1]" rows="5" class="form-control js__editor">{{ $data['referral_rule_1'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                            <div class="col-md-12 p-0 text-light">
                                <div class="col-md-12 p-3 bg-black-2">
                                    <div class="col-md-12 p-10">
                                        <h3 class="cst_h3">지인추천2</h3>
                                        <div class="m-b-10">
                                            <div class="flex items-center gap-10 p-10">
                                                1. 추천인의 회원등급이
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_reference_level]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_reference_level'] ?? '' }}"
                                                    style="width: 100px">
                                                이상이어야 해당 보너스를 지급합니다.
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                2. 정산주에 최소
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_reference_settlement_count]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_reference_settlement_count'] ?? '' }}"
                                                    style="width: 100px">
                                                이상 입금하신 활성화 회원이어야 지인 손실금을 정산 받으실수 있습니다.
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                3. 주 3회이상 입금 한 활성화 지인
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[minimum_reference_active_acquaintance_count]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_reference_active_acquaintance_count'] ?? '' }}"
                                                    style="width: 100px">
                                                명 이상 있어야만 지급 대 상이 될니다.
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                4. 매주 리셋하는가?
                                                <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                    isCheck="{{ $data['is_weekly_reset'] ?? false }}"
                                                    id="referral_bonus-is_weekly_reset" name="referral_bonus-is_weekly_reset"
                                                    urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                        'field' => 'referral_bonus[is_weekly_reset]',
                                                        'bonusType' => \App\Models\BonusConfig::TYPE_REFERRAL_BONUS,
                                                    ]) }}"
                                                    width="100px" size="big" />
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                5. 최대지급금액
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[maximum_payment_amount]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['maximum_payment_amount'] ?? '' }}"
                                                    style="width: 100px">
                                                원
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                6. 주정산 요을
                                                <input type="text" placeholder=""
                                                    name="referral_bonus[main_settlement_percent]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['main_settlement_percent'] ?? '' }}"
                                                    style="width: 100px">
                                                %
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                지인추천2 주정산을 이용하는가?
                                                <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                    isCheck="{{ $data['is_use_second_installment_plan'] ?? false }}"
                                                    id="referral_bonus-is_use_second_installment_plan"
                                                    name="referral_bonus-is_use_second_installment_plan"
                                                    urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                        'field' => 'referral_bonus[is_use_second_installment_plan]',
                                                        'bonusType' => \App\Models\BonusConfig::TYPE_REFERRAL_BONUS,
                                                    ]) }}"
                                                    width="100px" size="big" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 p-0 m-b-10">
                                            <div class="col-md-3 p-3">
                                                <x-common.setting_item title="쪽지" sub-title="">
                                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                                        <input
                                                            class="form-control width-full search-input-box height-33 text-white2 p-5 m-b-10"
                                                            type="input" placeholder="제목"
                                                            name="referral_bonus[note_title_2]"
                                                            value="{{ $data['note_title_2'] ?? '' }}">
                                                        <textarea name="referral_bonus[note_detail_2]" cols="30" rows="8" class="form-control" placeholder="내용">{{ $data['note_detail_2'] ?? '' }}</textarea>
                                                    </div>
                                                </x-common.setting_item>
                                            </div>
                                        </div>
                                        <h3 class="cst_h3"><i class="fa fa-gear"></i> 지인추천2 규정</h3>
                                        <div>
                                            <div class="col-md-12 p-3">
                                                <textarea id="referral_rule_2" name="referral_bonus[referral_rule_2]" rows="5" class="form-control js__editor">{{ $data['referral_rule_2'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-0 p-0">
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="입금 및 정산 포함여부" sub-title="지인정 산금이 입금 및 파트너정산에 포합되는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_including_recharge_and_settlement'] ?? false }}"
                                                id="referral_bonus-is_including_recharge_and_settlement"
                                                name="referral_bonus-is_including_recharge_and_settlement"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'referral_bonus[is_including_recharge_and_settlement]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_REFERRAL_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="추천인 레벨" sub-title="추천이 레벨설정">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="input" placeholder="" name="referral_bonus[reference_level]"
                                                value="{{ $data['reference_level'] ?? '' }}">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
