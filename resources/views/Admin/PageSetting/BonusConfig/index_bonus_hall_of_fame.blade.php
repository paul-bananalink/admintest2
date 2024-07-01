@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 명예의 전당 설정</h3>
                    <button type="submit" form="bonus_config_index_bonus_hall_of_fame"
                        class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설정값 저장</button>
                </div>
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusHallOfFame') }}" method="POST"
                    id="bonus_config_index_bonus_hall_of_fame">
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
                                    <x-common.setting_item title="명예의 전당 관리" sub-title="명예의 전당 이용여부">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_available'] ?? false }}"
                                                id="hall_of_fame_bonus-is_available" name="hall_of_fame_bonus-is_available"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'hall_of_fame_bonus[is_available]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_HALL_OF_FAME_BONUS,
                                                ]) }}"
                                                size="big" />
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="닉네임 노출여부" sub-title="명예의 전당에서 닉네임을 보여주는가?">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $data['is_displayed_nickname'] ?? false }}"
                                                id="hall_of_fame_bonus-is_displayed_nickname"
                                                name="hall_of_fame_bonus-is_displayed_nickname"
                                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                                    'field' => 'hall_of_fame_bonus[is_displayed_nickname]',
                                                    'bonusType' => \App\Models\BonusConfig::TYPE_HALL_OF_FAME_BONUS,
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
                                                type="input" placeholder="제목" name="hall_of_fame_bonus[note_title]"
                                                value="{{ $data['note_title'] ?? '' }}">
                                            <textarea name="hall_of_fame_bonus[note_detail]" cols="30" rows="8" class="form-control" placeholder="내용">{{ $data['note_detail'] ?? '' }}</textarea>
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0">
                        <div class="m-t-24 bg-black-2 p-12 radius-6">
                            <div class="flex space-between text-light f-s-14">
                                <div class="flex-1 mr-24">
                                    <div @class([
                                        'btnstyle1-success active-success' => 'route' == 'route',
                                        'btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-5 inline-block mb-5',
                                    ])>
                                        <a href="#" @class([
                                            'text-light flex justify-center items-center flex-1 w-full h-full',
                                        ])>
                                            배당률
                                        </a>
                                    </div>
                                    <div @class([
                                        'btnstyle1-success active-success' => 'route' == '1',
                                        'btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-5 inline-block mb-5',
                                    ])>
                                        <a href="#" @class([
                                            'text-light flex justify-center items-center flex-1 w-full h-full',
                                        ])>
                                            당첨금액
                                        </a>
                                    </div>
                                    <div @class([
                                        'btnstyle1-success active-success' => 'route' == '2',
                                        'btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-5 inline-block mb-5',
                                    ])>
                                        <a href="#" @class([
                                            'text-light flex justify-center items-center flex-1 w-full h-full',
                                        ])>

                                            롤링금액
                                        </a>
                                    </div>
                                    <div @class([
                                        'btnstyle1-success active-success' => 'route' == '3',
                                        'btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-5 inline-block mb-5',
                                    ])>
                                        <a href="#" @class([
                                            'text-light flex justify-center items-center flex-1 w-full h-full',
                                        ])>
                                            연승횟수
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-center gap-10">
                                    <div style="width: 118px">
                                        <x-common.toggle_switch_button isCheck="{{ true }}" content="5천원이하 지급가능"
                                            id="test1" name="test1" urlAction="#" size="big" />
                                    </div>
                                    <div style="width: 118px">
                                        <x-common.toggle_switch_button isCheck="{{ true }}" content="예"
                                            contentOff="아니오" id="test2" name="test2" urlAction="#" size="big" />
                                    </div>
                                    <button type="submit" class="btnstyle1 height-30  btnstyle1-info mr-12">저장</button>
                                </div>
                            </div>
                            <table class="table table-bordered cst-table-darkbrown mt-12">
                                <thead>
                                    {{-- <th class="width-200">
                                        <button id="saveBonusWarningMessage" type="submit"
                                            class="btnstyle1 btnstyle1-success h-31"> <i class="fa fa-cog"></i> 셜정값 저장 저장
                                        </button>
                                    </th> --}}
                                    <th>순위</th>
                                    <th>보너스금액</th>
                                    <th>가라아이디</th>
                                    <th>가라닉네임</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input name="hall_of_fame_bonus[ranking]"
                                                type="text"
                                                value="{{ old('hall_of_fame_bonus.' . 'ranking', $data['ranking'] ?? '') }}"
                                                class="form-control">
                                        </td>
                                        <td>
                                            <input name="hall_of_fame_bonus[bonus_amount]"
                                                type="text"
                                                value="{{ old('hall_of_fame_bonus.' . 'bonus_amount', $data['bonus_amount'] ?? '') }}"
                                                class="form-control">
                                        </td>
                                        <td>
                                            <input name="hall_of_fame_bonus[gala_id]"
                                                type="text"
                                                value="{{ old('hall_of_fame_bonus.' . 'gala_id', $data['gala_id'] ?? '') }}"
                                                class="form-control">
                                        </td>
                                        <td>
                                            <input name="hall_of_fame_bonus[gala_nickname]"
                                                type="text"
                                                value="{{ old('hall_of_fame_bonus.' . 'gala_nickname', $data['gala_nickname'] ?? '') }}"
                                                class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
