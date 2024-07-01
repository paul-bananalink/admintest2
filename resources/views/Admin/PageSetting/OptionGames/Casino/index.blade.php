@extends('Admin.PageSetting.index')

@section('content-child-child')
@include('Admin.PageSetting.OptionGames.setting_label', ['action' => ''])

@php
    $route = request()->route();
    $routeName = $route->getName();
    $gpCode = $route->parameter('gpCode');
@endphp

<div class="box-content-detail">
    <div class="bg-black-3 p-12 radius-6">
        @include('Admin.PageSetting.OptionGames.action_button')
    </div>

    <div class="m-t-24 bg-black-3 p-6 radius-6"> 
        <div class="flex space-between text-light f-s-14 p-6 bg-black-2">
            <div class="flex-1 mr-24">
                @foreach ($gameConfigData['game_pros'] as $index => $item)
                    <div @class(['btnstyle1-success active-success' => (request('gpCode') ? request('gpCode') == $item->gpCode : $index == 0), 'btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-5 inline-block mb-5'])>
                        <a href="{{ route('admin.page-setting.casino-config.index', ['ccType' => request('ccType'), 'gpCode' => data_get($item, 'gpCode')]) }}" @class(['text-light flex justify-center items-center flex-1 w-full h-full'])>
                            {{data_get($item, 'gpName')}}
                        </a>
                    </div>
                @endforeach
                {{-- <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-5 inline-block mb-5'])>
                    <a href="#" @class(['text-light flex justify-center items-center flex-1 w-full h-full'])>
                        비보 게이밍
                    </a>
                </div> --}}
            </div>
            <div class="flex items-center gap-10">모든 게임 일괄 점검:
                <div style="width: 118px">
                    <x-common.toggle_switch_button
                        isCheck="{{ $data->ccBlockBet }}"
                        urlAction="{{ route('admin.page-setting.casino-config.toggleFieldConfig', ['field' => 'ccBlockBet', 'ccType' => $ccType]) }}"
                        content="정상" 
                        contentOff="점검"
                        size="big" />
                </div>
            </div>
        </div>

        <div class="m-t-24 p-6">
            <form action="{{ route('admin.page-setting.casino-config.update', ['ccType' => request('ccType')]) }}" method="POST">
                @csrf
                <input type="hidden" name="gpCode" value="{{ $gameConfigData['game_pro']->gpCode }}">
                <table class="table table-bordered cst-table-darkbrown table-sport-config mb-0" border="1">
                    <tr>
                        <td style="width: 10%">코드</td>
                        <td style="width: 11%">유형</td>
                        <td style="width: 11%">네임</td>
                        <td style="width: 11%">지정네임</td>
                        <td>로고</td>
                        <td>배경이미지</td>
                        <td>대표이미지</td>
                        <td style="width: 8%">점검여부</td>
                        <td>점검 스케줄러</td>
                        <td></td>
                        
                    </tr>
    
                    <tr>
                        <td><input type="text" class="form-control" name="gpNo" value="{{ $gameConfigData['game_pro']->gpNo }}" readonly></td>
                        <td><input type="text" class="form-control" name="gpCategory" value="{{ $gameConfigData['game_pro']->gpCategory }}" readonly></td>
                        <td><input type="text" class="form-control" name="gpName" value="{{ $gameConfigData['game_pro']->gpName }}"></td>
                        <td><input type="text" class="form-control" name="gpNameEn" value="{{ $gameConfigData['game_pro']->gpNameEn }}"></td>
                        <td>
                            <x-common.upload_image
                                index="{{ 0 }}"
                                imageUrl="{{ data_get($gameConfigData, 'game_pro.gpImages.'.$ccType.'.logo') }}"
                                name="gpLogo"
                                width="78"
                                height="78"
                                showDelete="true"
                            />
                        </td>
                        <td>
                            <x-common.upload_image
                                index="{{ 1 }}"
                                imageUrl="{{ data_get($gameConfigData, 'game_pro.gpImages.'.$ccType.'.background') }}"
                                name="gpImgBackground"
                                width="78"
                                height="78"
                                showDelete="true"
                            />
                        </td>
                        <td>
                            <x-common.upload_image
                                index="{{ 2 }}"
                                imageUrl="{{ data_get($gameConfigData, 'game_pro.gpImages.'.$ccType.'.avatar') }}"
                                name="gpAvatar"
                                width="78"
                                height="78"
                                showDelete="true"
                            />
                        </td>
                        <td>
                            <x-common.toggle_switch_button
                                isCheck="{{ !data_get($gameConfigData, 'game_pro.gpMaintenance.'.$ccType.'.enable') }}"
                                content="정상" 
                                contentOff="점검"
                                urlAction="{{route('admin.page-setting.toggle-maintenance-game-provider', ['gpNo' => $gameConfigData['game_pro']->gpNo, 'type' => $ccType])}}"
                                size="big" />
                        </td>
                        <td colspan="2">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="flex mb-6">
                                        <div class="calendar-single radius-4 mr-3">
                                            <i class="fa fa-calendar mr-6" aria-hidden="true"></i>
                                            <input class="js__calendar-single" type="text" name="maintain_from_date" value="{{ $gameConfigData['game_pro']->maintain_time['from_date'] ?? '' }}" >
                                        </div>
                                        <div class="calendar-single radius-4 mr-6">
                                            <i class="fa fa-clock-o mr-6" aria-hidden="true"></i>
                                            <input class="js__calendar-minus" type="text" name="maintain_from_time" value="{{ $gameConfigData['game_pro']->maintain_time['from_time'] ?? '' }}" >
                                        </div> - 
                                    </div>
                                    <div class="flex">
                                        <div class="calendar-single radius-4 mr-3">
                                            <i class="fa fa-calendar mr-6" aria-hidden="true"></i>
                                            <input class="js__calendar-single" type="text" name="maintain_to_date" value="{{ $gameConfigData['game_pro']->maintain_time['to_date'] ?? '' }}" >
                                        </div>
                                        <div class="calendar-single radius-4">
                                            <i class="fa fa-clock-o mr-6" aria-hidden="true"></i>
                                            <input class="js__calendar-minus" type="text" name="maintain_to_time" value="{{ $gameConfigData['game_pro']->maintain_time['to_time'] ?? '' }}" >
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btnstyle1 height-30  btnstyle1-info mr-12">저장</button>
                                </div>
                            </div>
                        </td>
                        
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div class="m-t-24">
        <div class="flex items-center space-between mb-8">
            <div class="text-light">전체 게임갯수 : {{ $gameConfigData['game_count'] }}</div>
            <div class="flex">
                <form action="{{ route('admin.page-setting.casino-config.index', ['ccType' => request('ccType'), 'gpCode' => $gameConfigData['game_pro']->gpCode]) }}">
                    <input type="hidden" name="gpCode" value="{{ $gameConfigData['game_pro']->gpCode }}">
                    <div class="panel-heading-btn-page">
                        <div class="btn-group">
                            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search" value="{{ request("search") }}">
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
                            <button type="submit" form="gameData" class="btnstyle1 height-30  btnstyle1-info mr-12">저장</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <form id="gameData" action="{{ route('admin.page-setting.casino-config.update-game', ['ccType' => request('ccType')]) }}" method="POST">
                @csrf
                <input type="hidden" name="gpCode" value="{{ $gameConfigData['game_pro']->gpCode }}">
                <table class="table table-bordered cst-table-darkbrown table-sport-config" border="1">
                    <tr>
                        <td>카테 고리</td>
                        <td>유형</td>
                        <td>플랫 폼</td>
                        <td>네임</td>
                        <td>지정네임</td>
                        <td>점수</td>
                        <td>반응형</td>
                        <td class="w-250">이미지</td>
                        <td>노출여부</td>
                    </tr>
                    @foreach ($gameConfigData['games'] as $item)
                        <tr>
                            <td><input type="text" class="form-control" name="gData[{{ $item->gNo }}][gpCode]" value="{{ data_get($item, 'gpCode', '') }}" readonly></td>
                            <td><input type="text" class="form-control" name="gData[{{ $item->gNo }}][gType]" value="{{ data_get($item, 'gType', \App\Models\Game::NON_CATEGORIZE) }}" readonly></td>
                            <td><input type="text" class="form-control" name="gData[{{ $item->gNo }}][gPlatform]" value="{{ data_get($item, 'gPlatform', '') }}" readonly></td>
                            <td><input type="text" class="form-control" name="gData[{{ $item->gNo }}][gName]" value="{{ data_get($item, 'gName', '') }}"></td>
                            <td><input type="text" class="form-control" name="gData[{{ $item->gNo }}][gNameEn]" value="{{ data_get($item, 'gNameEn', '') }}"></td>
                            <td><input type="text" class="form-control" name="gData[{{ $item->gNo }}][gPoint]" value="{{ data_get($item, 'gPoint', 0) }}"></td>
                            <td><input type="text" class="form-control" name="gData[{{ $item->gNo }}][gResponsiveType]" value="{{ data_get($item, 'gResponsiveType', '') }}" readonly></td>
                            <td>
                                <div class="flex items-center" style="position: relative;">
                                    <x-common.upload_image
                                        index="{{ $item->gNo }}"
                                        imageUrl="{{ $item->gIconUrl }}"
                                        name="gData[{{ $item->gNo }}][gIconUrl]"
                                        width="125"
                                        height="125"
                                    />
                                    <a href="#" class="btnstyle1 btnstyle1-danger h-31 px-8 m-r-5 fileupload-exists remove-image" style="position: absolute; right: -5px;" data-id="{{ $item->gNo }}" data-dismiss="fileupload"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </div>
                            </td>
                            <td>
                                <x-common.toggle_switch_button
                                    isCheck="{{ $item->gStatus }}"
                                    id="gStatus{{ $item->gNo }}"
                                    urlAction="{{ route('admin.page-setting.casino-config.toggleField', ['field' => 'gStatus', 'gNo' => $item->gNo]) }}"
                                    size="normal"
                                />
                            </td>
                        </tr>
                    @endforeach
                </table>
            </form>
        </div>
        @if ($gameConfigData['games'])
            <div class="text-center">
                {{ $gameConfigData['games']->appends(request()->query())->links('Admin.Common.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('custom-css')
    <style>
        .table-casino-config td{
            vertical-align: top !important;
        }
        
        .table-casino-config .flex-center{
            justify-content: left !important;
        }

        .table-casino-config .form-group{
            margin-bottom: 0;
        }
        .table input[type="number"]{
            border: none;
            padding: 5px;
            width: 100%;
        }
        .flex-input{
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .table .switch{
            margin-bottom: 0
        }
        .table .center-middel{
            text-align: center;
            vertical-align:middle !important;
        }

        .h-label-38px{
            height: 38px;
            overflow: hidden;
        }

    </style>
    @vite([
        'resources/vite/css/toggle-switch/toggle_style.css', 
        'resources/vite/css/page-setting-category/setting_category.css',
        'resources/vite/css/page-casino/casino.css',
    ])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js', 
        'resources/vite/js/page_setting/setting_category.js',
        'resources/vite/js/page_setting/format_money.js',
        'resources/vite/js/page-game-provider/index.js',
        'resources/vite/js/image_upload.js',
    ])
@endsection
