@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 위로금 보너스 설정</h3>
                    <button type="submit" form="bonus_config_index_bonus_consolation_prize"
                        class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설정값 저장</button>
                </div>
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusConsolationPrize') }}" method="POST"
                    id="bonus_config_index_bonus_consolation_prize">
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
                                    <div class="col-md-6 p-10">
                                        <div class="m-b-10">
                                            <div class="flex items-center gap-10 p-10">
                                                위로금 이벤트를 이용하는가?
                                                <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                    isCheck="{{ $data['is_available'] ?? false }}"
                                                    id="consolation_prize_bonus-is_available"
                                                    name="consolation_prize_bonus-is_available"
                                                    urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                        'field' => 'consolation_prize_bonus[is_available]',
                                                        'bonusType' => \App\Models\BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS,
                                                    ]) }}"
                                                    width="100px" size="big" />
                                            </div>
                                            <div class="flex items-center gap-10 p-10">
                                                *
                                                <input type="text" placeholder=""
                                                    name="consolation_prize_bonus[minimum_days_no_withdraw_to_paid]"
                                                    class="form-control search-input-box height-36 text-white2 p-5"
                                                    value="{{ $data['minimum_days_no_withdraw_to_paid'] ?? '' }}"
                                                    style="width: 100px">
                                                일 동안 매일 입금 후 출금기록이 없글시 위로금을 지급한다.
                                            </div>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <div class="flex items-center gap-10 p-10">
                                                    입금액
                                                    <input type="text" placeholder=""
                                                        name="consolation_prize_bonus[consolation][{{ $i }}][recharge_amount]"
                                                        class="form-control search-input-box height-36 text-white2 p-5"
                                                        value="{{ $data['consolation'][$i]['recharge_amount'] ?? '' }}"
                                                        style="width: 100px">
                                                    원 이상 ->
                                                    <input type="text" placeholder=""
                                                        name="consolation_prize_bonus[consolation][{{ $i }}][payment_amount]"
                                                        class="form-control search-input-box height-36 text-white2 p-5"
                                                        value="{{ $data['consolation'][$i]['payment_amount'] ?? '' }}"
                                                        style="width: 100px">
                                                    원 지급
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col-md-6 p-0 m-b-10">
                                        <div class="col-md-12 p-3">
                                            <x-common.setting_item title="쪽지" sub-title="">
                                                <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                                    <input
                                                        class="form-control width-full search-input-box height-33 text-white2 p-5 m-b-10"
                                                        type="input" placeholder="제목"
                                                        name="consolation_prize_bonus[note_title]"
                                                        value="{{ $data['note_title'] ?? '' }}">
                                                    <textarea name="consolation_prize_bonus[note_detail]" cols="30" rows="8" class="form-control"
                                                        placeholder="내용">{{ $data['note_detail'] ?? '' }}</textarea>
                                                </div>
                                            </x-common.setting_item>
                                        </div>
                                    </div>
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
