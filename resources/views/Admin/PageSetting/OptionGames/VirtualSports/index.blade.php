@extends('Admin.PageSetting.index')

@section('content-child-child')
    @include('Admin.PageSetting.OptionGames.setting_label', ['action' => ''])
    <div class="box-content-detail bg-black-3">
        <div class="bg-black-2 p-12 radius-6">
            @include('Admin.PageSetting.OptionGames.action_button')
        </div>

        <div class="m-t-24 bg-black-2 p-12 radius-6">
            <div class="flex space-between text-light f-s-14">
                <div class="flex">
                    <div @class([
                        'btnstyle1-success active-success' => request('button', 1) == 1,
                        'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
                    ])>
                        <a href="{{ route('admin.page-setting.virtual-sport-config.index', ['button' => 1]) }}"
                            @class(['text-light flex justify-center items-center flex-1'])>
                            가상축구
                        </a>
                    </div>

                    <div @class([
                        'btnstyle1-success active-success' => request('button') == 2,
                        'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
                    ])>
                        <a href="{{ route('admin.page-setting.virtual-sport-config.index', ['button' => 2]) }}"
                            @class(['text-light flex justify-center items-center flex-1'])>
                            가상야구
                        </a>
                    </div>

                    <div @class([
                        'btnstyle1-success active-success' => request('button') == 3,
                        'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
                    ])>
                        <a href="{{ route('admin.page-setting.virtual-sport-config.index', ['button' => 3]) }}"
                            @class(['text-light flex justify-center items-center flex-1'])>
                            가상경마
                        </a>
                    </div>

                    <div @class([
                        'btnstyle1-success active-success' => request('button') == 4,
                        'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
                    ])>
                        <a href="{{ route('admin.page-setting.virtual-sport-config.index', ['button' => 4]) }}"
                            @class(['text-light flex justify-center items-center flex-1'])>
                            가상개경주 미구현
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-10">노출여부:
                    <div style="width: 118px">
                        <x-common.toggle_switch_button isCheck="{{ $data->vcVisibilityAllStatus ? 1 : 0 }}"
                            id="vcVisibilityAllStatus" name="vcVisibilityAllStatus"
                            urlAction="{{ route('admin.page-setting.virtual-sport-config.toggleField', ['field' => 'vcVisibilityAllStatus']) }}"
                            size="normal" />
                    </div>
                </div>
            </div>
        </div>

        <div class="m-t-24 bg-black-2 radius-6">
            <div class="box">
                <div class="box-content pt-0 pb-0">
                    @include('Admin.PageSetting.OptionGames.VirtualSports.Templates.virtual_sports_temp_1')
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-css')
    <style>
        .table input[type="number"] {
            border: none;
            padding: 5px;
            width: 100%;
        }

        .flex-input {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .table .switch {
            margin-bottom: 0
        }

        .table .center-middel {
            text-align: center;
            vertical-align: middle !important;
        }

        .h-label-38px {
            height: 38px;
            overflow: hidden;
        }
    </style>
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/toggle_switch/toggle_switch.js', 'resources/vite/js/page_setting/format_money.js'])
@endsection
