@extends('Admin.PageSetting.index')

@section('content-child-child')
@include('Admin.PageSetting.OptionGames.setting_label', ['action' => ''])

<div class="box-content-detail bg-black-3">
    <div class="bg-black-2 p-12 radius-6">
        @include('Admin.PageSetting.OptionGames.action_button')
    </div>

    @if($gcType == \App\Models\MiniGameConfig::TYPE_MINI_GAME)
        @include('Admin.PageSetting.OptionGames.Games.mini_game')
    @elseif($gcType == \App\Models\MiniGameConfig::TYPE_LOTUS)
        @include('Admin.PageSetting.OptionGames.Games.lotus')
    @elseif($gcType == \App\Models\MiniGameConfig::TYPE_MGM)
        @include('Admin.PageSetting.OptionGames.Games.mgm')
    @elseif($gcType == \App\Models\MiniGameConfig::TYPE_BET_GAGME_TV)
        @include('Admin.PageSetting.OptionGames.Games.bet_game_tv')
    @elseif($gcType == \App\Models\MiniGameConfig::TYPE_VIRTUAL_SPORTS)
        @include('Admin.PageSetting.OptionGames.Games.virtual_sports')
    @endif
</div>
@endsection

@section('custom-css')
    <style>
        .table-realtime-config td{
            vertical-align: top !important;
        }
        
        .table-realtime-config .flex-center{
            justify-content: left !important;
        }

        .table-realtime-config .form-group{
            margin-bottom: 0;
        }
        .table input[type="number"]{
            border: none;
            padding: 5px;
            width: 100%;
        }
        .flex-input{
            display: flex;
            gap: 5px;
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
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js', 
        'resources/vite/js/page_setting/format_money.js'
    ])
@endsection