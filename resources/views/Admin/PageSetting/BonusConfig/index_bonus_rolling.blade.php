@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 콜링포인트</h3>
                    <div class="d-flex gap-10">
                        <x-common.toggle_switch_button content="사용" contentOff="미사용"
                            isCheck="{{ $data['is_available'] ?? false }}" id="rolling_bonus-is_available"
                            name="rolling_bonus-is_available"
                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                'field' => 'rolling_bonus[is_available]',
                                'bonusType' => \App\Models\BonusConfig::TYPE_ROLLING_BONUS,
                            ]) }}"
                            width="100px" size="big" />
                        <button type="submit" form="bonus_config_index_bonus_rolling"
                            class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설졍값
                            저장</button>
                    </div>
                </div>
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusRolling') }}" method="POST"
                    id="bonus_config_index_bonus_rolling">
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
                                <table class="table table-bordered cst-table-darkbrown text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            @foreach (config('site_config.LEVELS') as $level)
                                                <th>레벨{{ $level }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap">요을 %</td>
                                            @foreach (config('site_config.LEVELS') as $level)
                                                <td>
                                                    <input
                                                        class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                        type="input"
                                                        name="rolling_bonus[table][{{ $level }}][percent]"
                                                        value="{{ $data['table'][$level]['percent'] ?? '' }}"
                                                        placeholder="">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap">최대 지급 가능금액(원)</td>
                                            @foreach (config('site_config.LEVELS') as $level)
                                                <td>
                                                    <input
                                                        class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                        type="input"
                                                        name="rolling_bonus[table][{{ $level }}][max_payment_amount]"
                                                        value="{{ $data['table'][$level]['max_payment_amount'] ?? '' }}"
                                                        placeholder="">
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 m-0 p-0">
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="쪽지" sub-title="">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 m-b-10"
                                                type="input" placeholder="제목" name="rolling_bonus[note_title]"
                                                value="{{ $data['note_title'] ?? '' }}">
                                            <textarea name="rolling_bonus[note_detail]" cols="30" rows="8" class="form-control" placeholder="내용">{{ $data['note_detail'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="금액 표시 여부" sub-title="누적금액, 누적 포인트금액를 표시하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_display_the_amount'] ?? false }}"
                                                id="rolling_bonus-is_display_the_amount"
                                                name="rolling_bonus-is_display_the_amount"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'rolling_bonus[is_display_the_amount]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_ROLLING_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="자동지급 사용여부(유저페이지 버튼노출)" sub-title="자동지급을 사용하는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_use_auto_payment'] ?? false }}"
                                                id="rolling_bonus-is_use_auto_payment" name="rolling_bonus-is_use_auto_payment"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'rolling_bonus[is_use_auto_payment]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_ROLLING_BONUS,
                                                ]) }}"
                                                size="big" />
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
