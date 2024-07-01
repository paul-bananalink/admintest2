@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 쿠폰 사용 설정</h3>
                    <button type="submit" form="bonus_config_index_bonus_coupon"
                        class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설정값 저장</button>
                </div>
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusCoupon') }}" method="POST"
                    id="bonus_config_index_bonus_coupon">
                    @csrf
                    <div class="box-content">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Error!</strong> 
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 m-0 p-0">
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="최대 지급한도" sub-title="쿠폰별 1회 최대 지급한도">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="input" name="coupon_bonus[maximum_payment_limit]"
                                                value="{{ $data['maximum_payment_limit'] ?? '' }}">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관리" sub-title="쿠폰 시스템 이용여부">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_use_coupon'] ?? false }}"
                                                id="coupon_bonus-is_use_coupon" name="coupon_bonus-is_use_coupon"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_coupon]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="진행중인 배팅이 있을 경우 사용이 가능한가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_use_regarding_coupon'] ?? false }}"
                                                id="coupon_bonus-is_use_regarding_coupon"
                                                name="coupon_bonus-is_use_regarding_coupon"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_regarding_coupon]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="잔액이 셋팅 금액 이하일 경우에만 사용 가능합니다.">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="input" name="coupon_bonus[minimum_for_regarding_coupon_amount]"
                                                value="{{ $data['minimum_for_regarding_coupon_amount'] ?? '' }}"
                                                placeholder="">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>

                            <div class="text-light">
                                *참고 사항<br>
                                지급포인트설정 일반 탭에서 보너스 지급시 롤링 초기화 여부가 "아니오"로 세팅되어 있을 경우 배팅제한이 작동하지 않습니다.
                            </div>

                            <div class="col-md-12 p-0">
                                <div class="col-md-2 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="스포츠 배팅이 가능한가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_use_regarding_coupon_for_sports_betting'] ?? false }}"
                                                id="coupon_bonus-is_use_regarding_coupon_for_sports_betting"
                                                name="coupon_bonus-is_use_regarding_coupon_for_sports_betting"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_regarding_coupon_for_sports_betting]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-2 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="실시간 배팅이 가능한가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_use_regarding_coupon_for_realtime_betting'] ?? false }}"
                                                id="coupon_bonus-is_use_regarding_coupon_for_realtime_betting"
                                                name="coupon_bonus-is_use_regarding_coupon_for_realtime_betting"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_regarding_coupon_for_realtime_betting]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-2 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="미니게임 배팅이 가능한가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_use_regarding_coupon_for_minigame_betting'] ?? false }}"
                                                id="coupon_bonus-is_use_regarding_coupon_for_minigame_betting"
                                                name="coupon_bonus-is_use_regarding_coupon_for_minigame_betting"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_regarding_coupon_for_minigame_betting]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-2 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="가상스포츠 배팅이 가능한가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_use_regarding_coupon_for_virtual_sports_betting'] ?? false }}"
                                                id="coupon_bonus-is_use_regarding_coupon_for_virtual_sports_betting"
                                                name="coupon_bonus-is_use_regarding_coupon_for_virtual_sports_betting"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_regarding_coupon_for_virtual_sports_betting]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-2 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="파싱카지노 배팅이 가능한가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_use_regarding_coupon_for_parsing_casino_betting'] ?? false }}"
                                                id="coupon_bonus-is_use_regarding_coupon_for_parsing_casino_betting"
                                                name="coupon_bonus-is_use_regarding_coupon_for_parsing_casino_betting"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_regarding_coupon_for_parsing_casino_betting]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-2 p-3">
                                    <x-common.setting_item title="쿠폰 사용 관련" sub-title="카지노 배팅이 가능한가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_use_regarding_coupon_for_casino_betting'] ?? false }}"
                                                id="coupon_bonus-is_use_regarding_coupon_for_casino_betting"
                                                name="coupon_bonus-is_use_regarding_coupon_for_casino_betting"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'coupon_bonus[is_use_regarding_coupon_for_casino_betting]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="쪽지" sub-title="">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 m-b-10"
                                                type="input" placeholder="제목" name="coupon_bonus[note_title]"
                                                value="{{ $data['note_title'] ?? '' }}">
                                            <textarea name="coupon_bonus[note_detail]" cols="30" rows="8" class="form-control" placeholder="내용">{{ $data['note_detail'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="룰렛 당첨 시 모달내용" sub-title="">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <textarea name="coupon_bonus[roulette_winning_message]" cols="30" rows="8" class="form-control"
                                                style="margin-top: 43px" placeholder="내용">{{ $data['roulette_winning_message'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="룰렛 미당첨 시 모달내용" sub-title="">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <textarea name="coupon_bonus[roulette_not_winning_message]" cols="30" rows="8" class="form-control"
                                                style="margin-top: 43px" placeholder="내용">{{ $data['roulette_not_winning_message'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                        <div class="col-md-12 p-0 text-light">
                            <div class="col-md-12 p-3 bg-black-2">
                                <div class="col-md-4 p-10">
                                    <div class="col-md-12 p-10">
                                        <div class="col-md-4 p-10">
                                            <table class="table table-bordered cst-table-darkbrown text-center">
                                                <tr>
                                                    <td></td>
                                                    <td>금액(원)</td>
                                                    <td>당첨 확률(%)</td>
                                                </tr>
                                                @for ($i = 1; $i <= 8; $i++)
                                                    @php $item = $data['roulette'][$i] @endphp
                                                    <tr>
                                                        <input type="hidden" name="coupon_bonus[roulette][{{ $i }}][id]" value="{{ $item['id'] ?? uniqid() }}">
                                                        <td>
                                                            <input type="color" style="width: 50px; height: 50px" name="coupon_bonus[roulette][{{ $i }}][bgcolor]" 
                                                                value="{{ old('coupon_bonus.roulette.' . $i . '.bgcolor', $item['bgcolor'] ?? 0) }}" />
                                                        </td>
                                                        <td>
                                                            <input type="text" placeholder=""
                                                                name="coupon_bonus[roulette][{{ $i }}][amount]"
                                                                class="form-control search-input-box height-36 text-white2 p-5"
                                                                value="{{ old('coupon_bonus.roulette.' . $i . '.amount', $item['amount'] ?? 0) }}"
                                                                style="width: 100px">
                                                        </td>
                                                        <td>
                                                            <input type="text" placeholder=""
                                                                name="coupon_bonus[roulette][{{ $i }}][percent]"
                                                                class="form-control search-input-box height-36 text-white2 p-5 roulette-percent"
                                                                value="{{ old('coupon_bonus.roulette.' . $i . '.percent', $item['percent'] ?? 0) }}"
                                                                style="width: 100px">
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </table>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-10 p-10" style="color: red">
                                        {{-- 전체 확률 설정 미구현 --}}
                                        확를 용합은 반드시 100%로 맞칩주시기 바랍니다
                                        <input type="text" placeholder="" id="total_percent" style="width: 100px"
                                            class="form-control search-input-box height-36 text-white2 p-5" readonly
                                            {{-- value="{{ array_sum(array_column(array_slice($data['roulette'], 0, 8), 'percent')) }}" --}}
                                            >
                                    </div>
                                </div>

                                <div class="flex items-center gap-10 p-10">
                                    룰렛 자등지급 여부:
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data['is_collet_paid'] ?? false }}"
                                        id="coupon_bonus-is_collet_paid" name="coupon_bonus-is_collet_paid"
                                        urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                            'field' => 'coupon_bonus[is_collet_paid]',
                                            'bonusType' => \App\Models\BonusConfig::TYPE_COUPON_BONUS,
                                        ]) }}" />
                                </div>
                                <div class="flex items-center gap-10 p-10">
                                    쿠폰명:
                                    <input type="text" placeholder="" name="coupon_bonus[coupon_name]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['coupon_name'] ?? '' }}" style="width: 100px">
                                </div>
                                <div class="flex items-center gap-10 p-10">
                                    유효기간:
                                    <input type="text" placeholder="" name="coupon_bonus[expiration_period]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['expiration_period'] ?? '' }}" style="width: 100px">
                                </div>
                                <div class="flex items-center gap-10 p-10">
                                    해당 일에
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_count_1]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_count_1'] ?? '' }}"
                                        style="width: 100px">
                                    회 이상,
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_amount_1]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_amount_1'] ?? '' }}"
                                        style="width: 100px">
                                    원 이상 입금할 경우 룰렛쿠폰
                                    <input type="text" placeholder="" name="coupon_bonus[roulette_coupon_count_1]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['roulette_coupon_count_1'] ?? '' }}"
                                        style="width: 100px">
                                    개 지급
                                </div>
                                <div class="flex items-center gap-10 p-10">
                                    해당 일에
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_count_2]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_count_2'] ?? '' }}"
                                        style="width: 100px">
                                    회 이상,
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_amount_2]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_amount_2'] ?? '' }}"
                                        style="width: 100px">
                                    원 이상 입금할 경우 룰렛쿠폰
                                    <input type="text" placeholder="" name="coupon_bonus[roulette_coupon_count_2]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['roulette_coupon_count_2'] ?? '' }}"
                                        style="width: 100px">
                                    개 지급
                                </div>
                                <div class="flex items-center gap-10 p-10">
                                    해당 일에
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_count_3]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_count_3'] ?? '' }}"
                                        style="width: 100px">
                                    회 이상,
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_amount_3]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_amount_3'] ?? '' }}"
                                        style="width: 100px">
                                    원 이상 입금할 경우 룰렛쿠폰
                                    <input type="text" placeholder="" name="coupon_bonus[roulette_coupon_count_3]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['roulette_coupon_count_3'] ?? '' }}"
                                        style="width: 100px">
                                    개 지급
                                </div>
                                <div class="flex items-center gap-10 p-10">
                                    해당 일에
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_count_4]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_count_4'] ?? '' }}"
                                        style="width: 100px">
                                    회 이상,
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_amount_4]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_amount_4'] ?? '' }}"
                                        style="width: 100px">
                                    원 이상 입금할 경우 룰렛쿠폰
                                    <input type="text" placeholder="" name="coupon_bonus[roulette_coupon_count_4]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['roulette_coupon_count_4'] ?? '' }}"
                                        style="width: 100px">
                                    개 지급
                                </div>
                                <div class="flex items-center gap-10 p-10">
                                    해당 일에
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_count_5]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_count_5'] ?? '' }}"
                                        style="width: 100px">
                                    회 이상,
                                    <input type="text" placeholder="" name="coupon_bonus[minimum_recharge_amount_5]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['minimum_recharge_amount_5'] ?? '' }}"
                                        style="width: 100px">
                                    원 이상 입금할 경우 룰렛쿠폰
                                    <input type="text" placeholder="" name="coupon_bonus[roulette_coupon_count_5]"
                                        class="form-control search-input-box height-36 text-white2 p-5"
                                        value="{{ $data['roulette_coupon_count_5'] ?? '' }}"
                                        style="width: 100px">
                                    개 지급
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

    <script>
        $(document).load('.roulette-percent', () => {
            calcTotalPercent();
        });

        $(document).on('input', '.roulette-percent', () => {
            calcTotalPercent();
        });

        const calcTotalPercent = () => {
            let total_percent = 0;
            $('.roulette-percent').each((i, item) => {
                total_percent += parseFloat($(item).val() == '' ? 0 : $(item).val());
            });
            $('#total_percent').val(total_percent);
            if (total_percent == 100) {
                $('#total_percent').attr('style', 'width: 100px; background-color: green !important');
            } else {
                $('#total_percent').attr('style', 'width: 100px; background-color: red !important');
            }
        }
    </script>
@endsection
