@extends('Admin.PageSetting.index')

@php
    $levels = config('site_config.LEVELS');
    array_pop($levels);
@endphp

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 레벨업 보녀스 설정</h3>
                    <div class="d-flex gap-10">
                        <x-common.toggle_switch_button content="사용" contentOff="미사용"
                            isCheck="{{ $data['is_available'] ?? false }}" id="level_up_bonus-is_available"
                            name="level_up_bonus-is_available"
                            urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                'field' => 'level_up_bonus[is_available]',
                                'bonusType' => \App\Models\BonusConfig::TYPE_LEVEL_UP_BONUS,
                            ]) }}"
                            width="100px" size="big" />
                        <button type="submit" form="bonus_config_index_bonus_level_up"
                            class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설졍값
                            저장</button>
                    </div>
                </div>
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusLevelUp') }}" method="POST"
                    id="bonus_config_index_bonus_level_up">
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
                        <div class="col-md-12 m-0 p-0 text-light">
                            <div class="col-md-12 p-5">
                                <div class="d-flex gap-10">
                                    레벨업 자동화 사용여부
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data['is_use_auto_level_up'] ?? false }}"
                                        id="level_up_bonus-is_use_auto_level_up" name="level_up_bonus-is_use_auto_level_up"
                                        urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                            'field' => 'level_up_bonus[is_use_auto_level_up]',
                                            'bonusType' => \App\Models\BonusConfig::TYPE_LEVEL_UP_BONUS,
                                        ]) }}" />
                                </div>
                                <div class="d-flex gap-10">
                                    레벨업 시 보너스금액 자등지급 여부
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $data['is_use_auto_pay_bonus_level_up'] ?? false }}"
                                        id="level_up_bonus-is_use_auto_pay_bonus_level_up"
                                        name="level_up_bonus-is_use_auto_pay_bonus_level_up"
                                        urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                            'field' => 'level_up_bonus[is_use_auto_pay_bonus_level_up]',
                                            'bonusType' => \App\Models\BonusConfig::TYPE_LEVEL_UP_BONUS,
                                        ]) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-0 p-0">
                            <div class="col-md-12 p-0">
                                <table class="table table-bordered cst-table-darkbrown text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            @foreach ($levels as $level)
                                                <th>레벨{{ $level }} -> 레벨{{ $level + 1 }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap">입금횟수</td>
                                            @foreach ($levels as $level)
                                                @php $level_key = $level . '_' . $level + 1; @endphp
                                                <td>
                                                    <input
                                                        class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                        type="input"
                                                        name="level_up_bonus[table][{{ $level_key }}][recharge_count]"
                                                        value="{{ $data['table'][$level_key]['recharge_count'] ?? '' }}"
                                                        placeholder="">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap">입금액</td>
                                            @foreach ($levels as $level)
                                                @php $level_key = $level . '_' . $level + 1; @endphp
                                                <td>
                                                    <input
                                                        class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                        type="input"
                                                        name="level_up_bonus[table][{{ $level_key }}][recharge_amount]"
                                                        value="{{ $data['table'][$level_key]['recharge_amount'] ?? '' }}"
                                                        placeholder="">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap">보너스 금액</td>
                                            @foreach ($levels as $level)
                                                @php $level_key = $level . '_' . $level + 1; @endphp
                                                <td>
                                                    <input
                                                        class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                        type="input"
                                                        name="level_up_bonus[table][{{ $level_key }}][bonus_amount]"
                                                        value="{{ $data['table'][$level_key]['bonus_amount'] ?? '' }}"
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
                                                type="input" placeholder="제목" name="level_up_bonus[note_title]"
                                                value="{{ $data['note_title'] ?? '' }}">
                                            <textarea name="level_up_bonus[note_detail]" cols="30" rows="8" class="form-control" placeholder="내용">{{ $data['note_detail'] ?? '' }}</textarea>
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
