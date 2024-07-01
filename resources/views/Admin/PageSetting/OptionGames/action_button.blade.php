@php
    $route = request()->route();
    $routeName = $route->getName();
    $gcType = $route->parameter('gcType');
    $ccType = $route->parameter('ccType');
@endphp

<div class="flex">
    <div @class([
        'btnstyle1-success active-success' =>
            url()->current() == route('admin.page-setting.sport-config.index'),
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.sport-config.index') }}" @class(['text-light flex justify-center items-center flex-1'])>
            스포츠
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            url()->current() == route('admin.page-setting.realtime-config.index'),
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.realtime-config.index') }}" @class(['text-light flex justify-center items-center flex-1'])>
            실시간
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.game-config.index' &&
            $gcType == \App\Models\MiniGameConfig::TYPE_MINI_GAME,
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.game-config.index', ['gcType' => \App\Models\MiniGameConfig::TYPE_MINI_GAME]) }}"
            @class(['text-light flex justify-center items-center flex-1'])>
            미니게임
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.game-config.index' &&
            $gcType == \App\Models\MiniGameConfig::TYPE_LOTUS,
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.game-config.index', ['gcType' => \App\Models\MiniGameConfig::TYPE_LOTUS]) }}"
            @class(['text-light flex justify-center items-center flex-1'])>
            로투스
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.game-config.index' &&
            $gcType == \App\Models\MiniGameConfig::TYPE_MGM,
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.game-config.index', ['gcType' => \App\Models\MiniGameConfig::TYPE_MGM]) }}"
            @class(['text-light flex justify-center items-center flex-1'])>
            MGM
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.game-config.index' &&
            $gcType == \App\Models\MiniGameConfig::TYPE_BET_GAGME_TV,
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.game-config.index', ['gcType' => \App\Models\MiniGameConfig::TYPE_BET_GAGME_TV]) }}"
            @class(['text-light flex justify-center items-center flex-1'])>
            벳게임티비
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            $routeName ==
            request()->is('admin/page-setting/virtual-sport-config/*'),
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.virtual-sport-config.index') }}" @class(['text-light flex justify-center items-center flex-1'])>
            가상스포츠
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.casino-config.index' &&
            $ccType == \App\Models\CasinoConfig::TYPE_CASINO,
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.casino-config.index', ['ccType' => \App\Models\CasinoConfig::TYPE_CASINO]) }}"
            @class(['text-light flex justify-center items-center flex-1'])>
            카지노
        </a>
    </div>

    <div @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.casino-config.index' &&
            $ccType == \App\Models\CasinoConfig::TYPE_SLOT,
        'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
    ])>
        <a href="{{ route('admin.page-setting.casino-config.index', ['ccType' => \App\Models\CasinoConfig::TYPE_SLOT]) }}"
            @class(['text-light flex justify-center items-center flex-1'])>
            슬롯
        </a>
    </div>
</div>
