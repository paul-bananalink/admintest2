@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 일반설정</h3>
                    <button type="submit" form="bonus_config_index_bonus" class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설정값 저장</button>
                </div>
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
                    <form action="{{ route('admin.page-setting.bonus-config.updateBonus') }}" method="POST"
                        id="bonus_config_index_bonus">
                        @csrf
                        <div class="col-md-12 m-0 p-0">
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="보너스지급시 롤링초기화여부"
                                        sub-title="입금보너스를 제외한 보너스 지급시 롤링을 초기화하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_reset_rolling_bonus_is_paid'] ?? false }}"
                                                id="is_reset_rolling_bonus_is_paid" name="is_reset_rolling_bonus_is_paid"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'bonus[is_reset_rolling_bonus_is_paid]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="보너스지급시 회원보유금액체크" sub-title="보너스지급시 회원보유금액을 체크하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_check_balance_upon_payout'] ?? false }}"
                                                id="is_check_balance_upon_payout" name="is_check_balance_upon_payout"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'bonus[is_check_balance_upon_payout]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="보너스 지급 시 유저잔액 체크금액" sub-title="잔액 최대금액">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" name="bonus[paid_amount]"
                                                value="{{ formatNumber(data_get($data, 'paid_amount', 0)) }}">
                                        </div>
                                    </x-common.setting_item>
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
