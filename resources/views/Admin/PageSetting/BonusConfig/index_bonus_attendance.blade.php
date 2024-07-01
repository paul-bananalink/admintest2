@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 출석현황 주정산 설정</h3>
                    <button type="submit" form="bonus_config_index_bonus_attendance"
                        class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설정값 저장</button>
                </div>
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusAttendance') }}" method="POST"
                    id="bonus_config_index_bonus_attendance">
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
                        <div class="col-md-12 m-0 p-0">
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="최대 지급한도" sub-title="최대 지급금액">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input name="attendance_bonus[maximum_payment_limit_amount]"
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                value="{{ number_format(data_get($data, 'maximum_payment_limit_amount')) }}"
                                                type="input" placeholder="">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="7일출석 지급요율" sub-title="7일출석 지급요율">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input name="attendance_bonus[7_day_attendance_payment_rate]"
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                value="{{ number_format(data_get($data, '7_day_attendance_payment_rate')) }}"
                                                type="input" placeholder="" step="0.01">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="6일출석 지급요율" sub-title="6일출석 지급요율">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input name="attendance_bonus[6_day_attendance_payment_rate]"
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                value="{{ number_format(data_get($data, '6_day_attendance_payment_rate')) }}"
                                                type="input" placeholder="" step="0.01">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="자동지급 사용여부(유저페이지 버튼노출)" sub-title="자동지급을 사용하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_use_auto_payment'] ?? false }}"
                                                id="attendance_bonus-is_use_auto_payment"
                                                name="attendance_bonus-is_use_auto_payment"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'attendance_bonus[is_use_auto_payment]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_ATTENDANCE_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="월요일에만 지급" sub-title="월요일에만 지급하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_payment_on_monday_only'] ?? false }}"
                                                id="attendance_bonus-is_payment_on_monday_only"
                                                name="attendance_bonus-is_payment_on_monday_only"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'attendance_bonus[is_payment_on_monday_only]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_ATTENDANCE_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <!-- TODO:.page-setting.bonus-config.bonus-attendance -->
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="배팅중 지급여부" sub-title="진행중인 배팅이 있을 시 지급하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_payment_during_betting'] ?? false }}"
                                                id="attendance_bonus-is_payment_during_betting"
                                                name="attendance_bonus-is_payment_during_betting"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'attendance_bonus[is_payment_during_betting]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_ATTENDANCE_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="출금신청 시 지급여부" sub-title="출금신청이 있을 시 지급하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $data['is_payment_upon_withdrawal_request'] ?? false }}"
                                                id="attendance_bonus-is_payment_upon_withdrawal_request"
                                                name="attendance_bonus-is_payment_upon_withdrawal_request"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'attendance_bonus[is_payment_upon_withdrawal_request]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_ATTENDANCE_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                            <!-- TODO:.page-setting.bonus-config.bonus-attendance2 -->
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="쪽지" sub-title="">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 m-b-10"
                                                type="input" placeholder="제목" name="attendance_bonus[note_title]"
                                                value="{{ $data['note_title'] ?? '' }}">
                                            <textarea cols="30" rows="8" class="form-control" placeholder="내용" name="attendance_bonus[note_detail]">{{ $data['note_detail'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="자동지급 성공 메시지" sub-title="">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <textarea cols="30" rows="8" class="form-control" placeholder="내용" style="margin-top: 43px"
                                                name="attendance_bonus[auto_payment_success_message]">{{ $data['auto_payment_success_message'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="자동지급 오류 메시지" sub-title="">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <textarea cols="30" rows="8" class="form-control" placeholder="내용" style="margin-top: 43px"
                                                name="attendance_bonus[auto_payment_error_message]">{{ $data['auto_payment_error_message'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex-space-between p-10">
                        <h3 class="cst_h3"><i class="fa fa-gear"></i> 출석현황 월정산 설정</h3>
                    </div>
                    <div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                        <div class="col-md-12 p-0 text-light">
                            <div class="col-md-12 p-3 bg-black-2">
                                <div class="col-md-12 p-10">

                                    @foreach (config('constant_view.BONUS_ATTENDANCE') as $value)
                                        <div class="flex items-center gap-10 p-10">
                                            <input type="number" placeholder="일"
                                                name="attendance_bonus[milestone_receives_gift][{{ $value }}][day]"
                                                class="form-control search-input-box height-36 text-white2 p-5"
                                                value="{{ $data['milestone_receives_gift'][$value]['day'] ?? '' }}"
                                                style="width: 100px">
                                            일 연속 출석 시
                                            <input type="number" placeholder="원"
                                                name="attendance_bonus[milestone_receives_gift][{{ $value }}][value]"
                                                class="form-control search-input-box height-36 text-white2 p-5"
                                                value="{{ $data['milestone_receives_gift'][$value]['value'] ?? '' }}"
                                                style="width: 100px">
                                            원 지급
                                            <input type="number" placeholder="원"
                                                name="attendance_bonus[milestone_receives_gift][{{ $value }}][roulette]"
                                                class="form-control search-input-box height-36 text-white2 p-5"
                                                value="{{ $data['milestone_receives_gift'][$value]['roulette'] ?? '' }}"
                                                style="width: 100px">
                                            룰렛
                                        </div>
                                    @endforeach

                                    <div class="flex items-center gap-10 p-10">
                                        *일 기준
                                        <input type="text" placeholder=""
                                            name="attendance_bonus[attendance_every_day_payment_amount]"
                                            class="form-control search-input-box height-36 text-white2 p-5 formatMoney"
                                            value="{{ number_format($data['attendance_every_day_payment_amount']) ?? '' }}"
                                            style="width: 100px">
                                        원 이상 입금 시 지급
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
